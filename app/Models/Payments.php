<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'courses_id',
        'total_amount',
        'discount',
        'amount_paid',
        'is_paid',
        'payment_date',
        'payment_method',
        'classrooms_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => MoneyCast::class,
        'discount' => MoneyCast::class,
        'amount_paid' => MoneyCast::class,
        //'payment_date' => 'date'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'courses_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classrooms::class, 'classrooms_id');
    }

    public function getIsPaidAttribute($value)
    {
        return $value ? 'Pagato' : 'Non Pagato';
    }

    public function getPaymentDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getPaymentMethodAttribute($value)
    {
        return match ($value) {
            'cash' => 'Contanti',
            'credit_card' => 'Carta di Credito',
            'bank_transfer' => 'Bonifico Bancario',
            default => 'Altro',
        };
    }
}
