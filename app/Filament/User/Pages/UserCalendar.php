<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class UserCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected ?string $heading = 'Calendario Lezioni';
    protected static ?string $navigationLabel = 'Calendario Lezioni';
    protected static ?string $title= 'Calendario Lezioni';
    protected static ?int $navigationSort = 10;


    protected static string $view = 'filament.user.pages.user-calendar';
}
