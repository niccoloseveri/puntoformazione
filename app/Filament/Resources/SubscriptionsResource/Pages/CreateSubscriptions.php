<?php

namespace App\Filament\Resources\SubscriptionsResource\Pages;

use App\Filament\Resources\SubscriptionsResource;
use App\Models\Payment_options;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CreateSubscriptions extends CreateRecord
{
    protected static string $resource = SubscriptionsResource::class;

    protected function getHeaderActions(): array
{
    return [
        \Filament\Actions\Action::make('simulatePlan')
            ->label('Simula piano rate')
            ->icon('heroicon-o-calculator')
            ->color('gray')
            ->action(function () {
                try{
                    $state = $this->form->getState();
                    //dd($state);
                    // Mappa i nomi reali del tuo form
                    $courseId        = $state['course']            ?? null;   // id corso
                    $enrolledAt      = $state['start_date']        ?? null;   // enrolled_at
                    $payDay          = $state['pay_day_of_month']  ?? 28;
                    $downPaymentEuro = $state['down_payment']      ?? 0;      // euro
                    $monthlyEuro     = $state['imp_rata']          ?? 0;      // euro (by_amount)
                    $countOpt        = $state['installments_count']       ?? null;   // opzionale: per modalità by_count

                    if (!$courseId) {
                        throw new \RuntimeException('Seleziona un corso.');
                    }

                    /** @var \App\Models\Courses $course */
                    $course = \App\Models\Courses::find($courseId);
                    if (!$course || !$course->end_date) {
                        throw new \RuntimeException('Il corso deve avere una data di fine (ends_at).');
                    }

                    // Prepara input per il builder con i nomi attesi
                    $input = [
                        'enrolled_at'        => $enrolledAt ?: now()->toDateString(),
                        'pay_day_of_month'   => (int) $payDay,
                        'down_payment'       => (float) $downPaymentEuro,  // MoneyCast converte in cent
                        'monthly_amount'     => (float) $monthlyEuro,      // MoneyCast converte in cent
                        // se numero_rate è valorizzato e > 0, il builder entra in modalità by_count
                        'installments_count' => ($countOpt !== null && $countOpt !== '')
                            ? (int) $countOpt
                            : null,
                    ];

                    /** @var \App\Services\InstallmentPlanBuilder $svc */
                    $svc  = app(\App\Services\InstallmentPlanBuilder::class);

                    // Suggerimenti (quota minima o importo stimato) e costruzione righe
                    $tips = $svc->tipsForState($input, $course);
                    $rows = $svc->buildFromState($input, $course)->all();

                    // Calcola totale in centesimi (rows['amount'] è in euro)
                    $totalCents = (int) round(array_reduce(
                        $rows,
                        fn ($c, $r) => $c + (int) round(((float) $r['amount']) * 100),
                        0
                    ));
                    //dd($rows);
                    // Log diagnostico
                        Log::info('[Subscriptions][Simulate] OK', [
                            'course_id'   => $courseId,
                            'rows'        => count($rows),
                            'total_cents' => $totalCents,
                            'minQuota'    => $tips['minQuota']    ?? null,
                            'calcMonthly' => $tips['calcMonthly'] ?? null,
                            'maxCount'    => $tips['maxCount']    ?? null,
                            'payload'     => $input,
                        ]);

                    // Memorizza in sessione per la view di anteprima sotto il form
                    session()->put('simulated_installments', $rows);
                    session()->put('simulated_meta', [
                        'count'       => count($rows),
                        'total'       => $totalCents,
                        'minQuota'    => $tips['minQuota']    ?? null,
                        'calcMonthly' => $tips['calcMonthly'] ?? null,
                        'maxCount'    => $tips['maxCount']    ?? null,
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->title('Simulazione completata')
                        ->body('Rate generate: '.count($rows).' — Totale: € '.number_format($totalCents/100, 2, ',', '.'))
                        ->success()
                        ->send();

                    // ricarica la pagina per forzare la lettura della sessione nella view di anteprima
                    $this->dispatch('refreshPreview');
                }   catch (ValidationException $ve){
                        $flat = collect($ve->errors())->flatten()->join(' | ');
                            Log::warning('[Subscriptions][Simulate] ValidationException', [
                                'message' => $flat,
                            ]);
                            \Filament\Notifications\Notification::make()
                                ->title('Simulazione non valida')
                                ->body($flat)
                                ->danger()
                                ->send();
                    }
                    catch (\Throwable $e) {
                        Log::error('[Subscriptions][Simulate] Error', [
                            'message' => $e->getMessage(),
                            'trace'   => $e->getTraceAsString(),

                        ]);
                        \Filament\Notifications\Notification::make()
                            ->title('Errore durante la simulazione')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
            }),

        //\Filament\Actions\CreateAction::make(),
    ];
}


    protected function afterCreate(): void
{
    $sub = $this->record;
    try {
            // Recupero opzione pagamento in sicurezza
            $opt = $sub->payment_options_id
                ? Payment_options::find($sub->payment_options_id)
                : null;

            if (!$opt) {
                Log::info('[Subscriptions][afterCreate] Nessuna Payment_options associata: salto generazione rate', [
                    'subscription_id' => $sub->id,
                ]);
                return;
            }

            $s=$opt;

    //ds($s,'payment option');
    //ds($sub->payment_options_id);
            $isRateale = str_contains($opt->name, 'rateale') || str_contains($opt->name, 'Rateale');

            Log::info('[Subscriptions][afterCreate] Start', [
                'subscription_id' => $sub->id,
                'payment_option'  => $opt->name,
                'is_rateale'      => $isRateale,
            ]);

    if ($isRateale) {
        $course = $sub->courses()->firstOrFail();
        Log::info('[Subscriptions][afterCreate] Build plan params', [
                    'course_id'          => $course->id,
                    'course_end'         => $course->end_date?->toDateString(),
                    'down_payment_c'     => (int) round($sub->getRawOriginal('down_payment')),
                    'monthly_amount_c'   => (int) round($sub->getRawOriginal('monthly_amount')),
                    'installments_count' => $sub->installments_count,
                    'pay_day'            => $sub->pay_day_of_month,
                ]);

        $rows = app(\App\Services\InstallmentPlanBuilder::class)->build($sub, $course);

        if ($rows->isEmpty()) {
                    Log::warning('[Subscriptions][afterCreate] Nessuna rata generata (rows vuote).', [
                        'subscription_id' => $sub->id,
                    ]);
                } else { $sub->installments()->createMany($rows->toArray()); }

        \Filament\Notifications\Notification::make()
            ->title('Piano rate generato')
            ->body('Create '.$rows->count().' rate.')
            ->success()
            ->send();
        Log::info('[Subscriptions][afterCreate] Piano rate creato', [
            'subscription_id' => $sub->id,
            'created'         => $rows->count(),
        ]);
        }else{
            Log::info('[Subscriptions][afterCreate] Opzione non rateale, nessuna rata creata', [
                'subscription_id' => $sub->id,
                'payment_option'  => $opt->name,
            ]);
        }
    } catch (ValidationException $ve){
        $flat = collect($ve->errors())->flatten()->join(' | ');
            Log::warning('[Subscriptions][afterCreate] ValidationException', [
                'subscription_id' => $sub->id,
                'errors' => $flat,
            ]);
            \Filament\Notifications\Notification::make()
                ->title('Piano rate non generato')
                ->body($flat)
                ->danger()
                ->send();
    }
    catch (\Throwable $e) {
        Log::error('[Subscriptions][afterCreate] Error', [
            'subscription_id' => $sub->id,
                'message'         => $e->getMessage(),
                'trace'           => $e->getTraceAsString(),

        ]);
        \Filament\Notifications\Notification::make()
                ->title('Errore generazione rate')
                ->body($e->getMessage())
                ->danger()
                ->send();
    } finally {


    // svuota anteprima
    session()->forget('simulated_installments');
    session()->forget('simulated_meta');
    }
}

}
