<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button class="float-right" wire:click="showModalFormProducto" class="">
            <i class="fa-solid fa-plus"></i>
            {{ __('Nuevo Producto') }}
        </x-button>
    </div>

    <x-dialog-modal wire:model="newgProducto" id="modalProducto" class="flex items-center">
        <x-slot name="title">
            {{ __('Nuevo Producto') }}
        </x-slot>

        <x-slot name="content">
            <div class="shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Nombre del Producto') }}" />
                        <x-input wire:model.defer="name"
                            class="uppercase border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                            name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <div class="mb-3 col-6" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-label value="{{ __('Imagen') }}" />

                            <form>
                                <label class="block">
                                    <span class="sr-only">Elegir Archivo</span>
                                    <input wire:model.defer="imagen" type="file"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                </label>
                            </form>

                            <!-- Progress Bar -->
                            <div wire:loading wire:target="imagen"></div>
                            <div class="progress" x-show="isUploading" id="archivo">
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


                            @error('imagen')
                                <span class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="w-full px-3" wire:ignore>
                        <x-label value="{{ __('Zona') }}" />
                        <select id="select2" name="zonaspList[ ]"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            multiple="multiple">
                            @foreach ($zonasp as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="zonasp"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Categoria') }}" />
                        <select id="categoria" wire:model.defer="categoria"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('categoria') ? 'is-invalid' : '' }}"
                            name="categoria" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Categoria</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="categoria"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Unidad') }}" />
                          @if ($showUnidad)            
                            <x-input wire:model="unidad" class="{{ $errors->has('unidad') ? 'is-invalid' : '' }}"
                                type="text" name="unidad" :value="old('unidad')" required autofocus autocomplete="unidad"
                                placeholder="Pieza, Paquete, Cubeta, Litro, Kilo" />
                        @else
                            <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" name="" id="" wire:model="unidad">
                                <option value="" selected>Seleccionar Unidad</option>
                                @foreach ($unidadList as $unidad)
                                    <option value="{{$unidad}}">{{$unidad}}</option>
                                @endforeach
                            </select>
                        @endif
                        <x-input-error for="unidad"></x-input-error> 
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    {{--<div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Precio') }}" />
                        <x-input wire:model.defer="precio" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('precio') ? 'is-invalid' : '' }}"
                            type="text" name="precio" :value="old('precio')" required autofocus autocomplete="precio"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="precio"></x-input-error>
                    </div>--}}
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Stock') }}" />
                        <x-input wire:model.defer="stock" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('stock') ? 'is-invalid' : '' }}"
                            type="text" name="stock" :value="old('stock')" required autofocus autocomplete="stock"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="stock"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addProducto" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgProducto')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    <script>
        $('#select2').select2({
            placeholder: "Seleccionar zona(s)..."
        }).on('change', function(){
            @this.set('zonaspList', $(this).val());
        });
    </script>
</div>