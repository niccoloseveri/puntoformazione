<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentsResource\Pages;
use App\Filament\Resources\PaymentsResource\RelationManagers;
use App\Models\Classrooms;
use App\Models\Courses;
use App\Models\Payments;
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

class PaymentsResource extends Resource
{
    protected static ?string $model = Payments::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->live(),
                Forms\Components\Select::make('courses_id')->label('Corso')
                    ->relationship(name: 'course', titleAttribute:'name')
                    ->searchable()
                    ->live()
                    ->hidden(
                        fn(Get $get) :bool => !$get('users_id')
                    )
                    ->options(
                        fn($get) =>
                            Courses::whereHas('users', function ($query) use ($get) {
                                $query->where('users.id', $get('users_id'));
                            })->get()->pluck('name', 'id')
                    ),
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
                    ),
                ])->columns(3)->compact(),
                Section::make('Informazioni Pagamento')->schema([
                    Forms\Components\Select::make('payment_method')->label('Metodo di Pagamento')
                    ->placeholder('Seleziona un metodo di pagamento')
                    ->options([
                        'cash' => 'Contanti',
                        'credit_card' => 'Carta di Credito',
                        'bank_transfer' => 'Bonifico Bancario',
                        'other' => 'Altro',
                    ]),
                    Forms\Components\TextInput::make('amount_paid')->numeric()->label('Importo Pagato'),
                    //Forms\Components\TextInput::make('discount')->numeric()->label('Sconto'),
                    //Forms\Components\TextInput::make('total_amount')->numeric()->label('Importo Totale'),
                    Forms\Components\DatePicker::make('payment_date')->label('Data Pagamento')->default(now()),
                    Forms\Components\Checkbox::make('is_paid')->label('Pagato'),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')->label('Metodo Pagamento')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([

                Filter::make('courses_id')
                ->form([
                    Select::make('courses_id')->label('Corso')
                    ->live()
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
                    ->placeholder(fn (Get $get): string => empty($get('courses_id')) ? 'Seleziona prima un corso' : 'Seleziona la classe')
                    ->options(fn($get) => Classrooms::where('course_id', $get('courses_id'))->pluck('name', 'id'))
                ]),
            ],layout:FiltersLayout::AboveContent)
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayments::route('/create'),
            'edit' => Pages\EditPayments::route('/{record}/edit'),
        ];
    }
}
