<x-app-layout>
    @section('title', 'Repuestos')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('REPUESTOS') }}
            </h2>
           <div>
            @if ($val->pivot->wr == 1)
            @livewire('repuestos.new-repuesto')
            @endif
           </div>
        </div>
    </x-slot>

@livewire('repuestos.repuesto-table')
    
</x-app-layout>