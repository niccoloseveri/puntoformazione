<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Support\Enums\ActionSize;

class Dashboard extends \Filament\Pages\Dashboard
{
    // ...
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'gmdi-home-r';

    protected function getHeaderActions(): array
    {
       return [
            Action::make('subscribe')->label('Nuova Iscrizione')->color('success')->size(ActionSize::Large)->icon('gmdi-person-add-alt-1'),
            Action::make('payment')->color('warning')->label('Nuovo Pagamento')->size(ActionSize::Large)->icon('gmdi-payments-r')
       ];
    }
}