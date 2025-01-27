<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormativeunitsResource\Pages;
use App\Filament\Resources\FormativeunitsResource\RelationManagers;
use App\Models\Classrooms;
use App\Models\Courses;
use App\Models\Formativeunits;
use App\Models\Modules;
use Filament\Forms;
use Filament\Forms\Components\Livewire as ComponentsLivewire;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Livewire;

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
                Forms\Components\Select::make('courses_id')
                    ->live()
                    ->label('Corso')
                    ->relationship(name:'courses', titleAttribute:'name')
                    ->searchable('name')
                    ->preload()
                    ->live(),

                Forms\Components\Select::make('modules_id')
                    ->label('Modulo')
                    ->relationship(name:'modules', titleAttribute:'name')
                    ->searchable('name')
                    ->hidden(fn(Get $get) :bool => !$get('courses_id'))
                    ->options(
                        fn($get) =>
                            Modules::where('course_id',$get('courses_id'))->pluck('name','id')
                    )
                    ->live(),

                Forms\Components\TextInput::make('title')
                    ->label('Nome')
                    ->required(),
                //




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('courses.name')
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
