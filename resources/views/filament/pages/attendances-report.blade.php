<x-filament-panels::page>
    <div class="grid grid-cols-3 gap-4">
        <!-- Left: Table (2/3 width) -->
        <div class="col-span-3">
            {{ $this->table }}
        </div>
        <!-- Right: You can keep additional filters or content if needed -->
        {{--<div class="col-span-1">
            <!-- Optional extra content -->
        </div>--}}
    </div>
</x-filament-panels::page>
