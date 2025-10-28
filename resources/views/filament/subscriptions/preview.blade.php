<div class="space-y-3">
    @if (!empty($meta['minQuota']))
        <div class="rounded-md border border-yellow-200 bg-yellow-50 p-3 text-sm text-yellow-800">
            Importo rata insufficiente. Quota minima suggerita:
            <strong>€ {{ number_format($meta['minQuota'], 2, ',', '.') }}</strong>
        </div>
    @endif

    @if (!empty($meta['calcMonthly']))
        <div class="rounded-md border border-blue-200 bg-blue-50 p-3 text-sm text-blue-800">
            Importo mensile stimato:
            <strong>€ {{ number_format($meta['calcMonthly'], 2, ',', '.') }}</strong>
        </div>
    @endif

    <div class="text-sm text-gray-500">Piano simulato (non salvato):</div>

    @if (!empty($rows))
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr>
                        <th class="px-3 py-2 text-left">#</th>
                        <th class="px-3 py-2 text-left">Scadenza</th>
                        <th class="px-3 py-2 text-left">Importo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($rows as $r)
                        <tr>
                            <td class="px-3 py-2">{{ $r['sequence'] ?? '-' }}</td>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($r['due_date'])->format('d/m/Y') }}</td>
                            <td class="px-3 py-2">€ {{ number_format($r['amount'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td class="px-3 py-2 font-medium" colspan="2">Totale</td>
                        <td class="px-3 py-2 font-medium">
                            € {{ number_format(($meta['total'] ?? 0)/100, 2, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="rounded-md border border-gray-200 bg-gray-50 p-3 text-sm text-gray-700">
            Nessuna rata generata. Premi "Simula piano rate".
        </div>
    @endif
</div>
