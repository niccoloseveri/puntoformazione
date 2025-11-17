<?php

namespace App\Filament\Resources\LessonsResource\RelationManagers;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';
    protected static ?string $navigationLabel = 'Presenze';
    protected static ?string $title = 'Presenze';



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')->label('Studente')
                    ->relationship('user', 'full_name',modifyQueryUsing: fn (Builder $query) => $query->whereHas('courses', function (Builder $query) {
                        $query->where('courses.id','like',$this->getOwnerRecord()->courses()->first()->id);
                    })->orderBy('surname'))
                    ->searchable('name','surname','full_name','email')
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->surname} {$record->name}")
                    ->required(),
                Forms\Components\DateTimePicker::make('attend_at')->label('Orario ingresso')
                    ->required(),
                //status
                Forms\Components\TextInput::make('status')->default('present')->readOnly()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->modifyQueryUsing(function (Builder $query) {
                $query->leftJoinRelationship('user');
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.surname')->label('Cognome')
                ->sortable()
                ->copyable()
                ->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Nome')
                ->sortable('user.name')
                ->copyable()
                ->searchable(),
                Tables\Columns\TextColumn::make('attend_at')->label('Orario ingresso')
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
            ->defaultSort('user.surname','asc')
            ->defaultPaginationPageOption('all')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
