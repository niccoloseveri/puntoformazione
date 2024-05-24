<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Courses extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'price',
        'exam_price',
        'ass_price',
        'start_date',
        'end_date',
        'year',
        'ore_corso',
        'edition',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => MoneyCast::class,
        'exam_price' => MoneyCast::class,
        'ass_price' => MoneyCast::class,
    ];

    /**
     * Get all of the Classromms for the Courses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classrooms::class,'course_id','id');
    }

    /**
     * The users that belong to the Courses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'subsctiptions')->withPivot('classrooms_id','start_date');
    }

    /**
     * Get all of the Modules for the Courses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Modules::class,'course_id','id');
    }

    public function formativeunits() : HasMany {
        return $this->hasMany(Formativeunits::class);
    }

    public function lessons() : HasMany {
        return $this->hasMany(Lessons::class);
    }

    /**
     * Get all of the subscriptions for the Courses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscriptions::class);
    }


}
