<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionsResource\Pages;
use App\Filament\Resources\SubscriptionsResource\RelationManagers;
use App\Models\Classrooms;
use App\Models\Payment_options;
use App\Models\Subscriptions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionsResource extends Resource
{
    protected static ?string $model = Subscriptions::class;

    protected static ?string $navigationIcon = 'gmdi-key-o';
    protected static ?string $navigationGroup = 'Anagrafica';
    protected static ?string $modelLabel = 'Iscrizione';
    protected static ?string $pluralModelLabel = 'Iscrizioni';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form

        /*
            sede di riferimento (foligno o altro)
        */
            ->schema([

                Forms\Components\Select::make('user_id')->label('Studente')
                    ->relationship(name: 'user', titleAttribute: 'full_name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('surname'))
                    ->createOptionForm(fn(Form $form) => UserResource::form($form))
                    ->searchable('name','surname','full_name','email')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->surname} {$record->name}")
                    ->preload(),

                    Forms\Components\Select::make('course')->label('Corso')
                    ->relationship(name:'courses', titleAttribute:'name')
                    ->searchable('name')
                    ->preload()
                    ->reactive()
                    ->live(),

                Forms\Components\Select::make('classroom')->label('Classe')
                    ->relationship(name:'classrooms', titleAttribute:'name')
                    ->searchable()
                    ->hidden(
                        fn(Get $get) :bool => !$get('course')
                    )
                    ->options(
                        fn($get) =>
                            Classrooms::where('course_id',$get('course'))->pluck('name','id')
                    ),

                Forms\Components\Select::make('payment_options_id')->label('Opzioni Pagamento')
                    ->relationship(name: 'paymentoptions', titleAttribute: 'name')
                    ->searchable('name')
                    ->live()
                    ->preload()
                    ->reactive(),

                Forms\Components\Select::make('installments_mode')
                    ->native(false)
                    ->label('Modalità piano rate')
                    ->options([
                        'by_amount' => 'In base all’importo mensile',
                        'by_count'  => 'In base al numero di rate',
                    ])
                    ->default('by_amount')
                    ->dehydrated(false) // <-- qui la magia: non va nel DB
                    ->hidden(function(Get $get) : bool {
                        $test = Payment_options::find($get('payment_options_id'))!=null ? $test=Payment_options::find($get('payment_options_id')): null ;
                        //dd($test);
                        return !(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale'));
                    })
                    ->reactive(),

                Forms\Components\TextInput::make('down_payment')
                ->label('Anticipo')->numeric()->default(0)
                ->suffixIcon('gmdi-euro-r')
                    ->live()
                    ->reactive()
                    ->hidden(function(Get $get) : bool {
                        $test = Payment_options::find($get('payment_options_id'))!=null ? $test=Payment_options::find($get('payment_options_id')): null ;
                        //dd($test);
                        return !(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale'));
                    }),

                Forms\Components\TextInput::make('pay_day_of_month')
                    ->label('Giorno pagamento (1–31)')
                    ->numeric()->minValue(1)->maxValue(31)->default(28)
                    ->live()
                    ->reactive()
                    ->hidden(function(Get $get) : bool {
                        $test = Payment_options::find($get('payment_options_id'))!=null ? $test=Payment_options::find($get('payment_options_id')): null ;
                        //dd($test);
                        return !(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale'));
                    }),

                    //
                Forms\Components\TextInput::make('imp_rata')
                    ->label('Importo rata (€)')
                    ->reactive()
                    ->numeric()
                    ->hidden(function(Get $get) : bool {
                        $test = Payment_options::find($get('payment_options_id'))!=null ? $test=Payment_options::find($get('payment_options_id')): null ;
                        //dd($test);
                        $b=true;
                        if(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale')){
                            if(($get('installments_mode') =='by_amount')) {
                                $b=false;
                            }
                        }
                        return $b;
                        //return !(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale'));
                    })
                    ->live()
                    ->suffixIcon('gmdi-euro-r')
                    ->rule(function (Get $get) {
                        return function (string $attribute, $value, $fail) use ($get) {
                            if ($get('payment_type') !== 'installments') return;
                            if (($get('installments_mode') ?? 'by_amount') !== 'by_amount') return;

                            $courseId = $get('courses_id');
                            if (!$courseId) return;

                            $course = \App\Models\Courses::find($courseId);
                            if (!$course || !$course->ends_at) return;

                            $state = [
                                'enrolled_at'       => $get('start_date'),
                                'pay_day_of_month'  => $get('pay_day_of_month'),
                                'down_payment'      => $get('down_payment'),
                                'monthly_amount'    => $value,
                                'installments_mode' => 'by_amount',
                            ];

                            $tips = app(\App\Services\InstallmentPlanBuilder::class)->tipsForState($state, $course);
                            if (isset($tips['minQuota'])) {
                                $fail('Importo rata insufficiente. Quota minima: € '.number_format($tips['minQuota'], 2, ',', '.'));
                            }
                        };
                    }),

                // by_count
                Forms\Components\TextInput::make('installments_count')
                    ->label('Numero di rate')
                    ->numeric()->minValue(1)
                    ->reactive()
                    ->hidden(function(Get $get) : bool {
                        $test = Payment_options::find($get('payment_options_id'))!=null ? $test=Payment_options::find($get('payment_options_id')): null ;
                        //dd($test);
                        $b=true;
                        if(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale')){
                            if(($get('installments_mode') =='by_count')) {
                                $b=false;
                            }
                        }
                        return $b;
                        //return !(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale'));
                    })
                    ->live()
                    ->rule(function (Get $get) {
                        return function (string $attribute, $value, $fail) use ($get) {
                            if ($get('payment_type') !== 'installments') return;
                            if (($get('installments_mode') ?? 'by_amount') !== 'by_count') return;

                            $courseId = $get('courses_id');
                            if (!$courseId || !$value) return;

                            $course = \App\Models\Courses::find($courseId);
                            if (!$course || !$course->ends_at) return;

                            $state = [
                                'enrolled_at'       => $get('start_date'),
                                'pay_day_of_month'  => $get('pay_day_of_month'),
                                'down_payment'      => $get('down_payment'),
                                'installments_mode' => 'by_count',
                                'installments_count'=> $value,
                            ];

                            $tips = app(\App\Services\InstallmentPlanBuilder::class)->tipsForState($state, $course);

                            if (isset($tips['maxCount']) && (int)$value > (int)$tips['maxCount']) {
                                $fail('Troppe rate per la durata del corso. Massimo: '.$tips['maxCount']);
                            }
                        };
                    }),

                Forms\Components\TextInput::make('imp_rata')->label('Importo Rata')
                    ->required()
                    ->numeric()
                    ->suffixIcon('gmdi-euro-r')
                    ->live()
                    ->hidden(function(Get $get) : bool {
                        $test = Payment_options::find($get('payment_options_id'))!=null ? $test=Payment_options::find($get('payment_options_id')): null ;
                        //dd($test);
                        return !(str_contains($test?->name, 'Rateale')||str_contains($test?->name, 'rateale'));
                    }),


                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->reactive()
                    ->live()
                    ->label('Data iscrizione'),

                Forms\Components\Select::make('statuses_id')->label('Stato Iscrizione')
                    ->relationship(name: 'status', titleAttribute: 'name')
                    ->searchable('name')
                    ->preload(),

                 // ——— ANTEPRIMA ———
            Forms\Components\Section::make('Anteprima piano rate')
    //->visible(fn (Get $get) => ($get('payment_type') ?? 'full') === 'installments')
    ->schema([
        Forms\Components\View::make('filament.subscriptions.preview')
            ->live()
            ->extraAttributes([
                // hook JS per forzare un re-render del form al volo
                'x-data' => '{}',
                'x-init' => "
                    window.addEventListener('refreshPreview', () => {
                        // trigger un tick di Livewire (senza GET/redirect)
                        \$wire.\$refresh();
                    });
                ",
            ])
            ->viewData(function () {
                // legge l’ultima simulazione dalla sessione
                $rows = session('simulated_installments', []);
                $meta = session('simulated_meta', ['count'=>0,'total'=>0]);
                return compact('rows','meta');
            }),
    ]),

            ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption('50')
            //->defaultSort('created_at','desc')
            ->columns([
                /*Tables\Columns\IconColumn::make('status.name')
                    ->boolean()
                    ->label('In Regola?'),*/
                TextColumn::make('user.full_name')
                    ->formatStateUsing(function ($record) {
                        return $record->user->surname. ' ' .$record->user->name. ' ';
                    })
                    ->html()
                    ->sortable('surname')
                    ->copyable()
                    ->searchable()
                    ->label('Studente'),
                Tables\Columns\TextColumn::make('courses.name')
                    ->sortable()
                    ->label('Corso'),
                Tables\Columns\TextColumn::make('classrooms.name')
                    ->sortable()
                    ->label('Sezione'),
                Tables\Columns\TextColumn::make('paymentoptions.name')
                    ->sortable()
                    ->label('Opz. Pagamento'),
                Tables\Columns\TextColumn::make('status.name')
                    ->sortable()
                    ->label('Stato'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Iscritto dal'),
                Tables\Columns\TextColumn::make('next_payment')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Prossimo pagamento'),
                Tables\Columns\IconColumn::make('printed_cont')
                    ->boolean()
                    ->label('Contratto')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('printed_priv')
                    ->boolean()
                    ->label('Privacy')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('printed_whats')
                    ->boolean()
                    ->label('Whatsapp')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_teacher')
                    ->boolean()
                    ->label('Insegnante?'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('user_surname','asc')
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withAggregate('user', 'surname');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscriptions::route('/create'),
            'edit' => Pages\EditSubscriptions::route('/{record}/edit'),
        ];
    }
}
