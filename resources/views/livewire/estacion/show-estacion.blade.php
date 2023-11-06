<div>

    <button wire:click="confirmShowEstacion({{ $estacion_show_id }})" wire:loading.attr="disabled"
        class="tooltip" data-target="ShowEstacion{{ $estacion_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-400">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgEstacion" id="ShowEstacion{{ $estacion_show_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General de la Estación') }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full rounded overflow-hidden shadow-lg">
                {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2 text-black">{{ $this->titulo_estacion }}</div>
                    <div class="px-2">
                        <div class="flex -mx-2 bg-indigo-300 p-2 rounded-md">
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Gerente: </span>
                                @if ($gerentestat == 'Inactivo')
                                    <p class="text-red-500">
                                        <span class="text-xs">{{ $this->gerente }}</span>
                                    </p>
                                @else
                                    <span class="text-xs"> {{ $this->gerente }}</span>
                                @endif
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Supervisor:</span>
                                @if ($supervisorstat == 'Inactivo')
                                    <p class="text-red-500">
                                        <span class="text-xs"> {{ $this->supervisor }}</span>
                                    </p>
                                @else
                                    <span class="text-xs"> {{ $this->supervisor }}</span>
                                @endif
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Status:</span>
                                <span class="text-xs">{{ $this->status }}</span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700"> Registro:</span>
                                <span class="text-xs">{{ $this->created_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($estaciones->productos->isnotEmpty())
                    <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                        <details>
                            <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                Productos en Almacén</summary>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Categoria</th>
                                        <th class="px-4 py-2">Unidad</th>
                                        <th class="px-4 py-2">Stock</th>
                                        <th class="px-4 py-2">Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($estaciones->productos as $produc)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $produc->name }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $produc->categoria->name }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs">{{ $produc->unidad }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $produc->pivot->stock }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs">
                                                    @if ($produc->pivot->flag_trash == 0)
                                                    <span class="text-xs">{{ __('En Sistema') }}</span>
                                                @else
                                                    <span class="text-xs">{{ __('En Papelera') }}</span>
                                                @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="5">Sin datos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </details>
                    </div>
                @endif
                <div class="px-6 pt-4 pb-2">
                    <span class="text-indigo-500 font-bold">Zona:</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $this->zonas }}</span>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgEstacion')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
