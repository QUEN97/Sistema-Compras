<x-app-layout>

    @section('title', 'Manuales')

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('MANUALES DEL SISTEMA') }}
            </h2>
            @if ($val->pivot->wr == 1)
                @livewire('sistema.manuales.new-manual')
            @endif
        </div>
    </x-slot>

    @livewire('sistema.manuales.table-manuales')

</x-app-layout>
