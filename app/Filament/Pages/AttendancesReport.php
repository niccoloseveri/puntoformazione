<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Attendance;
use App\Models\Classrooms;
use App\Models\Courses;
use Carbon\Carbon;

use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class AttendancesReport extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.attendances-report';

    public static function table(Table $table) : Table {
        return $table
            ->query(Attendance::query())
            ->columns([
            Tables\Columns\TextColumn::make('user.full_name')->label('Studente')
            ->formatStateUsing(function ($record) {
                return $record->user->surname. ' ' .$record->user->name. ' ';
            })
            ->html()
            ->sortable('surname')
            ->copyable()
            ,
            Tables\Columns\TextColumn::make('lesson.name')->label('Lezione')
                ->sortable(),
            Tables\Columns\TextColumn::make('status')->label('Stato')

                ->badge()->color(
                    fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'reviewing' => 'warning',
                        'published' => 'success',
                        'rejected' => 'danger',
                }),

            Tables\Columns\TextColumn::make('attend_at')->label('Orario Ingresso')
                ->dateTime()
                ->sortable()
                ->extraAttributes(function (Attendance $att) {
                    $a=Carbon::create($att->lesson->starts_at);
                    if ($a->diffInMinutes($att->attend_at)>=30) {
                        return ['class' => 'bg-red-200 dark:bg-red-500'];
                    }
                    return [];
                }),
           ])
           ->filters([
                Filter::make('courses_id')
                ->form([
                    Select::make('courses_id')->label('Corso')
                    ->live()
                    ->dehydrated(false)
                    ->options(Courses::pluck('name', 'id'))
                    ->placeholder('Seleziona un corso')
                    ->afterStateUpdated(function (Livewire $livewire) {
                        $livewire->reset('data.class_id');
                    }),
                ]),
                Filter::make('class_id')
                ->form([
                    Select::make('class_id')->label('Classe')
                    ->live()
                    ->placeholder(fn (Get $get): string => empty($get('course_id')) ? 'Seleziona prima un corso' : 'Seleziona la classe')
                    ->options(fn($get) => Classrooms::where('course_id', $get('course_id'))->pluck('name', 'id'))
                ]),
                ],layout:FiltersLayout::AboveContent)
           ;

    }
}
