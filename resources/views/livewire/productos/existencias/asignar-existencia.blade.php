<div>
    <button wire:click="$set('showModal',true)" class="flex gap-2 items-center px-4 py-2 rounded-md bg-gray-400 dark:bg-dark-eval-3 dark:text-white text-gray-800 font-semibold" wire:loading.attr="disabled">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="w-5 h-5" fill="currentColor">
            <path d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z"/>
        </svg>
        <div>{{ __('Stock Estimado') }}</div>    
    </button>
    <x-dialog-modal wire:model="showModal" class="flex items-center">
        <x-slot name="title">{{__('Stock Estimado (Fijo)')}}</x-slot>
        <x-slot name="content">
            <div>
                <div>
                    <x-label value="{{ __('Estación') }}" for="estacion" />
                    <select name="estacion" id="estacion" wire:model="estacionID" required class="border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        <option hidden value="" selected>Seleccionar Estación</option>
                        @foreach ($estaciones as $es)
                            <option value="{{$es->id}}">{{$es->name}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="estacionID"></x-input-error>
                </div>
            </div>
            <div>
                @if ($productos)
                    <div class=" w-full">
                        <x-label value="{{ __('Producto') }}" for="producto" />
                        <select name="producto" id="producto" wire:model="producto.0.id" required class="border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700 w-full">
                            <option hidden value="" selected>Seleccionar Producto</option>
                            @foreach ($productos as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="producto.0.id"></x-input-error>
                    </div>
                    <div class="flex flex-wrap gap-2 items-end">
                        <div>
                            <x-label value="{{ __('Cantidad esperada en almacén') }}" for="cantidad" />
                            <x-input wire:model="producto.0.stock" type="number" min="1" id="cantidad" name="cantidad"/>
                            <x-input-error for="producto.0.stock"></x-input-error>
                        </div>
                        <div class="flex items-end">
                            <button type="button"
                                class="cursor-pointer inline-flex items-center px-2 py-2 bg-green-400 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition dark:bg-green-700"
                                wire:click.prevent="add({{ $i }})" title="Nuevo">
                                <span class="d-inline-block" tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                @endif
                <div>
                    @foreach ($inputs as $key => $item)
                        <div class="w-full flex flex-wrap gap-2 border-t border-b py-2">
                            <div class="mb-3 mr-2 ">
                                <x-label value="{{ __('Producto') }}"/>
                                <select id="producto.{{ $item }}" wire:model="producto.{{ $item }}.id"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700"
                                    name="producto.{{ $item }}.id" required>
                                    <option hidden value="" selected>Seleccionar producto</option>
                                    @if ($productos)
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error for="producto.{{ $item }}.id"></x-input-error>
                            </div>
                            <div class="mb-3 mr-2 ">
                                <x-label value="{{ __('Cantidad') }}" />
                                <x-input wire:model="producto.{{ $item }}.stock" type="text"
                                    name="producto.{{ $item }}.stock" :value="old('cantidad')" required autofocus
                                    autocomplete="cantidad"
                                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                <x-input-error for="producto.{{ $item }}.stock"></x-input-error>
                            </div>
                            <div class="mb-3 flex items-end">
                                <button type="button"
                                    class="inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"
                                    wire:click.prevent="remove({{ $key }}, {{ $item }})"
                                    title="Eliminar Producto">
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-content="Eliminar Producto"
                                        data-bs-placement="top">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" wire:click="insertarStock" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('showModal',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>