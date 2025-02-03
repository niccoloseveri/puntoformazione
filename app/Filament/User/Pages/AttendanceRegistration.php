<?php

namespace App\Filament\User\Pages;

use App\Models\Attendance;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class AttendanceRegistration extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.attendance-registration';
    protected static ?string $title = 'Registrazione Presenze';
    protected static bool $shouldRegisterNavigation = false;

    //implement auth middleware

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('Insegnante') || auth()->user()->hasRole('admin');
    }


    public function boot()
    {
        $lessonId=request()->input('lesson');
        $this->registerAttendance($lessonId);
    }

    public function registerAttendance($lessonId)
    {
        // Register attendance
        $userId=auth()->user()->id;
        Attendance::create([
            'user_id'=>$userId,
            'lesson_id'=>$lessonId,
            'attend_at'=>now(),
            'status'=>'present',
        ]);
        session()->flash('message','Presenza registrata con successo');
    }
}
