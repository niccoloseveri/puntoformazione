<?php

namespace App\Filament\Resources\LessonsResource\RelationManagers;

use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';
    protected static ?string $navigationLabel = 'Registro';
    protected static ?string $title = 'Registro';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->modifyQueryUsing(function (Builder $query){
                $query->leftJoinRelationship('user');

                //->where('attendances.lesson_id', $this->ownerRecord->id);
                //dd($query->toSql());
                //dd($this->ownerRecord->id);
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
                //has attended

                TextColumn::make('user.attendances')
                ->label('Presenze')
                ->getStateUsing(function ($record, $livewire) {
                    $lessonId = $livewire->ownerRecord->id;
                    $attendance= Attendance::where('lesson_id', $lessonId)
                        ->where('user_id', $record->user_id)
                        ->first();

                    return $attendance ? 'Presente' : 'Assente';
                })
                //background color based on attendance
                ->badge()
                ->color(function ($record, $state, $livewire) {
                    $lessonId = $livewire->ownerRecord->id;
                    $attendance = Attendance::where('lesson_id', $lessonId)
                        ->where('user_id', $record->user_id)
                        ->first();
                        return $attendance ? 'success' : 'danger';
                    })
                ])
            ->defaultSort('user.surname','asc')
            ->defaultPaginationPageOption('all')
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
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
