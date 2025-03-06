<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class AttendancesReport extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected static ?string $navigationLabel = 'Custom Navigation Label';
}
