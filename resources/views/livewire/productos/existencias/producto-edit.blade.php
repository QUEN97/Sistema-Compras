<div>

    <button wire:click="confirmProductoEdit({{ $producto_id }})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>

    <x-dialog-modal wire:model="EditProducto" id="EditProducto{{ $producto_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Editar Producto') }}
        </x-slot>

        <x-slot name="content">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Nombre del Producto') }}" />
                        <x-input wire:model.defer="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Imagen Actual') }}" />
                        @if ($this->photo == null)
                            <img wire:model="photo" class="rounded-full object-cover" style="width: 65px" name="photo"
                                src="{{ asset('storage/product-photos/imagedefault.jpg') }}" />
                        @else
                            <img wire:model="photo" class="rounded-full object-cover" style="width: 65px" name="photo"
                                src="{{ asset('storage/' . $this->photo) }}" />
                        @endif

                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Nueva Imagen') }}" />
                        @if ($imagen)
                            <img class="rounded-full object-cover" style="width: 65px"
                                src="{{ $imagen->temporaryUrl() }}">
                        @endif
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
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
                    <div class="my-3 pt-2 flex justify-center items-center flex-col">
                        <x-label value="{{ __('Zona') }}" />
                        <div class="max-h-[100px] min-w-[120px] overflow-y-auto">
                        @foreach ($zonass as $tag)
                            <div class="flex items-start flex-wrap gap-2 max-h-28 overflow-x-auto px-2 mt-2">
                                <div class="flex flex-wrap items-center gap-0.5">
                                    <input type="checkbox" wire:model="productosUpdate" value="{{ $tag->id }}"
                                        name="names[]" id="{{ $tag->name }}{{$EditProducto}}" class="hidden peer">
                                    <label for="{{ $tag->name }}{{$EditProducto}}"
                                        class="break-all text-start w-full border py-1 px-1 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white">{{ $tag->name }}</label>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <x-input-error for="zona"></x-input-error>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Categoria') }}" />
                        <select id="categoria" wire:model.defer="categoria"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('categoria') ? 'is-invalid' : '' }}"
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
                        <x-input wire:model.defer="unidad" class="{{ $errors->has('unidad') ? 'is-invalid' : '' }}"
                            type="text" name="unidad" :value="old('unidad')" required autofocus autocomplete="unidad"
                            placeholder="Pieza, Paquete, Cubeta, Litro, Kilo" />
                        <x-input-error for="unidad"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Precio') }}" />
                        <x-input wire:model.defer="precio" class="{{ $errors->has('precio') ? 'is-invalid' : '' }}"
                            type="text" name="precio" :value="old('precio')" required autofocus autocomplete="precio"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="precio"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Stock') }}" />
                        <x-input wire:model.defer="stock" class="{{ $errors->has('stock') ? 'is-invalid' : '' }}"
                            type="text" name="stock" :value="old('stock')" required autofocus autocomplete="stock"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="stock"></x-input-error>
                    </div>
                </div>
                <div class="md:w-1/2 px-3">
                    <x-label value="{{ __('Status') }}" />
                    <select id="status" wire:model="status"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('status') ? 'is-invalid' : '' }}"
                        name="status" required aria-required="true">
                        <option hidden value="">Seleccionar Status</option>
                        <option value="Activo" @if ($status == 'Activo') {{ 'selected' }} @endif>
                            Activo</option>
                        <option value="Inactivo" @if ($status == 'Inactivo') {{ 'selected' }} @endif>
                            Inactivo</option>
                    </select>
                    <x-input-error for="status"></x-input-error>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="EditarProducto({{ $producto_id }})"
                wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('EditProducto')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
