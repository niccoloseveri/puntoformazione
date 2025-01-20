<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModulesResource\Pages;
use App\Filament\Resources\ModulesResource\RelationManagers;
use App\Models\Modules;
use App\Models\User;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModulesResource extends Resource
{
    protected static ?string $model = Modules::class;

    protected static ?string $navigationIcon = 'gmdi-view-module-r';
    protected static ?string $navigationGroup = 'Didattica';
    protected static ?string $modelLabel = 'Modulo';
    protected static ?string $pluralModelLabel = 'Moduli';
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome Modulo')
                    ->required(),
                Forms\Components\Select::make('course_id')->relationship(name: 'course', titleAttribute: 'name')
                    ->label('Corso')
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('durata')->label('Durata (minuti)')
                    ->placeholder('minuti')
                    ->required()
                    //->hidden(fn (User $user) => !$user->isAdmin())
                    ,
                //Forms\Components\Select::make('formativeunit_id')->relationship(name: 'formativeunits', titleAttribute: 'name')


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome Modulo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->label('Corso')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListModules::route('/'),
            'create' => Pages\CreateModules::route('/create'),
            'edit' => Pages\EditModules::route('/{record}/edit'),
        ];
    }
}
