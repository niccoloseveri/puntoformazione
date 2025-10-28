<?php

namespace App\Services;

use App\Models\Courses;
use App\Models\Subscriptions;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

/**
 * Genera / simula un piano rate:
 *  - by_amount: dato l’importo mensile, usa i mesi utili fino a fine corso (ultima rata assorbe il resto)
 *  - by_count : dato il numero di rate, calcola l’importo mensile e genera esattamente N rate
 *
 * Tutti i calcoli interni lavorano in CENTESIMI (raw); i rows ritornano importi in EURO
 * perché verranno salvati con MoneyCast.
 */
class InstallmentPlanBuilder
{
    public function build(Subscriptions $sub, Courses $course): Collection
    {
        $price  = (int) round($course->getRawOriginal('price'));
        $acconto= (int) round($sub->getRawOriginal('down_payment'));
        $resid  = max(0, $price - $acconto);

        $start  = Carbon::parse($sub->enrolled_at ?: now());
        $end    = Carbon::parse($course->end_date)->endOfDay();
        $day    = (int) ($sub->pay_day_of_month ?: 28);

        // Mesi utili (una rata al mese)
        $dueDates = $this->collectDueDates($start, $end, $day);
        $monthsAvailable = $dueDates->count();

        if ($monthsAvailable === 0 && $resid > 0) {
            throw ValidationException::withMessages([
                'monthly_amount' => 'Il corso termina prima della prima scadenza utile.',
            ]);
        }
        $mode = $sub->installments_mode ?: 'by_amount';
        if ($mode === 'by_count') {

            $n = (int) ($sub->installments_count ?? 0);
            if ($n < 1) {
                throw ValidationException::withMessages([
                    'installments_count' => 'Inserisci un numero di rate valido (>= 1).',
                ]);
            }
            if ($n > $monthsAvailable) {
                throw ValidationException::withMessages([
                    'installments_count' => 'Troppe rate per la durata del corso. Massimo consentito: '.$monthsAvailable,
                ]);
            }

            // Date: prime N scadenze
            $dates = $dueDates->take($n);

            // Importi: ripartizione in centesimi con ultima rata che assorbe il resto
            $rows = collect();
            if ($resid === 0) {
                // nessun residuo → niente rate
                return $rows;
            }

            $base = intdiv($resid, $n);           // quota "pari" in cent
            $rem  = $resid - ($base * ($n - 1));  // ultima rata = residuo rimanente

            foreach ($dates->values() as $i => $date) {

                $amountCents = ($i === $n - 1) ? $rem : $base;
                if ($amountCents <= 0) continue;

                $rows->push([
                    'sequence'   => $i + 1,
                    'due_date'   => $date->toDateString(),
                    'amount'     => $amountCents / 100, // EURO (MoneyCast salverà in cent)
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return $rows;
        }

        // --- by_amount (default) ---

        $monthlyCents = (int) round($sub->imp_rata*100);

        if ($monthlyCents <= 0 && $resid > 0) {

            throw ValidationException::withMessages([
                'imp_rata' => 'Inserisci un importo rata valido (> 0).',
            ]);
        }

        // se l’importo non basta a coprire il residuo entro fine corso → errore con suggerimento
        if (($monthlyCents * $monthsAvailable) < $resid) {

            $min = (int) ceil($resid / max(1, $monthsAvailable));
            throw ValidationException::withMessages([
                'imp_rata' => 'Importo rata insufficiente. Quota minima: € '.number_format($min/100, 2, ',', '.'),
            ]);
        }

        // Genera mese per mese finché c’è residuo; ultima rata assorbe resto
        $rows = collect();
        $remaining = $resid;

        foreach ($dueDates as $i => $date) {

            if ($remaining <= 0) break;

            $isLast = ($i === $monthsAvailable - 1);
            $amountCents = $isLast ? $remaining : min($monthlyCents, $remaining);
            $remaining -= $amountCents;

            if ($amountCents > 0) {
                $rows->push([
                    'sequence'   => $rows->count() + 1,
                    'due_date'   => $date->toDateString(),
                    'amount'     => $amountCents / 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return $rows;
    }

    /** Anteprima senza salvare (usa state del form) */
    public function buildFromState(array $state, Courses $course): Collection
    {
        $sub = new Subscriptions([
            'enrolled_at'       => $state['enrolled_at'] ?? now()->toDateString(),
            'pay_day_of_month'  => (int)($state['pay_day_of_month'] ?? 28),
            'down_payment'      => (float)($state['down_payment'] ?? 0),
            'imp_rata'    => (float)($state['monthly_amount'] ?? 0),
            'installments_mode' => $state['installments_mode'] ?? 'by_amount',
            'installments_count'=> $state['installments_count'] ?? null,
        ]);

        return $this->build($sub, $course);
    }

    /**
     * Suggerimenti per la UI:
     *  - by_amount: ritorna minQuota (euro) se insufficiente, altrimenti null
     *  - by_count : ritorna array ['calcMonthly' => importo stimato (euro)] e/o ['maxCount' => mesi disponibili]
     */
    public function tipsForState(array $state, Courses $course): array
    {
        $price  = (int) round($course->getRawOriginal('price'));
        $down   = (int) round((new Subscriptions($state))->getRawOriginal('down_payment'));
        $resid  = max(0, $price - $down);

        $enrolledAt = Carbon::parse($state['enrolled_at'] ?? now());
        $end        = Carbon::parse($course->ends_at)->endOfDay();
        $day        = (int)($state['pay_day_of_month'] ?? 28);

        $monthsAvailable = $this->collectDueDates($enrolledAt, $end, $day)->count();
        $mode = $state['installments_mode'] ?? 'by_amount';

        if ($mode === 'by_count') {
            $n = (int) ($state['installments_count'] ?? 0);
            $out = ['maxCount' => $monthsAvailable];
            if ($n > 0 && $resid > 0 && $n <= $monthsAvailable) {
                $calc = (int) ceil($resid / $n); // cent
                $out['calcMonthly'] = $calc / 100;
            }
            return $out;
        }

        // by_amount
        $monthlyCents = (int) round((new Subscriptions($state))->getRawOriginal('monthly_amount'));
        if ($monthsAvailable === 0 && $resid > 0) return ['error' => 'Nessun mese utile per la rata.'];
        if ($monthlyCents * $monthsAvailable < $resid) {
            $min = (int) ceil($resid / max(1, $monthsAvailable));
            return ['minQuota' => $min / 100];
        }
        return [];
    }

    /** Raccoglie tutte le scadenze mensili tra start ed end, rispettando il day */
    private function collectDueDates(Carbon $start, Carbon $end, int $day): Collection
    {
        $dates = collect();
        $first = $this->firstDueDate($start, $day);

        for ($d = $first->copy(); $d->lte($end); $d->addMonthNoOverflow()) {
            $dates->push($d->copy());
        }
        return $dates;
    }

    private function firstDueDate(Carbon $from, int $day): Carbon
    {
        $candidate = $from->copy()->day(min($day, $from->daysInMonth));
        if ($candidate->lt($from)) {
            $nextMonth = $from->copy()->addMonthNoOverflow();
            $candidate = $nextMonth->copy()->day(min($day, $nextMonth->daysInMonth));
        }
        return $candidate->startOfDay();
    }
}
