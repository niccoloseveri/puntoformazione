<?php

namespace App\Filament\Resources;

use App\Filament\Imports\InstallmentImporter;
use App\Filament\Resources\PaymentsResource\Pages;
use App\Filament\Resources\PaymentsResource\RelationManagers;
use App\Models\Classrooms;
use App\Models\Courses;
use App\Models\Installment;
use App\Models\Payments;
use Carbon\Carbon;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Forms;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PaymentsResource extends Resource
{
    protected static ?string $model = Payments::class;

    protected static ?string $navigationIcon = 'gmdi-payment-r';
    protected static ?string $modelLabel = 'Pagamento';
    protected static ?string $pluralModelLabel = 'Pagamenti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Studente e Corso')->schema([
                    Forms\Components\Select::make('users_id')->label('Studente')
                    ->relationship(name: 'user', titleAttribute: 'full_name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('surname'))
                    ->searchable('name','surname','full_name','email')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->surname} {$record->name}")
                    ->preload()
                    ->live()
                    ->required(),
                Forms\Components\Select::make('courses_id')->label('Corso')
                    ->relationship(name: 'course', titleAttribute:'name')
                    ->searchable()
                    ->live()
                    ->hidden(
                        fn(Get $get) :bool => !$get('users_id')
                    )
                    ->options(
                        fn($get) =>
                            ds(Courses::whereHas('users', function ($query) use ($get) {
                                $query->where('users.id', $get('users_id'));
                            })->whereHas('subscriptions', function ($query) use ($get) {
                                $query->where('user_id',$get('users_id'));
                            })->get()
                            //->pluck('name', 'id')
                            )
                    )
                    ->required(),
                Forms\Components\Select::make('classrooms_id')->label('Classe')
                    ->relationship(name: 'classroom', titleAttribute:'name')
                    ->searchable()
                    ->hidden(
                        fn(Get $get) :bool => !$get('courses_id')
                    )
                    ->options(
                        fn($get) =>
                            Classrooms::whereHas('course', function ($query) use ($get) {
                                $query->where('courses.id', $get('courses_id'));
                            })->get()->pluck('name', 'id')
                    )
                    ->required(),
                ])->columns(3)->compact(),
                Section::make('Informazioni Pagamento')->schema([
                    Forms\Components\Select::make('payment_method')->label('Metodo di Pagamento')
                    ->placeholder('Seleziona un metodo di pagamento')
                    ->native(false)
                    ->options([
                        'cash' => 'Contanti',
                        'credit_card' => 'Carta di Credito',
                        'bank_transfer' => 'Bonifico Bancario',
                        'other' => 'Altro',
                    ])->required(),
                    Forms\Components\TextInput::make('amount_paid')->numeric()->label('Importo Pagato')->required(),
                    //Forms\Components\TextInput::make('discount')->numeric()->label('Sconto'),
                    //Forms\Components\TextInput::make('total_amount')->numeric()->label('Importo Totale'),
                    Forms\Components\DatePicker::make('payment_date')->label('Data Pagamento')->displayFormat('d/m/Y')->required(),
                    Forms\Components\Checkbox::make('is_paid')->label('Pagato')->default(true),
                    Forms\Components\FileUpload::make('attachment')->label('Ricevuta Bonifico')
                    ->disk('s3')
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file, Forms\Get $get) : string => (string) str($get('name').' '.$get('surname').'.'.$file->getClientOriginalExtension())
                        ->prepend('documento-'),
                    )
                    ->visibility('private')
                    ->openable()
                    ,

                ])->columns(3)->compact(),
                Textarea::make('notes')->label('Note')->rows(3)->columnSpanFull(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('user.full_name')->label('Studente')
                    ->label('Cognome e nome')
                    ->formatStateUsing(function ($record) {
                        return $record->user->surname. ' ' .$record->user->name. ' ';
                    })
                    ->html()
                    ->sortable('surname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.name')->label('Corso')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('classroom.name')->label('Classe')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')->label('Importo Totale')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount')->label('Sconto')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount_paid')->label('Importo Pagato')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_paid')->label('Stato Pagamento')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_date')->label('Data Pagamento')
                    ->sortable()
                    ->formatStateUsing(
                        fn ($state) => Carbon::createFromFormat('d/m/Y', $state)->format('d/m/Y')
                    )
                    ->searchable()
                    ,
                Tables\Columns\TextColumn::make('payment_method')->label('Metodo Pagamento')
                    ->sortable()
                    ->searchable(),


            ])
            ->filters([
                SelectFilter::make('users_id')
                    ->label('Studente')
                    ->relationship('user', 'full_name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->placeholder('Seleziona uno studente')
                    ->options(
                        fn () => \App\Models\User::orderBy('surname')->get()->pluck('full_name', 'id')
                    ),

                Filter::make('courses_id')
                ->form([
                    Select::make('courses_id')->label('Corso')
                    ->live()
                    ->native(false)
                    ->dehydrated(false)
                    ->options(Courses::pluck('name', 'id'))
                    ->placeholder('Seleziona un corso')
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('data.class_id', null);
                    }),
                ]),
                Filter::make('class_id')
                ->form([
                    Select::make('class_id')->label('Classe')
                    ->live()
                    ->native(false)
                    ->placeholder(fn (Get $get): string => empty($get('courses_id')) ? 'Seleziona prima un corso' : 'Seleziona la classe')
                    ->options(fn($get) => Classrooms::where('course_id', $get('courses_id'))->pluck('name', 'id'))
                ]),

            ],layout:FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                /*ExcelImportAction::make('Importa Rate')
                ->importer(InstallmentImporter::class),*/
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayments::route('/create'),
            'edit' => Pages\EditPayments::route('/{record}/edit'),
        ];
    }
}
