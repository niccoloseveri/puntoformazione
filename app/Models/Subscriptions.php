<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    /**
     * The courses that belong to the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function courses(): HasOne
    {
        return $this->hasOne(Courses::class);
    }

    /**
     * Get the status associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class);
    }

    /**
     * Get the paymentoption associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentoption(): HasOne
    {
        return $this->hasOne(Payment_options::class);
    }

    /**
     * Get the user associated with the Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
