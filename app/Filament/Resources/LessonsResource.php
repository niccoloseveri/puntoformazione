<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonsResource\Pages;
use App\Filament\Resources\LessonsResource\RelationManagers;
use App\Models\Classrooms;
use App\Models\Formativeunits;
use App\Models\Lessons;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class LessonsResource extends Resource
{
    protected static ?string $model = Lessons::class;

    protected static ?string $navigationIcon = 'gmdi-view-module-r';
    protected static ?string $navigationGroup = 'Didattica';
    protected static ?string $modelLabel = 'Lezione';
    protected static ?string $pluralModelLabel = 'Lezioni';
    protected static ?int $navigationSort = 5;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome Lezione')
                    ->required(),
                Select::make('users_id')
                    ->label('Docente')
                    ->relationship('users', 'full_name', modifyQueryUsing: fn (Builder $query) => $query->whereHas('roles', function ($query) {
                        $query->where('name', 'insegnante');
                    })->orderBy('surname'))
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->surname} {$record->name}")
                    ->required(),
                DateTimePicker::make('starts_at')
                    ->label('Data e Ora Inizio')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->label('Data e Ora Fine')
                    ->required(),
                Select::make('courses_id')
                    ->label('Corso')
                    ->relationship('courses', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                Select::make('classrooms_id')
                    ->label('Classe')
                    ->relationship('classrooms', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->hidden(
                        fn(Get $get) :bool => !$get('courses_id')
                    )
                    ->options(
                        fn($get) =>
                            Classrooms::where('course_id',$get('courses_id'))->pluck('name','id')
                    )
                    ->required(),

                /*
                Select::make('formativeunits_id')
                    ->live()
                    ->label('Unità Formativa')
                    ->relationship('formativeunit', 'title')
                    ->searchable()
                    ->preload()
                    ->hidden(
                        fn(Get $get) :bool => !$get('classrooms_id')
                    )
                    ->options(
                        fn($get) =>
                            Formativeunits::where('courses_id',$get('course_id'))->where('classrooms_id',$get('classrooms_id'))->pluck('title','id')
                    )
                    ->required(function($get){
                        Formativeunits::where('courses_id',$get('course_id'))->where('classrooms_id',$get('classrooms_id'))->pluck('title','id')->count() > 0;
                    }),
                    */


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('starts_at', 'desc')
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome Lezione'),
                Tables\Columns\TextColumn::make('courses.name')->label('Corso'),
                Tables\Columns\TextColumn::make('users.full_name')->label('Docente'),
                Tables\Columns\TextColumn::make('classrooms.name')->label('Classe'),
                Tables\Columns\TextColumn::make('starts_at')->label('Inizio')->dateTime('d/m/Y H:i'),])
            ->filters([
                //
                DateRangeFilter::make('starts_at')
                    ->label('Data e Ora')
                    ->placeholder('Seleziona un intervallo di date')
                    ->columnSpan(2)
                    ,
                SelectFilter::make('classrooms')
                    ->relationship('classrooms', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->label('Classe')
                    ->placeholder('Seleziona una classe'),
                SelectFilter::make('users')->label('Docente')
                    ->relationship('users', 'full_name', modifyQueryUsing: fn (Builder $query) => $query->whereHas('roles', function ($query) {
                        $query->where('name', 'insegnante');
                    })->orderBy('surname'))
                    ->preload()
                    ->placeholder('Seleziona un docente')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->surname} {$record->name}"),


            ],layout: FiltersLayout::AboveContent)
            ->groups([
                Group::make('classrooms.name')->label('Classe')->collapsible(),
            ])
            ->defaultGroup('classrooms.name')
            ->groupingSettingsHidden()
            ->actions([
                Tables\Actions\Action::make('qr-code')
                    ->fillForm(fn(Model $record) => [
                        'qr-options' => \LaraZeus\Qr\Facades\Qr::getDefaultOptions(),// or $record->qr-options
                        'qr-data' => config('app.url').'/user/attendance-registration?lesson='.$record->id,// or $record->url
                    ])
                    ->form(\LaraZeus\Qr\Facades\Qr::getFormSchema('qr-data', 'qr-options'))
                    ->action(fn($data) => dd($data))
                    ->icon('gmdi-qr-code-2')
                    ->visible(function(Model $record){
                        $a=Carbon::createFromFormat('Y-m-d H:i:s',$record->starts_at);
                        if($a->isPast()){
                            if($a->isToday()){
                                return true;
                            }
                        }else if($a->isToday() || $a->isFuture()){
                            return true;
                        }
                        return false;
                    }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLessons::route('/create'),
            'edit' => Pages\EditLessons::route('/{record}/edit'),
        ];
    }
}
