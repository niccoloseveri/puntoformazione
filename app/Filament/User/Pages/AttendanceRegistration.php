<?php

namespace App\Filament\User\Pages;

use App\Models\Attendance;
use App\Models\Lessons;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class AttendanceRegistration extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.attendance-registration';
    protected static ?string $title = 'Registrazione Presenze';
    //protected static bool $shouldRegisterNavigation = false;

    //implement auth middleware

    /**
     * Determine if the page should be registered in the navigation.
     *
     * @return bool
     */

     /*
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('Insegnante') || auth()->user()->hasRole('admin');
    }
    */

    public function boot()
    {
        $lessonId=request()->input('lesson');
        $this->registerAttendance($lessonId);
    }

    public function registerAttendance($lessonId)
    {
        // Register attendance
        $userId=auth()->user()->id;

        // Check if attendance already exists
        $existingAttendance = Attendance::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->first();
        if ($existingAttendance) {
            session()->flash('error','Presenza già registrata');
            return;
        }
        // Create new attendance record
        // Check if the lesson is in the past or in the future (2hrs offset)



        // Check if the user is already registered for the lesson
        $isRegistered = Attendance::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->exists();
        if ($isRegistered) {
            session()->flash('error','Sei già registrato per questa lezione');
            return;
        }

        Attendance::create([
            'user_id'=>$userId,
            'lesson_id'=>$lessonId,
            'attend_at'=>now(),
            'status'=>'present',
        ]);
        session()->flash('message','Presenza registrata con successo');
    }
}
