<x-app-layout>
    @section('title', 'Almacen')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('ALMACEN') }}
            </h2>
            <div class="flex gap-2">
                @if ($user->permiso_id == '1' || $user->permiso_id == '2')
                    @livewire('productos.existencias.asignar-existencia')
                @endif
                @livewire('almacenes.almacen-create')
            </div>

        </div>
    </x-slot>

    @livewire('almacenes.almacen-table')

</x-app-layout>
