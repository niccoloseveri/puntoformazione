<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Spatie\Permission\Traits\HasRoles;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Anagrafica';
    protected static ?string $navigationParentItem = 'Utenti';
    protected static ?string $modelLabel = 'Studente';
    protected static ?string $pluralModelLabel = 'Studenti';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->role('studente');
    }
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Wizard::make([
                Wizard\Step::make('Dati Studente')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nome')
                        ->required()
                        ->columns(1)
                        ->maxLength(255)
                        ->live(onBlur:true)
                        ->mask(RawJs::make(<<<'JS'
                            $input.replace(/\w\S*/g, function(txt) {
                                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                                });
                            JS))
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('password', str_replace(' ', '', $state) . '0000')),
                    Forms\Components\TextInput::make('surname')->label('Cognome')
                        ->required()
                        ->columns(1)
                        ->mask(RawJs::make(<<<'JS'
                            $input.replace(/\w\S*/g, function(txt) {
                                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                                });
                            JS))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->autocomplete(false)
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')

                        ->readOnly()
                        ->autocomplete(false)
                        ->extraAttributes([
                            'data-lpignore' => 'true',
                            'data-1p-ignore'
                        ])
                        ->live()
                        ->maxLength(255)
                        ->helperText('La password è formata dal nome dello studente + 0000')
                        ->password()
                        ->revealable()
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn ($livewire) => ($livewire instanceof CreateRecord)),
                    Forms\Components\TextInput::make('cf')->label('Codice Fiscale')
                        ->required()
                        ->maxLength(16)
                        ->mask(RawJs::make(<<<'JS'
                            $input.toUpperCase();
                            JS))
                        ->regex("/^(?:[A-Z][AEIOU][AEIOUX]|[AEIOU]X{2}|[B-DF-HJ-NP-TV-Z]{2}[A-Z]){2}(?:[\dLMNP-V]{2}(?:[A-EHLMPR-T](?:[04LQ][1-9MNP-V]|[15MR][\dLMNP-V]|[26NS][0-8LMNP-U])|[DHPS][37PT][0L]|[ACELMRT][37PT][01LM]|[AC-EHLMPR-T][26NS][9V])|(?:[02468LNQSU][048LQU]|[13579MPRTV][26NS])B[26NS][9V])(?:[A-MZ][1-9MNP-V][\dLMNP-V]{2}|[A-M][0L](?:[1-9MNP-V][\dLMNP-V]|[0L][1-9MNP-V]))[A-Z]$/i")
                        ->validationMessages([
                            'regex' => 'Codice Fiscale non valido.'
                        ]),
                    Forms\Components\TextInput::make('via')
                        ->required()
                        ->mask(RawJs::make(<<<'JS'
                            $input.replace(/\w\S*/g, function(txt) {
                                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                                });
                            JS))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('citta')
                        ->required()
                        ->mask(RawJs::make(<<<'JS'
                            $input.replace(/\w\S*/g, function(txt) {
                                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                                });
                            JS))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cap')
                        ->required()
                        ->mask(RawJs::make(<<<'JS'
                            $input.replace(/\w\S*/g, function(txt) {
                                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                                });
                            JS))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('tel')
                        ->tel()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->default([2])
                        ->required()
                        ->label('Ruolo'),
                    Forms\Components\Toggle::make('piva_check')->label('Partita iva?')
                        ->live(),
                    Forms\Components\TextInput::make('piva')
                        ->hidden(fn (Get $get): bool => !$get('piva_check'))
                        ->label('Partita IVA'),
                ])->columns(2),

                Wizard\Step::make('Iscrizione')
                ->schema([

                ]),
                Wizard\Step::make('Fatturazione')
                ->schema([

                ]),
                Wizard\Step::make('Stampa Documenti')
                ->schema([

                ]),

            ])->columnSpanFull(),


        ]);
                //Test deploy 3
                /*

                    Nome
                    Cognome
                    Città nascita
                    Data di nascita
                    Città residenza
                    Via residenza
                    Cap residenza
                    Codice Fiscale

                */

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('full_name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('cf')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tel')
                    ->searchable(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
