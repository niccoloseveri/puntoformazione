<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formativeunits extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'modules_id',
        'classrooms_id',
        'courses_id',
        'users_id',
    ];

    public function modules() : BelongsTo {
        return $this->belongsTo(Modules::class);
    }

    public function courses() : BelongsTo {
        return $this->belongsTo(Courses::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lessons() : HasMany {
        return $this->hasMany(Lessons::class);
    }

    public function classrooms() : BelongsTo {
        return $this->belongsTo(Classrooms::class);
    }
}
