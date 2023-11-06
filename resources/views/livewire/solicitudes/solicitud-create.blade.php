<div>
    <x-button wire:click="$set('create',true)">
        {{ __('Nueva Solicitud') }}
    </x-button>

    <x-dialog-modal wire:model="create" class="flex items-center">
        <x-slot name="title">
            <span class="text-gray-800 dark:text-white font-extrabold"> {{ __('Nueva Solicitud') }}</span>
        </x-slot>

        <x-slot name="content">
            <div wire:key="step1" class="{{ $currentStep == 1 ? 'block' : 'hidden' }}">
                <span
                    class="bg-purple-100 text-purple-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">{{ __('Solicitud:') }}</span>
                <div class="mt-2 p-4 " style="display: flex; justify-content: center;">
                    <div class="flex gap-2 pb-2">
                        <div>
                            <input type="radio" name="soliType" id="ordinario" value="Ordinario" wire:model="soliType"
                                class="hidden peer">
                            <label for="ordinario"
                                class="border rounded-lg px-3 py-1 border-pink-600 peer-checked:bg-pink-600 peer-checked:text-white cursor-pointer tooltip">
                                Ordinaria
                                <span class="tooltiptext text-xs">Productos de uso regular establecidos en el
                                    sistema.</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="soliType" id="extra" value="Extraordinario"
                                wire:model="soliType" class="hidden peer">
                            <label for="extra"
                                class="border rounded-lg px-3 py-1 border-pink-600 peer-checked:bg-pink-600 peer-checked:text-white cursor-pointer tooltip">
                                Extraordinaria
                                <span class="tooltiptext text-xs">Productos/Servicios poco frecuentes o solicitados por
                                    terceros.</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <button
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                            wire:click="Step" {{ !is_null($soliType) && !empty($soliType) ? '' : 'disabled' }}>
                            {{ __('Siguiente') }}
                        </button>
                    </div>
                </div>
            </div>

            <!--Tipos de Compra -->

            <!-- Compras Ordinarias -->
            @if ($soliType == 'Ordinario')
                <div wire:key="step2" class="{{ $currentStep == 2 ? 'block' : 'hidden' }} max-h-[320px] overflow-y-auto">
                    <span
                        class="bg-green-100 text-green-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ __('Solicitar Producto') }}</span>
                    <div class="mt-2 p-4 ">
                        <div class="flex flex-wrap">
                            <div class="mb-3 mr-2 ">
                                <x-label value="{{ __('Categoría') }}" />
                                <select id="categoria" wire:model="categoria"
                                    class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('categoria') ? 'is-invalid' : '' }}"
                                    name="categoria" required aria-required="true">
                                    <option hidden value="" selected>Seleccionar categoría</option>
                                    @foreach ($categorias as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="categoria"></x-input-error>
                            </div>
                            @if ($productos)
                                <div class="mb-3 ">
                                    <x-label value="{{ __('Producto') }}" />
                                    <select id="producto" wire:model="producto.1"
                                        class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('producto.1') ? 'is-invalid' : '' }}"
                                        name="producto.1" required aria-required="true">
                                        <option hidden value="" selected>Seleccionar producto</option>
                                        @foreach ($productos as $produ)
                                            <option class="break-all" value="{{ $produ->id }}">{{ $produ->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="producto.1"></x-input-error>
                                </div>
							 @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                                <div class="mb-3 mr-2">
                                    <x-label value="{{ __('Proveedor') }}" />
                                    <select id="producto" wire:model="proveedor.1"
                                        class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto.1') ? 'is-invalid' : '' }}"
                                        name="proveedor.1" required aria-required="true">
                                        <option hidden value="" selected>Seleccionar proveedor</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">{{ $proveedor->titulo_proveedor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="proveedor.1"></x-input-error>
                                </div>
							@endif
                            @endif
                            <div class="mb-3 mr-2 ">
                                <x-label value="{{ __('Cantidad') }}" />
                                <x-input wire:model="cantidad.1"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('cantidad.1') ? 'is-invalid' : '' }}"
                                    type="text" name="cantidad.1" :value="old('cantidad')" required autofocus
                                    autocomplete="cantidad.1" id="cantidad"
                                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                <x-input-error for="cantidad.1"></x-input-error>
                            </div>

                            @if (Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 2)
                                <div class="mb-3 mr-2 ">
                                    <x-label value="{{ __('Estación') }}" />
                                    <select id="estacion" wire:model="estacion"
                                        class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                        name="estacion" required aria-required="true">
                                        <option hidden value="" selected>Seleccionar estacion</option>
                                        @foreach ($allEsta as $esta)
                                            <option value="{{ $esta->id }}">{{ $esta->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="estacion"></x-input-error>
                                </div>
                            @elseif (Auth::user()->permiso_id == 2)
                                <div class="mb-3 mr-2 ">
                                    <x-label value="{{ __('Estación') }}" />
                                    <select id="estacion" wire:model="estacion"
                                        class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                        name="estacion" required aria-required="true">
                                        <option hidden value="" selected>Seleccionar estacion</option>
                                        @foreach ($superEsta as $esta)
                                            <option value="{{ $esta->id }}">{{ $esta->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="estacion"></x-input-error>
                                </div>
                            @endif

							@if ($mostrar)
                                <div class="mb-1 col-12 w-full"
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                
                                    <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2"/>
                                    <input type="file" wire:model="evidencias" class=" pb-2 flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                                    multiple name="evidencias" required autocomplete="evidencias" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                    <x-input-error for="evidencias"></x-input-error>
                    
                                    <!-- Progress Bar -->
                                    <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
                                        <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"  x-bind:style="`width:${progress}%`"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="mb-3 mr-2 ">
                                <a type="button"
                                    class="tooltip cursor-pointer inline-flex items-center px-2 py-2 bg-green-400 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                                    wire:click.prevent="add({{ $i }})">
                                    <span class="d-inline-block" tabindex="0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span class="tooltiptext">Nuevo</span>
                                </a>
                            </div>

                            @foreach ($inputs as $key => $item)
                                <div class="w-full flex flex-wrap gap-2 border-t border-b py-2">
                                    <div class="mb-3 mr-2 ">
                                        <x-label value="{{ __('Producto' . ' ' . $item) }}" />
                                        <select id="producto.{{ $item }}"
                                            wire:model="producto.{{ $item }}"
                                            class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm "
                                            name="producto.{{ $item }}" required aria-required="true">
                                            <option hidden value="" selected>Seleccionar producto</option>
                                            @if ($productos)
                                                @foreach ($productos as $producto)
                                                    <option value="{{ $producto->id }}">{{ $producto->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <x-input-error for="producto.{{ $item }}"></x-input-error>
                                    </div>
									 @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                                    <div class="mb-3 ">
                                        <x-label value="{{ __('Proveedor') }}" />
                                        <select id="producto" wire:model="proveedor.{{ $item }}"
                                            class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto.1') ? 'is-invalid' : '' }}"
                                            name="proveedor.{{ $item }}" required aria-required="true">
                                            <option hidden value="" selected>Seleccionar proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">
                                                    {{ $proveedor->titulo_proveedor }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="proveedor.{{ $item }}"></x-input-error>
                                    </div>
									@endif
                                    <div class="mb-3 mr-2 ">
                                        <x-label value="{{ __('Cantidad') }}" />
                                        <x-input wire:model="cantidad.{{ $item }}"
                                            class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm "
                                            type="text" name="cantidad.{{ $item }}" :value="old('cantidad')"
                                            required autofocus autocomplete="cantidad"
                                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                        <x-input-error for="cantidad.{{ $item }}"></x-input-error>
                                    </div>
                                    <div class="mb-3 col-2">
                                        <button type="button"
                                            class="tooltip inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"
                                            wire:click.prevent="remove({{ $key }}, {{ $item }})">
                                            <span class="d-inline-block" tabindex="0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </span>
                                            <span class="tooltiptext">Eliminar</span>
                                        </button>
                                    </div>
									<div class="mb-3 mr-2 ">
                                        <a type="button"
                                            class="tooltip cursor-pointer inline-flex items-center px-2 py-2 bg-green-400 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                                            wire:click.prevent="add({{ $i }},{{ $item }})">
                                            <span class="d-inline-block" tabindex="0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                            <span class="tooltiptext">Nuevo</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mb-3 mr-2 ">
                                <x-label value="{{ __('Motivo de la solicitud') }}" />
                                <x-input wire:model="motivo"
                                    class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                                    type="text" name="motivo" :value="old('motivo')" required autofocus
                                    autocomplete="motivo" id="motivo" />
                                <x-input-error for="motivo"></x-input-error>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        @if (Auth::user()->permiso_id == 3)
                            <button
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                                wire:click="nextStep"
                                {{ !is_null($producto) && !empty($producto) && !is_null($cantidad) && !empty($cantidad) && !is_null($motivo) && !empty($motivo) ? '' : 'disabled' }}>
                                {{ __('Siguiente') }}
                            </button>
                        @elseif (Auth::user()->permiso_id != 3)
                            <button
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest  focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                                wire:click="nextStep"
                                {{ !is_null($producto) && !empty($producto) && !is_null($cantidad) && !empty($cantidad) && !is_null($estacion) && !empty($estacion) && !is_null($motivo) && !empty($motivo) ? '' : 'disabled' }}>
                                {{ __('Siguiente') }}
                            </button>
                        @endif
                        <button
                            class="inline-flex float-right items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border  border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                            wire:click="previousStep">
                            Anterior
                        </button>
                    </div>
                </div>
                <div wire:key="step3" class="{{ $currentStep == 3 ? 'block' : 'hidden' }} max-h-[320px] overflow-y-auto">
                    <span
                        class="bg-purple-100 text-purple-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">{{ __('Revisión de la Solicitud') }}</span>
                    <span class="text-red-500 text-xs font-medium"> 
                        {{ __('* Favor de revisar su solicitud antes de enviarla *') }}
                    </span>
                    <div class="mt-2 p-4 ">
                        <div class="grid grid-cols-2">
                            @if (!empty($this->producto))
                                @foreach ($this->producto as $key => $item)
                                    @foreach ($productos as $ite)
                                        @if ($this->producto[$key] == $ite->id)
                                            <div
                                                class="mr-2 bg-gray-300 rounded-md p-2 text-center mb-2 max-h-[320px] overflow-y-auto">
                                                <span class="inline-block" tabindex="0">
                                                    @if ($ite->product_photo_path == null)
                                                        <p align="center"><img name="photo" class="rounded-full"
                                                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                                style="height: 4rem;" /></p>
                                                    @else
                                                        <img name="photo" class="rounded-full"
                                                            src="{{ asset('storage/' . $ite->product_photo_path) }}"
                                                            style="height: 4rem;" />
                                                    @endif
                                                    <p class="text-center text-xs font-bold text-gray-700">
                                                        {{ $ite->name }}</p>
                                                    @if (!empty($this->cantidad[$key]))
                                                        <span
                                                            class="text-center bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">
                                                            Solicitando: {{ $this->cantidad[$key] }}
                                                        </span>
                                                    @endif
                                                </span> <br>
                                                @if ($key != 1)
                                                    <!-- Si existe más de 1 producto, se muestra la opción -->
                                                    <button type="button"
                                                        class="text-center @if ($key == 1) {{ 'disabled' }} @endif"
                                                        wire:click="rem({{ $key }})">
                                                        <span
                                                            class="text-center bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Eliminar</span>
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-button wire:click="previousStep">
                                Anterior
                            </x-button>
                        </div>
                        <div>
                            <x-danger-button class="float-right" wire:click="addSolicitud"
                                wire:loading.attr="disabled">
                                <div wire:loading wire:target="addSolicitud" class="spinner-border spinner-border-sm"
                                    role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                Aceptar
                            </x-danger-button>
                        </div>
                    </div>
                </div>
            @else
                <!-- Compras Extraordinarias -->
                <div wire:key="step2" class="{{ $currentStep == 2 ? 'block' : 'hidden' }} max-h-[320px] overflow-y-auto">
                    <span
                        class="bg-green-100 text-green-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ __('Solicitar Producto/Servicio') }}</span>
                    <div class="mt-2 p-4 ">
                        <div class="flex flex-wrap">
                            <div class="mb-3 mr-2 ">
                                <x-label value="{{ __('Categoría') }}" />
                                <select id="categoria" wire:model="categoria"
                                    class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('categoria') ? 'is-invalid' : '' }}"
                                    name="categoria" required aria-required="true">
                                    <option hidden value="" selected>Seleccionar Categoría</option>
                                    @foreach ($categoriasExt as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="categoria"></x-input-error>
                            </div>
                            @if ($productos)
                                <div class="mb-3 ">
                                    <x-label value="{{ __('Tipo de Pedido') }}" />
                                    <select wire:model="tipo" name="tipo" id="tipo"
                                        class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        <option hidden value="" selected>Seleccionar Opción</option>
                                        <option value="Producto">Producto</option>
                                        <option value="Servicio">Servicio</option>
                                    </select>
                                    <x-input-error for="tipo"></x-input-error>
                                </div>

                                <div class="mb-3 ml-3">
                                    <x-label value="{{ __('Producto/Servicio') }}" />
                                    <x-input id="producto" wire:model="producto_extraordinario.1" type="text"
                                        class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto_extraordinario.1') ? 'is-invalid' : '' }}"
                                        name="producto_extraordinario.1" required aria-required="true" />
                                    <x-input-error for="producto.1"></x-input-error>
                                </div>
								 @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                                <div class="mb-3 mr-2">
                                    <x-label value="{{ __('Proveedor') }}" />
                                    <select id="proveedor_ext" wire:model="proveedor_ext.1"
                                        class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto_ext') ? 'is-invalid' : '' }}"
                                        name="proveedor_ext" required aria-required="true">
                                        <option hidden value="" selected>Seleccionar proveedor</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">{{ $proveedor->titulo_proveedor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="proveedor_ext.1"></x-input-error>
                                </div>
							@endif
                            @endif

                            @if (Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 2)
                                <div class="mb-3 mr-2 ">
                                    <x-label value="{{ __('Precio') }}" />
                                    <x-input wire:model="total.1"
                                        class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('total.1') ? 'is-invalid' : '' }}"
                                        type="text" name="total.1" :value="old('total')" required autofocus
                                        autocomplete="total.1" id="total"
                                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                    <x-input-error for="total.1"></x-input-error>
                                </div>
                            @endif

                            <div class="mb-3 ml-2 ">
                                <x-label value="{{ __('Cantidad') }}" />
                                <x-input wire:model="cantidad.1"
                                    class="w-1/2 border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('cantidad.1') ? 'is-invalid' : '' }}"
                                    type="text" name="cantidad.1" :value="old('cantidad')" required autofocus
                                    autocomplete="cantidad.1" id="cantidad"
                                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                <x-input-error for="cantidad.1"></x-input-error>
                            </div>

                            @if (Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 2)
                                <div class="mb-3 mr-2 ">
                                    <x-label value="{{ __('Estación') }}" />
                                    <select id="estacion" wire:model="estacion"
                                        class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                        name="estacion" required aria-required="true">
                                        <option hidden value="" selected>Seleccionar estacion</option>
                                        @foreach ($allEsta as $esta)
                                            <option value="{{ $esta->id }}">{{ $esta->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="estacion"></x-input-error>
                                </div>
                            @elseif (Auth::user()->permiso_id == 2)
                                <div class="mb-3 mr-2 ">
                                    <x-label value="{{ __('Estación') }}" />
                                    <select id="estacion" wire:model="estacion"
                                        class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                        name="estacion" required aria-required="true">
                                        <option hidden value="" selected>Seleccionar estacion</option>
                                        @foreach ($superEsta as $esta)
                                            <option value="{{ $esta->id }}">{{ $esta->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="estacion"></x-input-error>
                                </div>
                            @endif

                            <div class="mb-3 mr-2 ">
                                <a type="button"
                                    class="tooltip cursor-pointer inline-flex items-center px-2 py-2 bg-green-400 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                                    wire:click.prevent="add({{ $i }})">
                                    <span class="d-inline-block" tabindex="0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span class="tooltiptext">Nuevo</span>
                                </a>
                            </div>

                            @foreach ($inputs as $key => $item)
                                <div class="w-full flex flex-wrap gap-2 border-t border-b py-2">
                                    <div class="mb-3 ">
                                        <x-label value="{{ __('Tipo de Pedido' . ' ' . $item) }}" />
                                        <select wire.model="tipo.{{ $item }}"
                                            name="tipo.{{ $item }}" id="tipo.{{ $item }}"
                                            class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                            <option hidden value="" selected>Seleccionar Opción</option>
                                            <option value="Producto">Producto</option>
                                            <option value="Servicio">Servicio</option>
                                        </select>
                                        <x-input-error for="tipo.{{ $item }}"></x-input-error>
                                    </div>
                                    <div class="mb-3 mr-2 ">
                                        <x-label value="{{ __('Producto/Servicio' . ' ' . $item) }}" />
                                        <x-input id="producto_extraordinario.{{ $item }}"
                                            wire:model="producto_extraordinario.{{ $item }}" type="text"
                                            class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto_extraordinario.1') ? 'is-invalid' : '' }}"
                                            name="producto_extraordinario.{{ $item }}" required
                                            aria-required="true" />
                                        <x-input-error for="producto_extraordinario.{{ $item }}">
                                        </x-input-error>
                                    </div>
									 @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                                    <div class="mb-3 mr-2">
                                        <x-label value="{{ __('Proveedor') }}" />
                                        <select id="proveedor_ext.{{ $item }}"
                                            wire:model="proveedor_ext.{{ $item }}"
                                            class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto_ext.1') ? 'is-invalid' : '' }}"
                                            name="proveedor_ext.{{ $item }}" required aria-required="true">
                                            <option hidden value="" selected>Seleccionar proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">
                                                    {{ $proveedor->titulo_proveedor }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="proveedor_ext.{{ $item }}"></x-input-error>
                                    </div>
									@endif
                                    <div class="mb-3 mr-2 ">
                                        <x-label value="{{ __('Cantidad') }}" />
                                        <x-input wire:model="cantidad.{{ $item }}"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                            type="text" name="cantidad.{{ $item }}" :value="old('cantidad')"
                                            required autofocus autocomplete="cantidad"
                                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                        <x-input-error for="cantidad.{{ $item }}"></x-input-error>
                                    </div>
                                    @if (Auth::user()->permiso_id != 3 && Auth::user()->permiso_id != 2)
                                        <div class="mb-3 mr-2 ">
                                            <x-label value="{{ __('Precio') }}" />
                                            <x-input wire:model="total.{{ $item }}"
                                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                type="text" name="total.{{ $item }}" :value="old('total')"
                                                required autofocus autocomplete="total"
                                                id="total.{{ $item }}"
                                                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                                            <x-input-error for="total.{{ $item }}"></x-input-error>
                                        </div>
                                    @endif
                                    <div class="mb-3 col-2">
                                        <button type="button"
                                            class="tooltip inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"
                                            wire:click.prevent="remove({{ $key }}, {{ $item }})">
                                            <span class="d-inline-block" tabindex="0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </span>
                                            <span class="tooltiptext">Eliminar</span>
                                        </button>
                                    </div>
									<div class="mb-3 mr-2 ">
                                <a type="button"
                                    class="tooltip cursor-pointer inline-flex items-center px-2 py-2 bg-green-400 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                                    wire:click.prevent="add({{ $i }},{{ $item }})">
                                    <span class="d-inline-block" tabindex="0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span class="tooltiptext">Nuevo</span>
                                </a>
                            </div>
                                </div>
                            @endforeach

                            <div class="mb-3 mr-2 ">
                                <x-label value="{{ __('Motivo de la solicitud') }}" />
                                <x-input wire:model="motivo"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                                    type="text" name="motivo" :value="old('motivo')" required autofocus
                                    autocomplete="motivo" id="motivo" />
                                <x-input-error for="motivo"></x-input-error>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                        <button
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-dark-eval-3 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                            wire:click="previousStep">
                            {{ __('Anterior') }}
                        </button>

                        @if (Auth::user()->permiso_id == 3)
                            <button class="float-right p-2 bg-red-600 rounded-md dark:bg-dark-eval-3 text-white" wire:click="addSolicitudExt"
                                {{ !is_null($producto_extraordinario) && !empty($producto_extraordinario) && !is_null($cantidad) && !empty($cantidad) && !is_null($motivo) && !empty($motivo) ? '' : 'disabled' }}>
                                Aceptar
                            </button>
                        @elseif (Auth::user()->permiso_id != 3)
                            <button class="float-right p-2 bg-red-600 rounded-md dark:bg-dark-eval-3 text-white" wire:click="addSolicitudExt"
                                {{ !is_null($producto_extraordinario) && !empty($producto_extraordinario) && !is_null($cantidad) && !empty($cantidad) && !is_null($estacion) && !empty($estacion) && !is_null($motivo) && !empty($motivo) ? '' : 'disabled' }}>
                                Aceptar
                            </button>
                        @endif

                    </div>
                </div>

            @endif


        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$set('create',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
