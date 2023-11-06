<div>

    <button wire:click="confirmShowPermiso({{ $permiso_show_id }})" wire:loading.attr="disabled"
        class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300"
        data-target="ShowPermiso{{ $permiso_show_id }}">
        Ver
    </button>

    <x-dialog-modal wire:model="ShowgPermiso" id="ShowPermiso{{ $permiso_show_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General del Permiso') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">

                <div class="mb-2">
                    <div class="mb-2">
                        <x-label value="{{ __('Titulo Permiso:') }}" />
                        <x-label>
                            <span
                                class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $this->titulo_permiso }}</span>
                        </x-label>
                    </div>
                </div>

                <div class="mb-2">
                    <x-label value="{{ __('Descripción:') }}" />
                    <textarea readonly
                        class="resize-none rounded-md bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5  dark:bg-gray-700 dark:text-gray-300">
                    {{ $this->descripcion }}
                </textarea>
                </div>

                <div class="mb-2">
                    <x-label value="{{ __('Fecha de Registro:') }}" />
                    <x-label>
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $this->created_format }}</span>
                    </x-label>
                </div>

                <div class="mb-2">
                    <x-label value="{{ __('Usuarios:') }}" />
                    <x-label>
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $this->user }}</span>
                    </x-label>
                </div>
            </div>

            <div class="mt-2">
                <table class="border-collapse  bg-white text-center text-sm text-gray-500">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Panel</th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Leer</th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Escribir</th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Editar</th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Eliminar</th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Ver Más </th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Ver Papelera</th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Restaurar Papelera</th>
                            <th
                                class="p-2 text-xs uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                Ver Más Papelera
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                        {{-- @foreach ($permisos->panels as $permissio)
                    <tr>
                        <td>
                            {{ $permissio->titulo_panel }} 
                        </td>
                        <td>
                            @if ($permissio->pivot->re == 1)
                                <div class="text-success">
                                    <i class="fa-solid fa-square-check fa-2xl"></i>
                                </div>
                            @else
                                <div class="text-danger">
                                    <i class="fa-solid fa-square-xmark fa-2xl"></i>
                                </div>
                            @endif
                        </td>
                        <td> 
                            @if ($permissio->pivot->wr == 1)
                                <div class="text-success">
                                    <i class="fa-solid fa-square-check fa-2xl"></i>
                                </div>
                            @else
                                <div class="text-danger">
                                    <i class="fa-solid fa-square-xmark fa-2xl"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($permissio->pivot->ed == 1)
                                <div class="text-success">
                                    <i class="fa-solid fa-square-check fa-2xl"></i>
                                </div>
                            @else
                                <div class="text-danger">
                                    <i class="fa-solid fa-square-xmark fa-2xl"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($permissio->pivot->de == 1)
                                <div class="text-success">
                                    <i class="fa-solid fa-square-check fa-2xl"></i>
                                </div>
                            @else
                                <div class="text-danger">
                                    <i class="fa-solid fa-square-xmark fa-2xl"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($permissio->pivot->vermas == 1)
                                <div class="text-success">
                                    <i class="fa-solid fa-square-check fa-2xl"></i>
                                </div>
                            @else
                                <div class="text-danger">
                                    <i class="fa-solid fa-square-xmark fa-2xl"></i>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach  --}}

                        @foreach ($permisos as $permissio)
                            <tr>
                                <td>
                                    {{ $permissio->titulo_panel }}
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->re == 1)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->wr == 1)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->ed == 1)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->de == 1)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->vermas == 1)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->verpap == 1 && $item->panel_id != 4)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->restpap == 1 && $item->panel_id != 4)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach ($perm as $item)
                                        @if ($item->panel_id == $permissio->id)
                                            @if ($item->vermaspap == 1 && $item->panel_id != 4)
                                                <div class="text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgPermiso')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
