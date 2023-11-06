<x-app-layout>
    @section('title', 'Zonas')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('ZONAS') }}
            </h2>
            @if ($val->pivot->wr == 1)
                @livewire('zonas.zona-create')
            @endif
        </div>
    </x-slot>
    @livewire('zonas.zona-table')
</x-app-layout>
