<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoursesResource\Pages;
use App\Filament\Resources\CoursesResource\RelationManagers\ClassroomRelationManager;
use App\Filament\Resources\CoursesResource\RelationManagers\ModulesRelationManager;
use App\Models\Courses;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;

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
                /*
                    #area di riferimento (foligno o fuori)
                */

                Section::make('Info Corso')->schema([
                    Forms\Components\TextInput::make('name')->label('Nome Corso')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('code')->label('Codice')
                        ->required(),
                    Forms\Components\TextInput::make('year')->label('Anno')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('edition')->label('Edizione')
                        ->required()
                        ->maxLength(255),
                ])
                ->columns(3)
                ,

                Section::make('Durata corso')
                    ->schema([
                        Forms\Components\TextInput::make('ore_corso')->label('Durata (ore)')
                        ->placeholder('hh:mm')
                        ->required(),
                        Forms\Components\DatePicker::make('start_date')->label('Data inizio corso')
                        ->required(),
                        Forms\Components\DatePicker::make('end_date')->label('Data fine corso')
                        ->required(),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed()
                    ,

                Section::make('Costo corso')
                    ->schema([
                        /*
                        Forms\Components\TextInput::make('exam_price')->label('Prezzo fisso')
                            ->required()
                            ->numeric()
                            ->suffixIcon('gmdi-euro-r'),
                        */
                        Forms\Components\TextInput::make('ass_price')->label('Prezzo pagamento rateale')
                            ->required()
                            ->numeric()
                            ->suffixIcon('gmdi-euro-r'),
                        Forms\Components\TextInput::make('price')->label('Prezzo pagamento unico')
                            //->placeholder('corso + esame + assicuraz.')
                            ->required()
                            ->numeric()
                            ->suffixIcon('gmdi-euro-r')
                            ,
                        /*FileUpload::make('document')->label('Carica documenti di identità')->disk('ftp')->columnSpanFull(),
                        FileUpload::make('document')->label('Carica manifestazione di interesse')->disk('ftp')->columnSpanFull(),
                        FileUpload::make('document')->label('Carica codice fiscale')->disk('ftp')->columnSpanFull(),
                        */

                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ,
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
                Tables\Columns\TextColumn::make('price')->label('Costo del corso')
                    ->money('EUR'),
                Tables\Columns\TextColumn::make('edition')->label('Edizione')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creato il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            RelationGroup::make('Classi', [
                ClassroomRelationManager::class,
            ]),
            RelationGroup::make('Moduli',[
                ModulesRelationManager::class,
            ]),
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
