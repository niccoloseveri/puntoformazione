<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomsResource\RelationManagers\UsersRelationManager;
use App\Filament\Resources\ClassroomsResource\Pages;
use App\Filament\Resources\ClassroomsResource\RelationManagers;
use App\Models\Classrooms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassroomsResource extends Resource
{
    protected static ?string $model = Classrooms::class;

    protected static ?string $navigationGroup = 'Didattica';
    protected static ?string $navigationIcon = 'gmdi-meeting-room-r';
    protected static ?string $modelLabel = 'Classe';
    protected static ?string $pluralModelLabel = 'Classi';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')->label('Nome')
                    ->required()
                    ->maxLength(25),
                Forms\Components\Select::make('course_id')->label('Corso')
                    ->relationship('course', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')->label("Nome")->searchable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->label("Corso")
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creata il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
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
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassrooms::route('/create'),
            'edit' => Pages\EditClassrooms::route('/{record}/edit'),
        ];
    }
}
