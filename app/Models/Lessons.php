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
        'rooms_id',
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
    //function that returns all the users with role "insegnante"
    public function insegnanti()
    {
        return $this->users()->where('role', 'insegnante')->get();
    }

    //teacher
    public function teacher() : BelongsTo {
        return $this->belongsTo(User::class, 'users_id');
    }

    //attendance_id
    public function attendances() {
        return $this->hasMany(Attendance::class,'lesson_id','id');
    }

    //subscriptions: hasManyThrough course
    public function subscriptions() {
        return $this->hasManyThrough(Subscriptions::class, Classrooms::class,'id','classrooms_id','classrooms_id','id');
    }

    //get the rooms associated with the lesson hasOne
    public function rooms() : BelongsTo {
        return $this->belongsTo(Rooms::class, 'rooms_id');
    }

}
