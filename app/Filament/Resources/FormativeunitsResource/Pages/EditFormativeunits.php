<?php

namespace App\Filament\Resources\FormativeunitsResource\Pages;

use App\Filament\Resources\FormativeunitsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormativeunits extends EditRecord
{
    protected static string $resource = FormativeunitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
