<?php

namespace App\Filament\Imports;

use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [

            ImportColumn::make('id')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('surname')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            /*ImportColumn::make('email_verified_at')
                ->rules(['email', 'datetime']),*/
            ImportColumn::make('cf')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('data_nascita')
                ->castStateUsing(function (string $state) : ?string {
                    if (blank($state)) {
                        return null;
                    }
                    $state = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/", "$1-$2-$3", $state);
                    return $state;
                })
                ->rules(['date']),
            ImportColumn::make('paese_nascita')
                ->rules(['max:255']),
            ImportColumn::make('luogo_nascita')
                ->rules(['max:255']),
            ImportColumn::make('prov_nascita')
                ->rules(['max:255']),
            ImportColumn::make('cittadinanza')
                ->rules(['max:255']),
            ImportColumn::make('titolo_studio')
                ->rules(['max:255']),
            ImportColumn::make('genere')
                ->rules(['max:255']),
            ImportColumn::make('note'),
            /*ImportColumn::make('document_uploaded'),
            ImportColumn::make('cf_uploaded'),
            ImportColumn::make('permesso_uploaded'),
            ImportColumn::make('interesse_uploaded'),
            ImportColumn::make('contratto_uploaded'),
            ImportColumn::make('whatsapp_uploaded'),*/
            ImportColumn::make('via')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('citta')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('cap')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('prov')
                ->rules(['max:255']),
            ImportColumn::make('paese_residenza')
                ->rules(['max:255']),
            ImportColumn::make('tel')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('piva')
                ->rules(['max:255']),

            /*ImportColumn::make('is_teacher')
                ->boolean()
                ->rules(['boolean']),*/
            /*ImportColumn::make('password')
                ->requiredMapping()
                ->rules(['required', 'max:255']),*/
            /*ImportColumn::make('full_name')
                ->rules(['max:255']),
            ImportColumn::make('address')
                ->rules(['max:255']),*/
        ];
    }

    protected function beforeValidate(): void
    {
        // Runs before the CSV data for a row is validated.
        if($this->data['via']=='' || $this->data['via']==null ){
            $this->data['via']='via non specificata';
        }
        if($this->data['citta']=='' || $this->data['citta']==null ){
            $this->data['citta']='città non specificata';
        }
        if($this->data['cap']=='' || $this->data['cap']==null ){
            $this->data['cap']='00000';
        }
        if($this->data['tel']=='' || $this->data['tel']==null ){
            $this->data['tel']='123456789';
        }
        if($this->data['genere']=='male'){
            $this->data['genere']='M';
        }else $this->data['genere']='F';

    }
    protected function afterValidate(): void
    {
        // Runs after the CSV data for a row is validated.
        //dd($this->data);
    }
    protected function beforeCreate(): void
    {
        // Similar to `beforeSave()`, but only runs when creating a new record.
        $this->record['password'] = str_replace(' ','',$this->data['name'].'0000');

    }


    public function resolveRecord(): ?User
    {
        //return User::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
        //    'email' => $this->data['email'],
        //]);


        return new User();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
