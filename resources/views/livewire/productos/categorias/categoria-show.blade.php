<div>

    <button wire:click="confirmShowCategoria({{ $categoria_show_id }})" wire:loading.attr="disabled"
        class="tooltip" data-target="ShowCategoria{{ $categoria_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-yellow-500 dark:hover:text-yellow-300">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgCategoria" id="ShowCategoria{{ $categoria_show_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General de la Categoria') }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full rounded overflow-hidden shadow-lg">
                {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2 text-black">{{ $this->titulo_categoria }}</div>
                    <div class="px-2">
                        <div class="flex -mx-2 bg-indigo-300 p-2 rounded-md">
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Productos:</span>
                                <span class="text-xs">{{ $this->productos }}</span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Proveedores:</span>
                                <span class="text-xs"> {{ $this->proveedores }}</span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Status:</span>
                                <span class="text-xs">
                                    @if ($status = 'Activo')
                                    <span class="text-green-700"> {{ $this->status }}</span>
                                    @else
                                    <span class="text-red-700"> {{ $this->status }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700"> Registro:</span>
                                <span class="text-xs">{{ $this->created_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($productos_tabla->isnotEmpty())
                    <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                        <details>
                            <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                Productos en esta Categoria</summary>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Nombre</th>
                                        <th class="px-4 py-2">Status</th>
                                        <th class="px-4 py-2">Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos_tabla as $producto)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $producto->name }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> @if ($producto->status == 'Activo')
                                                    <i
                                                        class="text-green-500"></i>
                                                    {{ $producto->status }}
                                                @else
                                                    <i
                                                        class="text-red-500"></i>
                                                    {{ $producto->status }}
                                                @endif</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs">@if ($producto->flag_trash == 0)
                                                    <i
                                                        class="text-green-500"></i>
                                                    {{ __('En Sistema') }}
                                                @else
                                                    <i
                                                        class="text-red-500"></i>
                                                    {{ __('En Papelera') }}
                                                @endif</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="3">Sin datos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </details>
                    </div>
                @endif
                <br>
                @if ($proveedores_tabla->isnotEmpty())
                    <div class="border rounded-lg overflow-hidden">
                        <details>
                            <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                Proveedores en esta Categoria</summary>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Proveedor</th>
                                        <th class="px-4 py-2">RFC</th>
                                        <th class="px-4 py-2">Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($proveedores_tabla as $provee)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $provee->titulo_proveedor }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> {{ $provee->rfc_proveedor }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs">@if ($provee->flag_trash == 0)
                                                    <i
                                                        class="text-green-500"></i>
                                                    {{ __('En Sistema') }}
                                                @else
                                                    <i
                                                        class="text-red-500"></i>
                                                    {{ __('En Papelera') }}
                                                @endif</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="3">Sin datos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </details>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgCategoria')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
