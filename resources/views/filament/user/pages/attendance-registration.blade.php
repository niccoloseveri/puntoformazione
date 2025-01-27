<x-filament-panels::page>
    @if (session()->has('message'))
        <div class="max-w-md mx-auto mt-6">
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 ml-3">Successo</h3>
                </div>
                <p class="mt-2 text-gray-700">
                    {{ session('message') }}
                </p>
            </div>
        </div>
    @endif
</x-filament-panels::page>
