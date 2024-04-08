<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoursesResource\Pages;
use App\Filament\Resources\CoursesResource\RelationManagers;
use App\Filament\Resources\CoursesResource\RelationManagers\ClassroomRelationManager;
use App\Models\Courses;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoursesResource extends Resource
{
    protected static ?string $model = Courses::class;

    protected static ?string $modelLabel = 'Corso';
    protected static ?string $pluralModelLabel = 'Corsi';
    protected static ?int $navigationSort = 1;

    //protected static ?string $label = 'Anagrafica';
    protected static ?string $navigationGroup = 'Didattica';

    protected static ?string $navigationIcon = 'gmdi-schema-r';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                /*
                    #nomecorso
                    #durata (ore)
                    #prezzo
                    #quota esame
                    #quota assicurativa
                    #codice
                    #anno
                    #edizione
                    #sezione
                */
                Forms\Components\TextInput::make('name')->label('Nome Corso')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('code')->label('Codice')
                    ->required(),
                Forms\Components\TextInput::make('year')->label('Anno')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('start_date')->label('Data inizio corso')->required(),
                Forms\Components\DatePicker::make('end_date')->label('Data fine corso')->required(),
                Forms\Components\TextInput::make('price')->label('Prezzo')
                    ->required()
                    ->numeric()
                    ->suffixIcon('gmdi-euro-r'),
                Forms\Components\TextInput::make('edition')->label('Edizione')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')->label('Nome Corso')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')->label('Codice')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')->label('Anno Svolgimento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Costo del corso')->money('EUR'),
                Tables\Columns\TextColumn::make('edition')->label('Edizione')
                    ->searchable(),
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
            RelationGroup::make('Classi', [
                ClassroomRelationManager::class,
            ])
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourses::route('/create'),
            'edit' => Pages\EditCourses::route('/{record}/edit'),
        ];
    }
}
