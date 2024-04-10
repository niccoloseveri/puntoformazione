<?php

namespace App\Filament\Resources\ClassroomsResource\Pages;

use App\Filament\Resources\ClassroomsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClassrooms extends CreateRecord
{
    protected static string $resource = ClassroomsResource::class;

    protected function getRedirectUrl(): string {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
