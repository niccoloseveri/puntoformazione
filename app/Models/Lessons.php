<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lessons extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'modules_id',
        'classrooms_id',
        'formativeunits_id',
        'courses_id',
        'users_id',
        'starts_at',
        'ends_at',
    ];

    //classrooms_id
    public function classroom() : BelongsTo {
        return $this->belongsTo(Classrooms::class);
    }

    //courses_id
    public function course() : BelongsTo {
        return $this->belongsTo(Courses::class);
    }

    //formativeunits_id
    public function formativeunit() : BelongsTo {
        return $this->belongsTo(Formativeunits::class);
    }

    //users_id
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

}
