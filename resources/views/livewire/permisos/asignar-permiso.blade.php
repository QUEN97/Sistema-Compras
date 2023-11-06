<div>
    <button wire:click="confirmPermisoAsig({{ $permiso_asig_id }})" wire:loading.attr="disabled"
        class="bg-green-100  text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300"
        data-target="AsigPermiso{{ $permiso_asig_id }}">
        Asignar
    </button>

    <x-dialog-modal wire:model="AsigPermiso" id="AsigPermiso{{ $permiso_asig_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Asignar Permisos a:') . ' ' . $permiso_asig_name }}
        </x-slot>

        <x-slot name="content">

            <div class="flex flex-wrap">
                <form action="{{ route('asignacionpermiso.asignar', $permiso_asig_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap">
                        <div class="mb-3 mr-2">
                            <x-label value="{{ __('Nombre del Rol') }}" />
                            <x-input wire:model="titulo_permiso"
                                class="{{ $errors->has('titulo_permiso') ? 'is-invalid' : '' }}" type="text"
                                name="titulo_permiso" :value="old('titulo_permiso')" maxlength="30" required autofocus
                                autocomplete="titulo_permiso" />
                            <x-input-error for="titulo_permiso"></x-input-error>
                            @if ($errors->has('titulo_permiso'))
                                <span class="text-red-500">{{ $errors->first('titulo_permiso') }}</span>
                            @endif
                        </div>

                        <div class="mb-3 ml-2">
                            <x-label value="{{ __('Descripción') }}" />
                            <x-input wire:model="descripcion"
                                class="{{ $errors->has('descripcion') ? 'is-invalid' : '' }}" type="text"
                                name="descripcion" :value="old('descripcion')" required maxlength="200" autofocus
                                autocomplete="descripcion" />
                            <x-input-error for="descripcion"></x-input-error>
                            @if ($errors->has('descripcion'))
                                <span class="text-red-500">{{ $errors->first('descripcion') }}</span>
                            @endif
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
                            <tbody class="table-light">

                                @foreach ($permission as $permissio)
                                    <tr>
                                        <td>
                                            {{ $permissio->titulo_panel }}
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="leer[{{ $permissio->id }}]" value="1"
                                                    id="leer.{{ $permissio->id }}" type="checkbox"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-success checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-success checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->re == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="crear[{{ $permissio->id }}]" value="1"
                                                    id="crear.{{ $permissio->id }}" type="checkbox"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->wr == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="editar[{{ $permissio->id }}]" value="1"
                                                    id="editar.{{ $permissio->id }}" type="checkbox"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->ed == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="eliminar[{{ $permissio->id }}]" type="checkbox"
                                                    value="1" id="eliminar.{{ $permissio->id }}"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->de == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="vermas[{{ $permissio->id }}]" type="checkbox"
                                                    value="1" id="vermas.{{ $permissio->id }}"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->vermas == 1)
                                                        {{ 'checked' }}
                                                    @endif    
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="verpap[{{ $permissio->id }}]" type="checkbox"
                                                    value="1" id="verpap.{{ $permissio->id }}"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->verpap == 1 && $item->panel_id != 4)
                                                        {{ 'checked' }}
                                                    @elseif ($item->verpap == 1 || $item->panel_id == 4)
                                                        {{ 'disabled' }}
                                                    @endif    
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="restpap[{{ $permissio->id }}]" type="checkbox"
                                                    value="1" id="restpap.{{ $permissio->id }}"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->restpap == 1 && $item->panel_id != 4)
                                                        {{ 'checked' }}
                                                    @elseif ($item->restpap == 1 || $item->panel_id == 4)
                                                        {{ 'disabled' }}
                                                    @endif
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="">
                                                <input name="vermaspap[{{ $permissio->id }}]" type="checkbox"
                                                    value="1" id="vermaspap.{{ $permissio->id }}"
                                                    class="mt-[0.3rem] mr-2 h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-[rgba(0,0,0,0.25)] outline-none before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-white after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                                                    @foreach ($perm as $item)
                                                @if ($item->panel_id == $permissio->id)
                                                    @if ($item->vermaspap == 1 && $item->panel_id != 4)
                                                        {{ 'checked' }}
                                                    @elseif ($item->vermaspap == 1 || $item->panel_id == 4)
                                                        {{ 'disabled' }}
                                                    @endif    
                                                @endif @endforeach>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="mr-2 bg-green-500 p-2 text-white font-bold  rounded-md" wire:click="AsignarPermiso({{ $permiso_asig_id }})">
                            Aceptar
                        </button>
                    </div>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer" class="hidden">
            {{-- <button type="submit" class="mr-2 bg-green-500 p-2 text-white font-bold  rounded-md"
                wire:click="AsignarPermiso({{ $permiso_asig_id }})" wire:loading.attr="disabled">
                Aceptar
            </button>

            <x-secondary-button wire:click="$toggle('AsigPermiso')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button> --}}
        </x-slot>
    </x-dialog-modal>
</div>
