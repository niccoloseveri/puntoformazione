<?php

namespace App\Filament\Resources\RoomsResource\Pages;

use App\Filament\Resources\RoomsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRooms extends CreateRecord
{
    protected static string $resource = RoomsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array {

        $color= ltrim($data['color'],'#');
        $json =file_get_contents('https://webaim.org/resources/contrastchecker/?fcolor=000000&bcolor='.$color.'&api');
        $djson = json_decode($json,true);
        $data['textColor'] = $djson['AA']=='pass' ? '#FFFFFF' : '#000000';
        return $data;
    }
}
