<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriptions_id',
        'n_rata',
        'due_date',
        'amount',
        'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => MoneyCast::class,
        'paid_at' => 'datetime',
    ];

    /**
     * Get the subscription that owns the installment.
     */
    public function subscription() : BelongsTo
    {
        return $this->belongsTo(Subscriptions::class);
    }

    /**
     * The payments that belong to the installment.
     */
    public function payments() : BelongsToMany
    {
        return $this->belongsToMany(Payments::class, 'payments_installments', 'installments_id', 'payments_id')
                    ->withPivot('amount_applied')
                    ->withTimestamps();
    }

    //rapid scopes
    public function scopePaid($query)
    {
        return $query->whereNotNull('paid_at');
    }
    public function scopeUnpaid($query)
    {
        return $query->whereNull('paid_at');
    }
    public function scopeOverdue($query)
    {
        return $query->whereNull('paid_at')->where('due_date', '<', now()->toDateString());
    }
}
