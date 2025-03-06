<?php

namespace App\Filament\Resources\PaymentsResource\Pages;

use App\Filament\Resources\PaymentsResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePayments extends CreateRecord
{
    protected static string $resource = PaymentsResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('print')->action('createAndPrint')->label('Salva e Stampa Ricevuta'),
            ...parent::getFormActions(),
        ];
    }

    public function createAndPrint()
    {
        $this->create();
        return redirect()->route('ricevuta.pdf.stampa',[$this->record]);
    }
}
