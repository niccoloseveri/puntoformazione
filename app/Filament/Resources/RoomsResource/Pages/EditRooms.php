<?php

namespace App\Filament\Resources\RoomsResource\Pages;

use App\Filament\Resources\RoomsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRooms extends EditRecord
{
    protected static string $resource = RoomsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

     protected function mutateFormDataBeforeSave(array $data): array {

        $color= ltrim($data['color'],'#');
        $json =file_get_contents('https://webaim.org/resources/contrastchecker/?fcolor=000000&bcolor='.$color.'&api');
        $djson = json_decode($json,true);
        $data['textColor'] = $djson['AA']=='pass' ? '#000000' : '#FFFFFF';
        return $data;
    }
}
