<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Actions\ImportAction as ActionsImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ImportAction;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionsImportAction::make()->importer(UserImporter::class),
            //ExcelImportAction::make()->color('primary')->disk('public')->label('Importa Excel'),
            Actions\CreateAction::make(),
        ];
    }
}
