<div>

    <button wire:click="confirmShowZona({{ $zona_show_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="ShowZona{{ $zona_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgZona" id="ShowZona{{ $zona_show_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General de la Zona') }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full rounded overflow-hidden shadow-lg">
                {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2 text-black">{{ $this->name }}</div>
                    <div class="px-2">
                        <div class="flex -mx-2 bg-indigo-300 p-2 rounded-md">
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Gerentes: </span>
                                <span class="text-xs">{{ $this->gerent }}</span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Estaciones: </span>
                                <span class="text-xs">{{ $this->estacions }}</span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Productos:</span>
                                <span class="text-xs">{{ $this->prods }}</span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700">Status:</span>
                                <span class="text-xs">{{ $this->status }}</span>
                            </div>
                            <div class="w-1/3 px-2">
                                <span class="text-gray-700"> Registro:</span>
                                <span class="text-xs"> {{ $this->created_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    @if (!empty($db))
                        <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                    Gerentes</summary>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Nombre</th>
                                            <th class="px-4 py-2">Estacion</th>
                                            <th class="px-4 py-2">Status</th>
                                            <th class="px-4 py-2">Disponibilidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> {{ $user->name }}</span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if (empty($user->estacion->name))
                                                            <p class="text-red-500">
                                                                {{ __('Sin estación Asignada') }}
                                                            </p>
                                                        @else
                                                            {{ $user->estacion->name }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($user->status == 'Activo')
                                                            <i class="text-green-500"></i>
                                                            {{ $user->status }}
                                                        @else
                                                            <i class="text-red-500"></i>
                                                            {{ $user->status }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($user->deleted_at == null)
                                                            {{ __('En Sistema') }}
                                                        @else
                                                            {{ __('En Papelera') }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border px-4 py-2" colspan="4">Sin datos.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </details>
                        </div>
                    @endif
                </div>
                <br>
                <div>
                    @if ($isSuper->isnotEmpty())
                        <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                    Estaciones</summary>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Nombre</th>
                                            <th class="px-4 py-2">Status</th>
                                            <th class="px-4 py-2">Disponibilidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($isSuper as $estacion)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> {{ $estacion->name }} </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($estacion->status == 'Activo')
                                                            <i class="text-green-500"></i>
                                                            {{ $estacion->status }}
                                                        @else
                                                            <i class="text-red-500"></i>
                                                            {{ $estacion->status }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($estacion->deleted_at == null)
                                                            {{ __('En Sistema') }}
                                                        @else
                                                            {{ __('En Papelera') }}
                                                        @endif
                                                    </span>
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
                    @elseif ($estaciones->isnotEmpty())
                        <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                    Estaciones</summary>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Nombre</th>
                                            <th class="px-4 py-2">Status</th>
                                            <th class="px-4 py-2">Disponibilidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($estaciones as $estacion)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> {{ $estacion->name }} </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($estacion->status == 'Activo')
                                                            <i class="text-green-500"></i>
                                                            {{ $estacion->status }}
                                                        @else
                                                            <i class="text-red-500"></i>
                                                            {{ $estacion->status }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($estacion->deleted_at == null)
                                                            {{ __('En Sistema') }}
                                                        @else
                                                            {{ __('En Papelera') }}
                                                        @endif
                                                    </span>
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
                <br>
                <div>
                    @if ($productos->isnotEmpty())
                        <div class="border rounded-lg overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 py-2 px-4 cursor-pointer">Click para mostrar/ocultar
                                    Productos</summary>
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">Nombre</th>
                                            <th class="px-4 py-2">Categoria</th>
                                            <th class="px-4 py-2">Stock</th>
                                            <th class="px-4 py-2">Disponibilidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($productos as $prod)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> {{ $prod->name }}</span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        {{ $prod->categoria->name }}
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        {{ $prod->stock }}
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($prod->flag_trash == 0)
                                                            {{ __('En Sistema') }}
                                                        @else
                                                            {{ __('En Papelera') }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border px-4 py-2" colspan="4">Sin datos.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </details>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgZona')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
