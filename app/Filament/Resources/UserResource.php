<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Classrooms;
use App\Models\Courses;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'gmdi-people-alt-s';
    protected static ?string $navigationGroup = 'Anagrafica';
    protected static ?string $modelLabel = 'Utente';
    protected static ?string $pluralModelLabel = 'Utenti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Generali')
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Nome')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur:true)

                        //{
                            //->mask(RawJs::make(<<<'JS'
                            //    $input.replace(/\w\S*/g, function(txt) {
                            //        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                            //        });
                            //    JS))
                        //}
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('password', str_replace(' ','',$state).'0000')),
                    Forms\Components\TextInput::make('surname')->label('Cognome')
                        ->required()
                        //{
                            //->mask(RawJs::make(<<<'JS'
                            //    $input.replace(/\w\S*/g, function(txt) {
                            //        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                            //        });
                            //    JS))
                        //}
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->autocomplete(false)
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->live()
                        ->readOnly()
                        ->autocomplete(false)
                        ->extraAttributes([
                            'data-lpignore' => 'true',
                            'data-1p-ignore'
                        ])
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
                    Forms\Components\TextInput::make('tel')->label('Telefono')
                        ->tel()
                        ->required()
                        ->maxLength(255),
                ]),
                Fieldset::make('Cittadinanza e Nascita')
                ->schema([
                    Forms\Components\DatePicker::make('data_nascita')
                    ->label('Data di nascita'),
                    Forms\Components\TextInput::make('paese_nascita')
                    ->label('Paese di nascita')
                    ->maxLength(255),
                    Forms\Components\TextInput::make('luogo_nascita')
                    ->maxLength(255)
                    ->label('Città di nascita'),
                    Forms\Components\TextInput::make('prov_nascita')
                    ->maxLength(255)
                    ->label('Provincia di nascita'),
                    Forms\Components\TextInput::make('cittadinanza')
                    ->maxLength(255)
                    ->label('Cittadinanza'),
                    FileUpload::make('document_uploaded')->label('Documento o Passaporto')
                    ->disk('ftp')
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file, Forms\Get $get) : string => (string) str($get('name').' '.$get('surname').'.'.$file->getClientOriginalExtension())
                        ->prepend('documento-'),
                    )
                    ->visibility('private'),


                ]),
                Fieldset::make('Residenza')
                ->schema([
                    Forms\Components\TextInput::make('paese_residenza')->label('Paese')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('prov')->label('Provincia')
                        ->required()
                        ->maxLength(3),
                    Forms\Components\TextInput::make('citta')
                        ->required()
                        //{
                            //->mask(RawJs::make(<<<'JS'
                            //    $input.replace(/\w\S*/g, function(txt) {
                            //        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                            //        });
                            //    JS))
                        //}
                        ->maxLength(255),
                    Forms\Components\TextInput::make('via')
                        ->required()
                        //{
                            //->mask(RawJs::make(<<<'JS'
                            //    $input.replace(/\w\S*/g, function(txt) {
                            //        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                            //        });
                            //    JS))
                        //}
                        ->maxLength(255),

                    Forms\Components\TextInput::make('cap')
                        ->required()
                        //{
                            //->mask(RawJs::make(<<<'JS'
                            //    $input.replace(/\w\S*/g, function(txt) {
                            //        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                            //        });
                            //    JS))
                        //}
                        ->maxLength(255),
                ]),
                Fieldset::make('Altre info')
                ->schema([
                    Forms\Components\Select::make('roles')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload()
                        ->required()
                        ->label('Ruolo'),
                    Forms\Components\Select::make('course')->label('Corso (non obbligatorio)')
                        ->relationship(name:'courses', titleAttribute:'name')
                        ->searchable('name')
                        ->preload()
                        ->live(),
                    /*
                    Forms\Components\Select::make('classroom')->label('Classe (non obbligatorio)')
                        ->relationship(name:'classrooms', titleAttribute:'name')
                        ->searchable()
                        ->hidden(
                            fn(Get $get) :bool => !$get('course')
                        )
                        ->options(
                            fn($get) =>
                                Classrooms::where('course_id',$get('course'))->pluck('name','id')
                        ),
                    */
                    Forms\Components\Select::make('genere')->label('Genere')
                        ->options([
                            'Uomo',
                            'Donna',
                            'Altro',
                        ])
                        ->searchable(),
                    Forms\Components\Select::make('titolo_studio')->label('Titolo di studio')
                        ->options([
                            'Diploma Liceo',
                            'Diploma Istituto tecnico',
                            'Laurea Triennale',
                            'Laurea Magistrale',
                            'Diploma scuola secondaria di primo grado',
                            'Nessuno',
                        ])
                        ->searchable(),

                    Forms\Components\Toggle::make('piva_check')->label('Partita iva?')
                        ->live(),
                    Forms\Components\TextInput::make('piva')
                        ->hidden(fn (Get $get): bool => ! $get('piva_check'))
                        ->label('Partita IVA')
                        ->columnSpanFull(),
                ]),
                Fieldset::make('Caricamenti')
                    ->schema([
                        FileUpload::make('cf_uploaded')->label('Codice Fiscale o Tessera Sanitaria')
                        ->disk('ftp')
                        ->getUploadedFileNameForStorageUsing(
                            fn (TemporaryUploadedFile $file, Forms\Get $get) : string => (string) str($get('name').' '.$get('surname').'.'.$file->getClientOriginalExtension())
                            ->prepend('codicefiscale-'),
                        )
                        ->visibility('private')
                        ->columnSpanFull(),
                        FileUpload::make('permesso_uploaded')->label('Permesso di soggiorno')
                        ->disk('ftp')
                        ->getUploadedFileNameForStorageUsing(
                            fn (TemporaryUploadedFile $file, Forms\Get $get) : string => (string) str($get('name').' '.$get('surname').'.'.$file->getClientOriginalExtension())
                            ->prepend('permessosoggiorno-'),
                        )
                        ->visibility('private')
                        ->columnSpanFull(),

                        FileUpload::make('interesse_uploaded')->label('Manifestazione di interesse')
                        ->disk('ftp')
                        ->getUploadedFileNameForStorageUsing(
                            fn (TemporaryUploadedFile $file, Forms\Get $get) : string => (string) str($get('name').' '.$get('surname').'.'.$file->getClientOriginalExtension())
                            ->prepend('interesse-'),
                        )
                        ->visibility('private')
                        ->columnSpanFull(),

                    ]),
                RichEditor::make('note')->label('Note')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->defaultSort('created_at','desc')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nome e Cognome')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cf')
                    ->label('Codice Fiscale')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Indirizzo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tel')
                    ->label('Telefono')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('roles.id')
                    ->getStateUsing(function ($record) {
                        $a = 0;
                        if($record->roles->first()?->id == 1) $a = 1;
                        else $a=0;
                        return $a;
                    })
                    ->boolean()
                    ->alignCenter()
                    ->label('Insegnante'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
