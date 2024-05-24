<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'statuses_id',
        'next_payment',
        'printed_cont',
        'printed_priv',
        'printed_whats',
        'is_active'

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



}
