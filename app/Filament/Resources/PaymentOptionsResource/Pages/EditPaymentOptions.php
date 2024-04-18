<?php

namespace App\Filament\Resources\PaymentOptionsResource\Pages;

use App\Filament\Resources\PaymentOptionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentOptions extends EditRecord
{
    protected static string $resource = PaymentOptionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
