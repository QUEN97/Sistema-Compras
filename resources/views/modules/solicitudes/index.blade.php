<x-app-layout>
    @section('title', 'Solicitudes')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('SOLICITUDES') }}
            </h2>
            @if ($val->pivot->wr == 1)
                @livewire('solicitudes.solicitud-create')
            @endif
        </div>
    </x-slot>
    @livewire('solicitudes.solicitudes-table')
</x-app-layout>
