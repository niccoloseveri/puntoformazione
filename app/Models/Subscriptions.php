<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscriptions extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable=[
        //
        'user_id',
        'courses_id',
        'classrooms_id',
        'payment_options_id',
        'is_teacher',
        'start_date',
        'imp_rata',
        'statuses_id',
        'next_payment',
        'printed_cont',
        'printed_priv',
        'printed_whats',
        'is_active',
        'pay_day_of_month',
        'down_payment',
        'installments_count',
        'installments_mode',

    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'imp_rata' => MoneyCast::class,
        'down_payment' => MoneyCast::class,
        //'payment_date' => 'date'
    ];

    /**
     * Get the user associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The courses that belong to the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courses(): BelongsTo
    {
        return $this->belongsTo(Courses::class);
    }

    /**
     * Get the classrooms associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classrooms(): BelongsTo
    {
        return $this->belongsTo(Classrooms::class);
    }

    /**
     * Get the paymentoption associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentoptions(): BelongsTo
    {
        return $this->belongsTo(Payment_options::class,'payment_options_id');
    }

    /**
     * Get the status associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class,'statuses_id');
    }

    /**
     * Get the attendance associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id', 'user_id');
    }

    /**
     * Get the installments for the subscription.
     */
    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }



}
