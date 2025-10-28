<?php

namespace App\Filament\Resources\SubscriptionsResource\Pages;

use App\Filament\Resources\SubscriptionsResource;
use App\Models\Payment_options;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

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
            }),

        //\Filament\Actions\CreateAction::make(),
    ];
}


    protected function afterCreate(): void
{
    $sub = $this->record;
    $s=Payment_options::find($sub->payment_options_id);
    ds($s,'payment option');
    //ds($sub->payment_options_id);

    if (str_contains($s->name,'rateale') || str_contains($s->name,'Rateale')) {
        $course = $sub->courses()->firstOrFail();
        $rows = app(\App\Services\InstallmentPlanBuilder::class)->build($sub, $course);
        $sub->installments()->createMany($rows->toArray());

        \Filament\Notifications\Notification::make()
            ->title('Piano rate generato')
            ->body('Create '.$rows->count().' rate.')
            ->success()
            ->send();
    }

    // svuota anteprima
    session()->forget('simulated_installments');
    session()->forget('simulated_meta');
}

}
