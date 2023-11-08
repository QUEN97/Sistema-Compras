<div>
    <button wire:click="confirmSolicitudEdit({{ $solicitud_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="EditSolicitud{{ $solicitud_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar Solicitud</span>
    </button>

    <x-dialog-modal wire:model="EditSolicitud" id="EditSolicitud{{ $solicitud_id }}" class="flex items-center">
        <x-slot name="title">
            <span class="dark:text-white">{{ __('Editar Solicitud') }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="max-h-[320px] overflow-y-auto">
                @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                    <div class="flex flex-wrap gap-2 justify-center mb-2">
                        <div>
                            <x-label value="{{ __('Subtotal GENERAL de la solicitud') }}" />
                            <x-input wire:model="subtotal" type="number" name="subtotal" min="0" required
                                autofocus
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}" />
                            <x-input-error for="subtotal"></x-input-error>
                        </div>
                        <div>
                            <x-label value="{{ __('IVA en %') }}" />
                            <x-input wire:model="iva" type="number" name="iva" min="0" required autofocus
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}" />
                            <x-input-error for="iva"></x-input-error>
                        </div>
                        <div>
                            <x-label value="{{ __('ISR en %') }}" />
                            <x-input wire:model="isr" type="number" name="isr" min="0" required autofocus
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}" />
                            <x-input-error for="isr"></x-input-error>
                        </div>
                        <div>
                            <x-label value="{{ __('Razón Social') }}" />
                            <x-input wire:model="razon_social"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('razon_social') ? 'is-invalid' : '' }}"
                                type="text" name="razon_social" :value="old('razon_social')" required />
                            <x-input-error for="razon_social"></x-input-error>
                        </div>
                    </div>
                @endif
                <div class="flex flex-wrap gap-2 justify-center max-h-96 overflow-y-auto overflow-x-hidden">
                    @if ($produs)
                        @foreach ($listEX as $px => $k)
                            <div class="flex flex-col gap-2 border border-gray-400 p-2 rounded-md max-w-[280px]">
                                {{-- <input type="text" name="" id="" value="{{$k->producto_extraordinario}}"> --}}
                                <div>
                                    <x-label value="{{ __('Nombre del Producto/Servicio') }}" />
                                    <x-input wire:model="listEX.{{ $px }}.nombre" type="text"
                                        name="estraordinario" required autofocus
                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}" />
                                    <x-input-error for="listEX.{{ $px }}.nombre"></x-input-error>
                                </div>
                                @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                                    <div>
                                        <x-label value="{{ __('Proveedor') }}" />
                                        <select wire:model="listEX.{{ $px }}.proveedor"
                                            class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('proveedor') ? 'is-invalid' : '' }}"
                                            name="proveedor" required aria-required="true">
                                            <option hidden value="" selected>Seleccionar proveedor</option>
                                            @foreach ($proveedores as $provee)
                                                @if ($provee->flag_trash == 0)
                                                    <option value="{{ $provee->id }}">
                                                        {{ $provee->titulo_proveedor }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <x-input-error for="listEX.{{ $px }}.proveedor"></x-input-error>
                                    </div>
                                @endif
                                <div class="col-12 p-0">
                                    <x-label value="{{ __('Tipo') }}" />
                                    <select id="tiporepor" wire:model.defer="listEX.{{ $px }}.tipo"
                                        class="select-estaciones form-select form-control border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700  {{ $errors->has('tiporepor') ? 'is-invalid' : '' }}"
                                        name="tiporepor" required aria-required="true">
                                        @if ($k['tipo'] == 'Producto')
                                            <option value="Producto" selected>{{ __('Producto') }}</option>
                                            <option value="Servicio">{{ __('Servicio') }}</option>
                                        @else
                                            <option value="Producto">{{ __('Producto') }}</option>
                                            <option value="Servicio" selected>{{ __('Servicio') }}</option>
                                        @endif
                                    </select>
                                    <x-input-error for="listEx.{{ $px }}.tipo"></x-input-error>
                                </div>
                                <div>
                                    <x-label value="{{ __('Cantidad') }}" />
                                    <x-input wire:model="listEX.{{ $px }}.cantidad" type="number"
                                        min="1" name="estraordinario" required autofocus
                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}" />
                                    <x-input-error for="listEX.{{ $px }}.cantidad"></x-input-error>
                                </div>
                                @if (Auth::user()->permiso_id == 1)
                                    <div>
                                        <x-label value="{{ __('Precio Total') }}" />
                                        <x-input wire:model="listEX.{{ $px }}.total" type="number"
                                            min="1" name="estraordinario" required autofocus
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}" />
                                        <x-input-error for="listEX.{{ $px }}.total"></x-input-error>
                                    </div>
                                @endif

                                @if ($px > 0)
                                    <button type="button"
                                        wire:click="Eliminar({{ $k['id'] }},{{ $px }})"
                                        class="bg-red-500 text-white p-2 rounded-md hover:bg-red-700">
                                        {{ __('Eliminar') }}
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="mt-2 ">
                    <x-label value="{{ __('Motivo') }}" />
                    <x-input wire:model="motivo"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                        type="text" name="motivo" :value="old('motivo')" required autofocus autocomplete="motivo" />
                    <x-input-error for="motivo"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="EditarSolicitud({{ $solicitud_id }})"
                wire:loading.attr="disabled">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                {{ __('Actualizar y Generar PDF') }}
            </x-danger-button>
            <x-secondary-button wire:click="$toggle('EditSolicitud')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
