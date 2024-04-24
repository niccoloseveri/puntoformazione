<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionsResource\Pages;
use App\Filament\Resources\SubscriptionsResource\RelationManagers;
use App\Models\Subscriptions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionsResource extends Resource
{
    protected static ?string $model = Subscriptions::class;

    protected static ?string $navigationIcon = 'gmdi-key-o';
    protected static ?string $navigationGroup = 'Anagrafica';
    protected static ?string $modelLabel = 'Iscrizione';
    protected static ?string $pluralModelLabel = 'Iscrizioni';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('users_id')->label('Studente')
                    ->relationship(name: 'user', titleAttribute: 'full_name')
                    ->createOptionForm(fn(Form $form) => UserResource::form($form))
                    ->searchable('name','surname','full_name','email')
                    ->preload(),

                Forms\Components\Select::make('courses_id')->label('Corso')
                    ->relationship(name: 'courses', titleAttribute: 'name')
                    ->searchable('name')
                    ->live()
                    ->preload(),

                Forms\Components\TextInput::make('classrooms_id')
                    ->required()
                    ->numeric(),

                Forms\Components\Select::make('payment_options_id')->label('Opzioni Pagamento')
                    ->relationship(name: 'paymentoption', titleAttribute: 'name')
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('courses_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classrooms_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_options_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_teacher')
                    ->boolean(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('statuses_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_payment')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('printed_cont')
                    ->boolean(),
                Tables\Columns\IconColumn::make('printed_priv')
                    ->boolean(),
                Tables\Columns\IconColumn::make('printed_whats')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscriptions::route('/create'),
            'edit' => Pages\EditSubscriptions::route('/{record}/edit'),
        ];
    }
}
