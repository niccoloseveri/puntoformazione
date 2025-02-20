<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lessons extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'modules_id',
        'classrooms_id',
        'formativeunits_id',
        'courses_id',
        'users_id',
        'starts_at',
        'ends_at',
        'qr_code',
        'options',
    ];

    protected $casts=[
        'options'=>'array',
    ];

    //classrooms_id
    public function classrooms() : BelongsTo {
        return $this->belongsTo(Classrooms::class);
    }

    //courses_id
    public function courses() : BelongsTo {
        return $this->belongsTo(Courses::class);
    }

    //formativeunits_id
    public function formativeunit() : BelongsTo {
        return $this->belongsTo(Formativeunits::class);
    }

    //users_id
    public function users() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    //docente
    /*
    public function docente() {
        return
    }
    */

    //attendance_id
    public function attendances() {
        return $this->hasMany(Attendance::class,'lesson_id','id');
    }

}
