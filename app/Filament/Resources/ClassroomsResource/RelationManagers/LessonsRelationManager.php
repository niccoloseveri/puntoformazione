<?php

namespace App\Filament\Resources\ClassroomsResource\RelationManagers;

use App\Filament\Resources\LessonsResource;
use App\Models\Classrooms;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';
    protected static ?string $title = 'Lezioni';


    public function form(Form $form): Form
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
                    })->orderBy('surname'))                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->surname} {$record->name}")
                    ->required(),
                DateTimePicker::make('starts_at')
                    ->label('Data e Ora Inizio')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->label('Data e Ora Fine')
                    ->required(),
                /*Select::make('courses_id')
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
                    */
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome Lezione'),
                Tables\Columns\TextColumn::make('courses.name')->label('Corso'),
                Tables\Columns\TextColumn::make('users.full_name')->label('Docente'),
                Tables\Columns\TextColumn::make('classrooms.name')->label('Classe'),
                Tables\Columns\TextColumn::make('starts_at')->label('Inizio'),])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('qr-code')
                    ->fillForm(fn(Model $record) => [
                        'qr-options' => \LaraZeus\Qr\Facades\Qr::getDefaultOptions(),// or $record->qr-options
                        'qr-data' => config('app.url').'/user/attendance-registration?lesson='.$record->id,// or $record->url
                    ])
                    ->form(\LaraZeus\Qr\Facades\Qr::getFormSchema('qr-data', 'qr-options'))
                    ->action(fn($data) => dd($data))
                    ->icon('gmdi-qr-code-2'),
                Tables\Actions\EditAction::make()->url(fn (Model $record): string => LessonsResource::getUrl('edit', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
