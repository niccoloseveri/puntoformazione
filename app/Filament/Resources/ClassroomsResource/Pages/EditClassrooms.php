<?php

namespace App\Filament\Resources\ClassroomsResource\Pages;

use App\Filament\Resources\ClassroomsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassrooms extends EditRecord
{
    protected static string $resource = ClassroomsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
