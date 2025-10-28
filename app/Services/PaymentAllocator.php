<?php

namespace App\Services;

use App\Models\Installment;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;

class PaymentAllocator
{
    /**
     * Alloca amount_paid del Payment alle rate aperte (stesso user+course), FIFO.
     * Idempotente: applica solo l'importo non ancora allocato.
     */
    public function allocate(Payments $payment): void
    {
        DB::transaction(function () use ($payment) {
            $paidTotalCents = (int) round($payment->getRawOriginal('amount_paid'));

            $alreadyAllocated = (int) $payment->installments()->sum('payment_installment.amount_applied');
            $remaining = max(0, $paidTotalCents - $alreadyAllocated);
            if ($remaining <= 0) return;

            $query = Installment::query()
                ->whereHas('subscription', function ($q) use ($payment) {
                    $q->where('users_id', $payment->users_id)
                      ->where('courses_id', $payment->courses_id);
                })
                ->orderBy('due_date')
                ->orderBy('sequence');

            foreach ($query->cursor() as $inst) {
                if ($remaining <= 0) break;

                $due  = (int) round($inst->getRawOriginal('amount'));
                $paid = (int) $inst->payments()->sum('payment_installment.amount_applied');
                $balance = max(0, $due - $paid);

                if ($balance === 0) {
                    if (is_null($inst->paid_at)) $inst->forceFill(['paid_at'=>now()])->save();
                    continue;
                }

                $apply = min($balance, $remaining);

                $payment->installments()->attach($inst->id, [
                    'amount_applied' => $apply,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($apply === $balance) $inst->forceFill(['paid_at'=>now()])->save();

                $remaining -= $apply;
            }
        });
    }

    /** De-alloca una certa quota tra un payment e una rata. */
    public function deallocate(Payments $payment, Installment $installment, int $amountCents): void
    {
        DB::transaction(function () use ($payment, $installment, $amountCents) {
            $pivot = $payment->installments()
                ->where('installment_id', $installment->id)
                ->first()?->pivot;

            if (!$pivot) return;

            $current = (int) $pivot->amount_applied;
            $remove  = min($current, max(0, $amountCents));
            if ($remove <= 0) return;

            $new = $current - $remove;

            if ($new === 0) {
                $payment->installments()->detach($installment->id);
            } else {
                $payment->installments()->updateExistingPivot($installment->id, [
                    'amount_applied' => $new,
                    'updated_at'     => now(),
                ]);
            }

            // Ricalcola stato rata
            $due  = (int) round($installment->getRawOriginal('amount'));
            $paid = (int) $installment->payments()->sum('payment_installment.amount_applied');
            if ($paid < $due && !is_null($installment->paid_at)) {
                $installment->forceFill(['paid_at' => null])->save();
            }
        });
    }

    /** De-alloca TUTTE le allocazioni del pagamento da tutte le rate. */
    public function deallocateAll(Payments $payment): void
    {
        DB::transaction(function () use ($payment) {
            $allocations = $payment->installments()->get();
            foreach ($allocations as $inst) {
                $pivotAmount = (int) $payment->installments()
                    ->where('installment_id', $inst->id)
                    ->sum('payment_installment.amount_applied');
                if ($pivotAmount > 0) {
                    $this->deallocate($payment, $inst, $pivotAmount);
                }
            }
        });
    }
}
