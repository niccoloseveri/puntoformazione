<?php

namespace App\Filament\Resources\ClassroomsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Iscritti')
            //->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label('Cognome e Nome')
                ->formatStateUsing(function ($record) {
                    return $record->surname. ' ' .$record->name. ' ';
                })
                ->html()
                ->sortable('surname')
                ,
            ])->defaultSort('surname','asc')->defaultPaginationPageOption('all')
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
