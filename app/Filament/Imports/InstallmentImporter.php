<?php

namespace App\Filament\Imports;

use App\Models\Installment;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class InstallmentImporter extends Importer
{
    protected static ?string $model = Installment::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('subscriptions_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('n_rata')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('due_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('amount')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('paid_at')
                ->rules(['datetime']),
        ];
    }

    public function resolveRecord(): ?Installment
    {
        // return Installment::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        // 1. Parse 'contatti' field (e.g., "email@test.com, +39..." OR "+39..., email@test.com")
        $contactParts = explode(',', $this->data['contatti']);
        $firstIdentifier = trim($contactParts[0]);

        // 2. Identify if it's an email or phone number
        $user = null;
        if (filter_var($firstIdentifier, FILTER_VALIDATE_EMAIL)) {
            $user = \App\Models\User::where('email', $firstIdentifier)->first();
        } else {
            // Remove spaces/special chars from CSV phone number to match DB format if necessary
            $user = \App\Models\User::where('tel', $firstIdentifier)
                ->first();
        }

        if (!$user) return null;
        // 3. Extract installment number from "Rata 1 di 18"
        preg_match('/Rata (\d+)/', $this->data['rata'], $matches);
        $nRata = $matches[1] ?? null;

        // 4. Deduce Subscription (Finding the most recent course for this user)
        $subscription = \App\Models\Subscriptions::where('user_id', $user->id)->latest()->first();
        if (!$subscription) return null;

        return Installment::firstOrNew([
            'subscriptions_id' => $subscription->id,
            'n_rata' => $nRata], [
        'due_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $this->data['scadenza_rata']),
        // Standardize currency string '183,39 €' to integer cents
        'amount' => (int) (str_replace([',', '.', '€', ' '], ['', '', '', ''], $this->data['rata_da_pagare'])),
    ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your installment import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
