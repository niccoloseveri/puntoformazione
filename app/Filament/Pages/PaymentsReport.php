<?php

namespace App\Filament\Pages;

use App\Filament\Resources\PaymentsResource;
use Filament\Pages\Page;
use App\Models\Payments;
use App\Models\Classrooms;
use App\Models\Courses;
use Carbon\Carbon;
use Filament\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Livewire;
use Livewire\Component as LivewireC;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class PaymentsReport extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $model = Payments::class;

    protected static ?string $navigationIcon = 'gmdi-monetization-on-s';
    //protected static ?string $navigationGroup = 'Anagrafica';
    //protected static ?string $navigationParentItem = 'Utenti';
    protected static ?string $modelLabel = 'Report Pagamento';
    protected static ?string $navigationLabel = 'Report Pagamenti';
    protected static ?string $title = 'Report Pagamenti';

    protected static string $view = 'filament.pages.payments-report';


    public static function table(Table $table) : Table {
        return $table
            ->query(Payments::query())

            ->columns([
            Tables\Columns\TextColumn::make('user.full_name')->label('Studente')
            ->formatStateUsing(function ($record) {
                return $record->user->surname. ' ' .$record->user->name. ' ';
            })
            ->html()
            ->sortable('surname')
            ->copyable()
            ,
            //data pagamento
            Tables\Columns\TextColumn::make('payment_date')->label('Data Pagamento')
                ->sortable()
                ,
            //amount_paid
            Tables\Columns\TextColumn::make('amount_paid')->label('Importo Pagato')
                ->sortable()
                ->money('EUR'),
           ])
           ->filters([
                /*
                SelectFilter::make('course')
                ->relationship('course','name')
                ->label('Corso')
                ->placeholder('Seleziona un corso')
                ->preload()
                ->searchable(),

                SelectFilter::make('classroom')
                ->relationship('classroom','name',fn (Builder $query, Get $get) => $query->whereHas('course', fn (Builder $query) => $query->where('id', $get('course'))))
                ->label('Classe')
                ->placeholder('Seleziona una classe')
                ->searchable(),
            */
                SelectFilter::make('users_id')
                    ->relationship('user', 'full_name')
                    ->label('Studente')
                    ->placeholder('Seleziona uno studente')
                    ->searchable()
                    ->preload()
                    ->columns(2)
                ,
                DateRangeFilter::make('payment_date')->label('Data Pagamento')->placeholder('Seleziona un periodo')->columns(2)->columnSpanFull(),

                Filter::make('course_id')
                    ->form([
                        Select::make('course_id')->label('Corso')
                            ->live()
                            ->dehydrated(false)
                            ->options(Courses::pluck('name', 'id'))
                            //->default(Courses::where('id',5)->first()->id)
                            ->preload()
                            ->native(false)
                            ,
                        Select::make('classrooms_id')->label('Classe')
                            ->options(fn (Get $get):Collection => Classrooms::query()
                                ->where('course_id', $get('course_id'))
                                ->pluck('name', 'id'))
                            ->preload()
                            ->native(false)
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data):Builder{
                        if (isset($data['course_id'])) {
                            $query->where('courses_id', $data['course_id']);
                        }
                        if (isset($data['classrooms_id'])) {
                            $query->where('classrooms_id', $data['classrooms_id']);
                        }
                        return $query;
                    })
                    ->indicateUsing(function (array $data) : array {
                        $indicators=[];
                        if($data['course_id'] ?? null){
                            $indicators[] = Indicator::make('Corso: '.Courses::find($data['course_id'])->name)
                            ->removeField('course_id');
                        }
                        if($data['classrooms_id'] ?? null){
                            $indicators[] = Indicator::make('Classe: '.Classrooms::find($data['classrooms_id'])->name)
                            ->removeField('classrooms_id');
                        }

                        return $indicators;
                    }),
                /*
                Filter::make('course_id')
                ->form([
                    Select::make('course_id')->label('Corso')
                    ->live()
                    ->dehydrated(false)
                    ->options(Courses::pluck('name', 'id'))
                    //->placeholder('Seleziona un corso')

                    ->afterStateUpdated(function (LivewireC $livewire) {
                        $livewire->reset('data.classrooms_id');
                    }),

                ]),

                Filter::make('classrooms_id')
                ->form([
                    Select::make('classrooms_id')->label('Classe')
                    ->live()
                    //->placeholder(fn (Get $get): string => empty($get('course_id')) ? 'Seleziona prima un corso' : 'Seleziona la classe')
                    //->options(fn($get) => Classrooms::where('course_id', $get('course_id'))->pluck('name', 'id'))
                    ->options(fn(Get $get) : Collection => Classrooms::query()->where('course_id', $get('course_id'))->pluck('name', 'id'))
                ]),
                */
                ],layout:FiltersLayout::AboveContent)
            ->actions([
                Action::make('edit')->url(fn ($record) => route('filament.admin.resources.payments.edit',[$record]))
                    ->label('Modifica')
                    ->iconButton()
                    ->icon('heroicon-s-pencil-square')
                    ->hidden(auth()->user()->hasRole('Nazzareno')),
                Action::make('print')->url(fn ($record) => route('ricevuta.pdf.stampa',[$record]))->openUrlInNewTab()
                    ->label('Stampa Ricevuta')
                    ->iconButton()
                    ->icon('gmdi-print')
                    ->hidden(auth()->user()->hasRole('Nazzareno')),



            ], position: ActionsPosition::BeforeColumns)
           ;

    }

}
