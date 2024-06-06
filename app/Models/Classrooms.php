<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classrooms extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'course_id',
    ];

    /**
     * Get the Course that owns the Classrooms
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class);
    }

     /**
     * The users that belong to the Classrooms
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'subscriptions')->withPivot('courses_id','start_date');
    }

    /**
     * Get all of the subscriptions for the Classrooms
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscriptions::class);
    }

    public function lessons() : HasMany {
        return $this->hasMany(Lessons::class);
    }

    public function formativeunits() : HasMany {
        return $this->hasMany(Formativeunits::class);
    }
}
