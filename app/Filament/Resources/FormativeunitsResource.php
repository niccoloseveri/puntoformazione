<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormativeunitsResource\Pages;
use App\Filament\Resources\FormativeunitsResource\RelationManagers;
use App\Models\Formativeunits;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormativeunitsResource extends Resource
{
    protected static ?string $model = Formativeunits::class;

    protected static ?string $navigationIcon = 'gmdi-view-module-r';
    protected static ?string $navigationGroup = 'Didattica';
    protected static ?string $modelLabel = 'Unità Formativa';
    protected static ?string $pluralModelLabel = 'Unità Formative';
    protected static ?int $navigationSort = 4;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'index' => Pages\ListFormativeunits::route('/'),
            'create' => Pages\CreateFormativeunits::route('/create'),
            'edit' => Pages\EditFormativeunits::route('/{record}/edit'),
        ];
    }
}
