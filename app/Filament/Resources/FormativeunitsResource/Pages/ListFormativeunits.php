<?php

namespace App\Filament\Resources\FormativeunitsResource\Pages;

use App\Filament\Resources\FormativeunitsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormativeunits extends ListRecords
{
    protected static string $resource = FormativeunitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
