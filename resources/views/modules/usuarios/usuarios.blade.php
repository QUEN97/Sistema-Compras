<x-app-layout>
    @section('title', 'Usuarios')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('USUARIOS') }}
            </h2>
            @if ($val->pivot->wr == 1)
            @livewire('usuarios.user-create')
            @endif
        </div>
    </x-slot>
    <div>
        @livewire('usuarios.user-table')
    </div>
</x-app-layout>
