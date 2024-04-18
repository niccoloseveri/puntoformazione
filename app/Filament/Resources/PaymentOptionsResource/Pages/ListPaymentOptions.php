<?php

namespace App\Filament\Resources\PaymentOptionsResource\Pages;

use App\Filament\Resources\PaymentOptionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentOptions extends ListRecords
{
    protected static string $resource = PaymentOptionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
