<div class="col-md-4 col-sm-6 col-6 d-flex justify-content-end justify-content-md-end justify-content-sm-end">
    <div class="">
        <x-button class="btn-sm" wire:click="showModalFormAlmacen">
            <i class="fa-solid fa-plus"></i>
            {{ __('Entradas Y Salidas') }}
        </x-button>
    </div>

    <x-dialog-modal wire:model="newgAlmacen" id="modalAlmacen" class="flex items-center">
        <x-slot name="title">
            {{ __('Solicitar Entrada o Salida de Productos') }}
        </x-slot>

        <x-slot name="content">
			<div class="max-h-[320px] overflow-y-auto">
            <div class="flex flex-wrap gap-2">
                <div class="mb-3 mr-2 ">
                    <x-label class="mb-3" value="{{ __('Salida o Entrada') }}" />
                    <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                        <input
                            class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary dark:checked:border-primary checked:bg-primary dark:checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent{{ $errors->has('isEntraoSali') ? 'is-invalid' : '' }}"
                            type="radio" wire:model="isEntraoSali" id="isEntraoSali" value="Entrada" required>
                        <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="isEntraoSali">
                            {{ __('Entrada') }}
                        </label>
                    </div>
                    <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                        <input
                            class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary dark:checked:border-primary checked:bg-primary dark:checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent{{ $errors->has('isEntraoSali') ? 'is-invalid' : '' }}"
                            type="radio" wire:model="isEntraoSali" id="isEntraoSali2" value="Salida" required>
                        <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="isEntraoSali2">
                            {{ __('Salida') }}
                        </label>
                    </div>
                    <x-input-error for="isEntraoSali"></x-input-error>
                </div>
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
                        <x-input-error for="producto.1"></x-input-error>
                    </div>
                    <div>
                        <x-label value="{{ __('Producto') }}" />
                        <select id="producto" wire:model="producto.1"
                            class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('producto.1') ? 'is-invalid' : '' }}"
                            name="producto.1" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Producto</option>
                            @if (isset($productos))
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error for="producto.1"></x-input-error>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <x-label value="{{ __('Cantidad') }}" />

                        <x-input wire:model="stock.1"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('stock.1') ? 'is-invalid' : '' }}"
                            type="text" name="stock.1" :value="old('stock')" required autofocus autocomplete="stock.1"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="stock.1"></x-input-error>
                    </div>
                </div>
                <div class="mb-3 mr-2">
                    <x-label value="{{ __('Motivo') }}" />
                    <x-input wire:model="motivo"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                        type="text" name="motivo" :value="old('motivo')" required autofocus autocomplete="motivo" />
                    <x-input-error for="motivo"></x-input-error>
                </div>
                @if (Auth::user()->permiso_id == 2)
                    <div class="col-12">
                        <div class="p-0 col-12">
                            <x-label value="{{ __('Para:') }}" />
                            <div class="form-check form-check-inline">
                                <input class="form-check-input {{ $errors->has('isEstaSuper') ? 'is-invalid' : '' }}"
                                    type="radio" wire:model="isEstaSuper" id="isEstaSuper" value="Estacion" required>
                                <label class="form-check-label" for="isEstaSuper">
                                    {{ __('Estación') }}
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input {{ $errors->has('isEstaSuper') ? 'is-invalid' : '' }}"
                                    type="radio" wire:model="isEstaSuper" id="isEstaSuper2" value="Mi Almacen"
                                    required>
                                <label class="form-check-label" for="isEstaSuper2">
                                    {{ __('Mi Almacen') }}
                                </label>
                            </div>
                            <x-input-error for="isEstaSuper"></x-input-error>
                        </div>
                    </div>

                    @if ($allSuperStation != null)
                        <div class="mb-3 col-12">
                            <div class="p-0 col-12">
                                <x-label value="{{ __('Estación') }}" />

                                <select id="estacion" wire:model="estacion"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sml {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                    name="estacion" required aria-required="true">
                                    <option hidden value="" selected>Seleccionar Estacion</option>
                                    @foreach ($allSuperStation as $stat)
                                        <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="estacion"></x-input-error>
                            </div>
                        </div>
                    @endif
                @elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
                    <div class="mb-3 mr-2">

                        <x-label value="{{ __('Para:') }}" />

                        <div class="form-check form-check-inline">
                            <input class="form-check-input {{ $errors->has('isEstaSuper') ? 'is-invalid' : '' }}"
                                type="radio" wire:model="isEstaSuper" id="isEstaSuper" value="Estacion" required>
                            <label class="form-check-label" for="isEstaSuper">
                                {{ __('Estación') }}
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input {{ $errors->has('isEstaSuper') ? 'is-invalid' : '' }}"
                                type="radio" wire:model="isEstaSuper" id="isEstaSuper2" value="SuperviAlma"
                                required>
                            <label class="form-check-label" for="isEstaSuper2">
                                {{ __('Almacén de Supervisor') }}
                            </label>
                        </div>
                        <x-input-error for="isEstaSuper"></x-input-error>

                    </div>

                    @if ($allSuperStation != null)
                        <div class="mb-3 col-12">
                            <div class="p-0 col-12">
                                <x-label value="{{ __('Estación') }}" />

                                <select id="estacion" wire:model="estacion"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('estacion') ? 'is-invalid' : '' }}"
                                    name="estacion" required aria-required="true">
                                    <option hidden value="" selected>Seleccionar Estacion</option>
                                    @foreach ($allSuperStation as $stat)
                                        <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="estacion"></x-input-error>
                            </div>
                        </div>
                    @endif

                    @if ($superAlma != null)
                        <div class="mb-3 mr-2">
                            <x-label value="{{ __('Supervisor') }}" />
                            <select id="supervisor" wire:model="supervisor"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('supervisor') ? 'is-invalid' : '' }}"
                                name="supervisor" required aria-required="true">
                                <option hidden value="" selected>Seleccionar Supervisor</option>
                                @foreach ($superAlma as $super)
                                    <option value="{{ $super->id }}">{{ $super->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="supervisor"></x-input-error>
                        </div>
                    @endif
                @endif
            </div>
            <div class="grid grid-cols-2 max-[600px]:grid-cols-1">
                <div class="mb-3 col-sm-6">
                    <x-label value="{{ __('Observaciones') }}" />
                    <textarea wire:model="observacion.1"
                        class="w-full resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm{{ $errors->has('observacion.1') ? 'is-invalid' : '' }} "
                        name="observacion.1" required autofocus autocomplete="observacion.1"></textarea>
                    <x-input-error for="observacion.1"></x-input-error>
                </div>
                <div class="mb-3 col-6" x-data="{ isRemision: false, progress: 0 }" x-on:livewire-upload-start="isRemision = true"
                    x-on:livewire-upload-finish="isRemision = false" x-on:livewire-upload-error="isRemision = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <x-label value="{{ __('Nota de remisión') }}" />

                    <form>
                        <label class="block">
                            <span class="sr-only">Elegir Archivo</span>
                            <input wire:model.defer="remision.1" type="file" accept=".pdf"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 {{ $errors->has('remision.1') ? 'is-invalid' : '' }}"
                                name="remision.1" required />
                        </label>
                    </form>

                    <!-- Progress Bar -->
                    <div wire:loading wire:target="remision.1"></div>
                    <div class="progress" x-show="isRemision" id="archivoRemis">
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
                </div>

                @if ($viewCondi != null)
                    <div class="mb-3 col-6" x-data="{ isCondiEquip: false, progress: 0 }"
                        x-on:livewire-upload-start="isCondiEquip = true"x-on:livewire-upload-finish="isCondiEquip = false"
                        x-on:livewire-upload-error="isCondiEquip = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <x-label value="{{ __('Condiciones del equipo') }}" />
                        <form>
                            <label class="block">
                                <span class="sr-only">Elegir Archivo</span>
                                <input wire:model.defer="condiEquipo.1" type="file" accept=".pdf"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100{{ $errors->has('condiEquipo.1') ? 'is-invalid' : '' }}"
                                    name="condiEquipo.1" required />
                            </label>
                        </form>
                        <!-- Progress Bar -->
                        <div wire:loading wire:target="condiEquipo.1"></div>
                        <div class="progress" x-show="isCondiEquip" id="archivoCondiEquip">
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
                    </div>
                    <x-input-error for="condiEquipo.*"></x-input-error>
                @endif
            </div>


            @foreach ($inputs as $key => $item)
                <div class="col-12 p-1">
                    <hr>
                </div>
                <div class="grid grid-cols-2 max-[440px]:grid-cols-1">
                    <div class="mb-3 col-5">
                        <x-label value="{{ __('Producto' . ' ' . $item) }}" />

                        <select id="producto.{{ $item }}" wire:model.defer="producto.{{ $item }}"
                            class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto.*') ? 'is-invalid' : '' }}"
                            name="producto.{{ $item }}" required aria-required="true">
                            <option hidden value="" selected>Seleccionar producto</option>
                            @foreach ($productos as $producto)
                                @if ($producto->flag_trash == 0)
                                    <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error for="producto.*"></x-input-error>
                    </div>

                    <div class="mb-3">
                        <div>
                            <x-label value="{{ __('Cantidad') }}" />

                            <x-input wire:model="stock.{{ $item }}"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('stock.*') ? 'is-invalid' : '' }}"
                                type="text" name="stock.{{ $item }}" :value="old('stock')" required autofocus
                                autocomplete="stock.1"
                                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                            <x-input-error for="stock.*"></x-input-error>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 max-[600px]:grid-cols-1">
                    <div class="mb-3">
                        <x-label value="{{ __('Observaciones') }}" />
                        <textarea wire:model="observacion.{{ $item }}"
                            class="w-full resize-none border-gray-300 rounded-md {{ $errors->has('observacion.*') ? 'is-invalid' : '' }}"
                            name="observacion.{{ $item }}" required autofocus autocomplete="observacion.{{ $item }}"></textarea>

                        <x-input-error for="observacion.*"></x-input-error>
                    </div>
                    <div class="mb-3 col-6" x-data="{ isRemi1: false, progress: 0 }" x-on:livewire-upload-start="isRemi1 = true"
                        x-on:livewire-upload-finish="isRemi1 = false" x-on:livewire-upload-error="isRemi1 = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <x-label value="{{ __('Nota de remisión') }}" />

                        <form>
                            <label class="block">
                                <span class="sr-only">Elegir Archivo</span>
                                <input wire:model.defer="remision.{{ $item }}" type="file" accept=".pdf"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 {{ $errors->has('remision.*') ? 'is-invalid' : '' }}"
                                    name="remision.{{ $item }}" required />
                            </label>
                        </form>

                        <!-- Progress Bar -->
                        <div wire:loading wire:target="remision.*"></div>
                        <div class="progress" x-show="isRemi1" id="archivoRemis">
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
                        <x-input-error for="remision.*"></x-input-error>
                        @if ($viewCondi != null)
                            <div class="mb-3 col-6" x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <x-label value="{{ __('Condiciones del equipo') }}" />
                                <form>
                                    <label class="block">
                                        <span class="sr-only">Elegir Archivo</span>
                                        <input wire:model.defer="condiEquipo.{{ $item }}" type="file"
                                            accept=".pdf"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100{{ $errors->has('condiEquipo.*') ? 'is-invalid' : '' }}"
                                            name="condiEquipo.{{ $item }}" required />
                                    </label>
                                </form>
                                <!-- Progress Bar -->
                                <div wire:loading wire:target="condiEquipo.*"></div>
                                <div class="progress" x-show="isUploading" id="archivoCondiEquip">
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
                            </div>
                            <x-input-error for="condiEquipo.*"></x-input-error>
                        @endif
                    </div>
                    <div class="inline mb-2">
                        <a type="button"
                            class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full cursor-pointer dark:bg-red-900 dark:text-red-300"
                            wire:click.prevent="remove({{ $key }}, {{ $item }})"
                            title="Eliminar Producto">
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-content="Eliminar Producto"
                                data-bs-placement="top">
                                Eliminar
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="inline">
                <a type="button"
                    class="bg-blue-200 text-blue-800 text-xs font-medium mr-2 px-2.5 py-1 rounded-full cursor-pointer dark:bg-blue-900 dark:text-blue-300"
                    wire:click.prevent="add({{ $i }})" title="Nuevo">
                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                        data-bs-trigger="hover focus" data-bs-content="Agregar Nuevo Producto"
                        data-bs-placement="top">
                        Añadir
                    </span>
                </a>
            </div>
            <div class="col-12">
                <hr>
            </div>
			</div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addAlmacen" wire:loading.attr="disabled">
                <div wire:loading wire:target="addAlmacen" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                {{ __('Aceptar') }}
            </x-danger-button>
            <x-secondary-button wire:click="$toggle('newgAlmacen')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
