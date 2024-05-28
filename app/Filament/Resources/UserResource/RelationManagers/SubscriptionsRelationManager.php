<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\UserResource;
use App\Models\Classrooms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    public function form(Form $form): Form
    {
        return $form

        ->schema([
            Forms\Components\Select::make('course')->label('Corso')
                ->relationship(name:'courses', titleAttribute:'name')
                ->searchable('name')
                ->preload()
                ->live(),

            Forms\Components\Select::make('classroom')->label('Classe')
                ->relationship(name:'classrooms', titleAttribute:'name')
                ->searchable()
                ->hidden(
                    fn(Get $get) :bool => !$get('course')
                )
                ->options(
                    fn($get) =>
                        Classrooms::where('course_id',$get('course'))->pluck('name','id')
                ),

            Forms\Components\Select::make('payment_options_id')->label('Opzioni Pagamento')
                ->relationship(name: 'paymentoptions', titleAttribute: 'name')
                ->searchable('name')
                ->preload(),

            Forms\Components\DatePicker::make('start_date')
                ->required(),

            Forms\Components\Select::make('statuses_id')->label('Stato Iscrizione')
                ->relationship(name: 'status', titleAttribute: 'name')
                ->searchable('name')
                ->preload(),
            Forms\Components\DatePicker::make('next_payment'),

        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Iscrizioni')

            //->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('courses.name')->label('Nome'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->modalHeading('Iscrizione '. $this->getOwnerRecord()->full_name),
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
