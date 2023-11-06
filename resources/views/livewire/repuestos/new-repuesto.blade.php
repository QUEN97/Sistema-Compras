<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button wire:click="showModalFormRepuesto">
            <i class="fa-solid fa-plus"></i>
            {{ __('Solicitar Repuesto') }}
            </x-jet-button>
    </div>

    <x-dialog-modal wire:model="newgRepuesto" id="modalRepuesto" class="flex items-center">
        <x-slot name="title">
            {{ __('Solicitar Repuesto') }}
        </x-slot>

        <x-slot name="content">
                <div class="flex flex-wrap gap-2">
                    {{-- <div class="mb-3 ">
                        <x-label value="{{ __('Producto') }}" />
    
                        <select id="producto" wire:model="producto"
                            class=" mr-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto') ? 'is-invalid' : '' }}"
                            name="producto" required aria-required="true">
                            <option hidden value="" selected>Seleccionar producto</option>
                            @foreach ($productos as $producto)
                                @if ($producto->flag_trash == 0)
                                    <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error for="producto"></x-input-error>
                    </div> --}}
                    <div class="mb-3 mr-2 flex flex-wrap gap-2">
                        <div>
                            <x-label value="{{ __('Categoría') }}" />
                            <select id="producto" wire:model="categoria"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('producto.1') ? 'is-invalid' : '' }}"
                                name="producto.1" required aria-required="true">
                                <option hidden value="" selected>Seleccionar Categoría</option>
                                @if (isset($categorias))    
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <x-input-error for="categoria"></x-input-error>
                        </div>
                        <div>
                            <x-label value="{{ __('Producto') }}" />
                            <select id="producto" wire:model="producto" 
                                class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('producto') ? 'is-invalid' : '' }}"
                                name="producto.1" required aria-required="true">
                                <option hidden value="" selected>Seleccionar Producto</option>
                                @if (isset($productos))
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <x-input-error for="producto"></x-input-error>
                        </div>
                    </div>
    
                    <div class="mb-3 ">
                        <x-label value="{{ __('Cantidad') }}" />
    
                        <x-input wire:model="cantidad"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                            type="text" name="cantidad" :value="old('cantidad')" required autofocus autocomplete="cantidad"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="cantidad"></x-input-error>
                    </div>
    
                    @if (Auth::user()->permiso_id == 2)
                        <div class="mb-3 col-6">
                            <x-label value="{{ __('Estacion') }}" />
    
                            <select id="estacion" wire:model="estacion"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                name="estacion" required aria-required="true">
                                <option hidden value="" selected>Seleccionar estacion</option>
                                @foreach ($estaciones as $estacion)
                                    @if ($estacion->flag_trash == 0)
                                        <option value="{{ $estacion->id }}">{{ $estacion->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <x-input-error for="estacion"></x-input-error>
                        </div>
                    @elseif (Auth::user()->permiso_id != 3)
                        <div class="mb-3 col-6">
                            <x-label value="{{ __('Estacion') }}" />
    
                            <select id="estacion" wire:model="estacion"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                name="estacion" required aria-required="true">
                                <option hidden value="" selected>Seleccionar estacion</option>
                                @foreach ($allEstaciones as $estacio)
                                    @if ($estacio->flag_trash == 0)
                                        <option value="{{ $estacio->id }}">{{ $estacio->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <x-input-error for="estacion"></x-input-error>
                        </div>
                    @endif
    
                    <div class="mb-3 col-12">
                        <x-label value="{{ __('Descripcion') }}" />
    
                        <textarea wire:model="descripcion"
                            class="resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('descripcion') ? 'is-invalid' : '' }} resize-none"
                            name="descripcion" required autofocus autocomplete="descripcion"></textarea>
    
                        <x-input-error for="descripcion"></x-input-error>
                    </div>
    
                    <div class="mb-3 col-6" x-data="{ isEvidencia: false, progress: 0 }" x-on:livewire-upload-start="isEvidencia = true"
                    x-on:livewire-upload-finish="isEvidencia = false" x-on:livewire-upload-error="isEvidencia = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <x-label value="{{ __('Evidencia') }}" />

                    <form>
                        <label class="block">
                            <span class="sr-only">Elegir Archivo</span>
                            <input wire:model="evidencias" type="file" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 {{ $errors->has('remision.1') ? 'is-invalid' : '' }}"
                                name="evidencias" required />
                        </label>
                    </form>

                    <x-input-error for="evidencias"></x-input-error>

                    <!-- Progress Bar -->
                    <div wire:loading wire:target="evidencias"></div>
                    <div class="progress" x-show="isEvidencia" id="archivoEvidencia">
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span
                                        class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200">
                                        Subiendo...
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-red-300">
                                        50%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-300">
                                <div style="width: 10%"
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                                </div>
                                <div style="width: 15%"
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-600">
                                </div>
                                <div style="width: 25%"
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-700">
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center mb-3">
                        <div class="row">
                            @if ($evidencias)
                                <x-label value="{{ __('Imagenes Seleccionadas') }}" />
                                @foreach ($evidencias as $item)
                                    <div class="col-3" wire:key="{{ $loop->index }}">
                                        @if (
                                            $item->getMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                                                $item->getMimeType() == 'application/msword')
                                            <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                            <p>{{ $item->getClientOriginalName() }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                </p>
                                            @endif
                                        @elseif ($item->getMimeType() == 'application/pdf')
                                            <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                            <p>{{ $item->getClientOriginalName() }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                </p>
                                            @endif
                                        @elseif (
                                            $item->getMimeType() == 'image/png' ||
                                                $item->getMimeType() == 'image/jpg' ||
                                                $item->getMimeType() == 'image/jpeg' ||
                                                $item->getMimeType() == 'image/webp')
                                            <img class="w-100" src="{{ $item->temporaryUrl() }}">
                                            <p>{{ $item->getClientOriginalName() }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                </p>
                                            @endif
                                        @else
                                            <img class="w-100" src="{{ asset('img/icons/file.png') }}">
                                            <p>{{ __('Archivo no Soportado') }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) == 8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                </p>
                                            @endif
                                        @endif
                                        <button type="button" class="btn btn-danger m-2"
                                            wire:click="removeMe({{ $loop->index }})">
                                            <i class="fa-solid fa-trash-can"></i>
                                            {{ __('Eliminar') }}
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addRepuesto" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgRepuesto')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
