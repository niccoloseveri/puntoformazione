<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonsResource\Pages;
use App\Filament\Resources\LessonsResource\RelationManagers;
use App\Models\Lessons;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                DateTimePicker::make('starts_at')
                    ->label('Data e Ora Inizio')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->label('Data e Ora Fine')
                    ->required(),
                Select::make('course_id')
                    ->label('Corso')
                    ->relationship('course', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLessons::route('/create'),
            'edit' => Pages\EditLessons::route('/{record}/edit'),
        ];
    }
}
