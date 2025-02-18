<?php

namespace App\Filament\Resources\ClassroomsResource\RelationManagers;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

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
                Action::make('Invia Dati Login')->action(function () {
                    foreach($this->getOwnerRecord()->users()->get() as $data){
                        Mail::to($data)->send(new \App\Mail\SendLoginInfo($data));
                    }
                    //Mail::to($this->user)->send(new \App\Mail\SendLoginInfo($this->user));
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make()->url(fn ($record) => UserResource::getUrl('edit', ['record' => $record->id])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
