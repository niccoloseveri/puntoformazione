<?php

namespace App\Filament\Imports;

use App\Models\Payments;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PaymentsImporter extends Importer
{
    protected static ?string $model = Payments::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('users_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('courses_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('classrooms_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('total_amount')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('discount')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('amount_paid')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('is_paid')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('payment_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('payment_method')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('note'),
            ImportColumn::make('n_rata')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Payments
    {
        // return Payments::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Payments();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your payments import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
