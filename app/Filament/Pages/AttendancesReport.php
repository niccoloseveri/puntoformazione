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
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as Collection;

class AttendancesReport extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'gmdi-perm-contact-calendar';

    protected static string $view = 'filament.pages.attendances-report';
    protected static ?string $navigationLabel = 'Report Presenze';
    protected static ?string $title = 'Report Presenze';

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
            Tables\Columns\TextColumn::make('lessons.name')->label('Lezione')
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
                ->dateTime('d/m/Y H:i:s')
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
                        ->native(false),
                    Select::make('classrooms_id')->label('Classe')
                        ->options(fn (Get $get):Collection => Classrooms::query()
                            ->where('course_id', $get('courses_id'))
                            ->pluck('name', 'id')
                        )
                        ->preload()
                        ->native(false)
                ])
                ->columns(2)
                ->columnSpanFull()
                ->query(function (Builder $query, array $data):Builder{
                    if (isset($data['courses_id'])) {
                        $query->whereHas('lesson', function (Builder $query) use ($data) {
                            $query->where('courses_id', $data['courses_id']);
                        });
                    }
                    if (isset($data['classrooms_id'])) {
                        $query->whereHas('lesson', function (Builder $query) use ($data) {
                            $query->where('classrooms_id', $data['classrooms_id']);
                        });
                    }
                    return $query;
                })
                ->indicateUsing(function (array $data) : array {
                    $indicators=[];
                    if($data['courses_id'] ?? null){
                        $indicators[] = Indicator::make('Corso: '.Courses::find($data['courses_id'])->name)
                        ->removeField('courses_id');
                    }
                    if($data['classrooms_id'] ?? null){
                        $indicators[] = Indicator::make('Classe: '.Classrooms::find($data['classrooms_id'])->name)
                        ->removeField('classrooms_id');
                    }
                    return $indicators;
                }),
                //lesson filter
                Filter::make('lessons_id')
                ->form([
                    Select::make('lessons_id')->label('Lezione')
                        ->options(fn (Get $get):Collection => \App\Models\Lessons::query()
                            ->where('courses_id', $get('courses_id'))
                            ->where('classrooms_id', $get('classrooms_id'))
                            ->pluck('name', 'id')
                        )
                        ->placeholder('Seleziona una lezione')
                        ->preload()
                        ->native(false),
                ])

                ],layout:FiltersLayout::AboveContent)
           ;

    }
}
