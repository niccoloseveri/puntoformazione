<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use App\Models\Courses;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Didattica';
    protected static ?string $modelLabel = 'Presenza';
    protected static ?string $pluralModelLabel = 'Presenze';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')->label('Studente')
                    ->relationship('user', 'full_name',modifyQueryUsing: fn (Builder $query) => $query->orderBy('surname'))
                    ->searchable('name','surname','full_name','email')
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->surname} {$record->name}")
                    ->required(),
                Forms\Components\TextInput::make('lesson_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('attend_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.full_name')->label('Studente')
                ->formatStateUsing(function ($record) {
                    return $record->user->surname. ' ' .$record->user->name. ' ';
                })
                ->html()
                ->sortable('surname')
                ->copyable()
                ->searchable(),
                Tables\Columns\TextColumn::make('lesson.name')->label('Lezione')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Stato')
                    ->searchable()
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
                    })
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                //course filter

            ])
            ->actions([
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
