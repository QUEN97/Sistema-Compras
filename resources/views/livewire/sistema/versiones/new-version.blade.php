<div>
    <x-button wire:click="showModalFormVersion">
        {{ __('Nueva Version') }}
    </x-button>

    <x-dialog-modal wire:model="newgVersion" id="modalVersion" class="flex items-center">
        <x-slot name="title">
            {{ __('Nueva Version del Sistema') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap gap-3">
                <div>
                    <x-label value="{{ __('Nombre de la Version') }}" />
                    <x-input wire:model="titulo_version"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('titulo_version') ? 'is-invalid' : '' }}"
                        type="text" name="titulo_version" :value="old('titulo_version')" required autofocus
                        autocomplete="titulo_version" />
                    <x-input-error for="titulo_version"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Versión') }}" />

                    <x-input wire:model="version"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('version') ? 'is-invalid' : '' }}"
                        type="text" name="version" :value="old('version')" required autofocus autocomplete="version" />
                    <x-input-error for="version"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Versión Liberada') }}" />
                    <select id="released" wire:model="released"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('released') ? 'is-invalid' : '' }}"
                        name="released" required aria-required="true">
                        <option hidden value="" selected>{{ __('Seleccionar Versión') }}</option>
                        <option value="Actual">{{ __('Actual') }}</option>
                        <option value="Minimo">{{ __('Minima') }}</option>
                    </select>
                    <x-input-error for="released"></x-input-error>
                </div>
                <div>
                    <div>
                        <x-label value="{{ __('Panel') }}" />

                        <select id="panel.1" wire:model="panel.1"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('panel.1') ? 'is-invalid' : '' }}"
                            name="panel.1" required aria-required="true">
                            <option hidden value="" selected>{{ __('Seleccionar Panel') }}</option>
                            @foreach ($panels as $panel)
                                <option value="{{ $panel->id }}">{{ $panel->titulo_panel }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="panel.1"></x-input-error>
                    </div>
                </div>
                <div class="w-full">
                    <a type="button"
                        class="bg-blue-800 text-blue-100 text-xs font-medium mr-2 px-2.5 py-1 rounded-full cursor-pointer "
                        wire:click.prevent="addPanel({{ $j }})" title="Nuevo">
                        <span class="inline-block" tabindex="0" data-bs-toggle="popover"
                            data-bs-trigger="hover focus" data-bs-content="Agregar Nuevo Producto"
                            data-bs-placement="top">
                            Añadir Otro Panel
                        </span>
                    </a>
                </div>
                <div class="mb-3 w-full">
                    <div class="mb-3">
                        <x-label value="{{ __('Categoria') }}" />
                        <select id="catego.1.1" wire:model="catego.1.1"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('catego.1.1') ? 'is-invalid' : '' }}"
                            name="catego.1.1" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Categoría</option>
                            <option value="Nuevo">{{ __('Nuevo') }}</option>
                            <option value="Debug">{{ __('Debug') }}</option>
                            <option value="Design">{{ __('Diseño') }}</option>
                        </select>
                        <x-input-error for="catego.1.1"></x-input-error>
                    </div>
                    <div>
                        <span>Descripcion</span>
                        <div class="inline">
                            <a type="button"
                                class="bg-blue-800 text-blue-100 text-xs font-medium mr-2 px-2.5 py-1 rounded-full cursor-pointer "
                                wire:click.prevent="add({{ $i }})" title="Nuevo">
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                    data-bs-trigger="hover focus" data-bs-content="Agregar Nuevo Producto"
                                    data-bs-placement="top">
                                    Añadir Otra Descripción
                                </span>
                            </a>
                        </div>
                        <textarea wire:model="descripcion.1.1"
                            class="resize-none w-full rounded-md mt-2 dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('descripcion.1.1') ? 'is-invalid' : '' }}" name="descripcion.1.1"
                            required autofocus autocomplete="descripcion.1.1"></textarea>
                        <x-input-error for="descripcion.1.1"></x-input-error>

                    </div>
                </div>
                @foreach ($inputs as $key => $item)
                <div class="w-full">
                    <div class="mb-3 col-5">
                        <x-label value="{{ __('Categoria') }}" />
                        <select id="catego.1.{{ $item }}" wire:model="catego.1.{{ $item }}"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('catego.1.*') ? 'is-invalid' : '' }}"
                            name="catego.1.{{ $item }}" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Categoría</option>
                            <option value="Nuevo">{{ __('Nuevo') }}</option>
                            <option value="Debug">{{ __('Debug') }}</option>
                            <option value="Design">{{ __('Design') }}</option>
                        </select>
                        <x-input-error for="catego.1.*"></x-input-error>
                    </div>
                    <div class="mb-2 w-full">
                        <div>
                            <span class="text-gray-500">Descripcion</span>
                            <div class="inline">
                                <button type="button"
                                    class="bg-red-100 text-red-500 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full cursor-pointer dark:bg-red-500 dark:text-red-300"
                                    wire:click.prevent="remove({{ $key }}, {{ $item }})"
                                    title="Eliminar Producto">
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-content="Eliminar Producto"
                                        data-bs-placement="top">
                                        Eliminar
                                    </span>
                                </button>
                            </div>
                            <textarea wire:model="descripcion.1.{{ $item }}"
                                class="resize-none w-full rounded-md dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('descripcion.1.*') ? 'is-invalid' : '' }}"
                                name="descripcion.1.{{ $item }}" required autofocus autocomplete="descripcion.1.{{ $item }}"></textarea>

                            <x-input-error for="descripcion.1.*"></x-input-error>

                        </div>
                    </div>
                </div>
                @endforeach

                @foreach ($pan as $key => $itpan)
                <hr class="w-full ">
                <div class="flex flex-wrap gap-3">
                        <div>
                            <div class="flex gap-2">
                                <x-label value="{{ __('Panel') }}" />
                                <a type="button"
                                    class="bg-red-100 text-red-500 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full cursor-pointer dark:bg-red-500 dark:text-red-300"
                                    wire:click.prevent="removePanel({{ $key }}, {{ $itpan }})"
                                    title="Nuevo">
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-content="Agregar Nuevo Producto"
                                        data-bs-placement="top">
                                        Eliminar Panel
                                    </span>
                                </a>
                            </div>
                            <select id="panel.{{ $itpan }}" wire:model="panel.{{ $itpan }}"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('panel.*') ? 'is-invalid' : '' }}"
                                name="panel.{{ $itpan }}" required aria-required="true">
                                <option hidden value="" selected>{{ __('Seleccionar Panel') }}</option>
                                @foreach ($panels as $panel)
                                    <option value="{{ $panel->id }}">{{ $panel->titulo_panel }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="panel.*"></x-input-error>
                        </div>
                        <div>
                            <x-label value="{{ __('Categoria') }}" />

                            <select id="catego.{{ $itpan }}.1" wire:model="catego.{{ $itpan }}.1"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('catego.*.1') ? 'is-invalid' : '' }}"
                                name="catego.{{ $itpan }}.1" required aria-required="true">
                                <option hidden value="" selected>{{ __('Seleccionar Categoría') }}</option>
                                <option value="Nuevo">{{ __('Nuevo') }}</option>
                                <option value="Debug">{{ __('Debug') }}</option>
                                <option value="Design">{{ __('Design') }}</option>
                            </select>
                            <x-input-error for="catego.*.1"></x-input-error>
                        </div>

                        <div class="w-full">
                            <span>Descripcion</span>
                            <div class="inline">
                                <a type="button"
                                    class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full cursor-pointer dark:bg-blue-900 dark:text-blue-300"
                                    wire:click.prevent="addCat({{ $h }})" title="Nuevo">
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-content="Agregar Nuevo Producto"
                                        data-bs-placement="top">
                                        Añadir
                                    </span>
                                </a>
                            </div>
                            <textarea wire:model="descripcion.{{ $itpan }}.1"
                                class="resize-none w-full rounded-md dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('descripcion.*.1') ? 'is-invalid' : '' }} resize-none"
                                name="descripcion.{{ $itpan }}.1" required autofocus autocomplete="descripcion.{{ $itpan }}.1">
                                </textarea>
                            <x-input-error for="descripcion.*.1"></x-input-error>
                        </div>
                        



                        @foreach ($inputCat as $key => $itemCat)
                            <div class="flex flex-wrap">
                                <div class="mb-3 col-5">
                                    <x-label value="{{ __('Categoria') }}" />

                                    <select id="catego.{{ $itpan }}.{{ $itemCat }}"
                                        wire:model="catego.{{ $itpan }}.{{ $itemCat }}"
                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                                                dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('catego.*.*') ? 'is-invalid' : '' }}"
                                        name="catego.{{ $itpan }}.{{ $itemCat }}" required
                                        aria-required="true">
                                        <option hidden value="" selected>{{ __('Seleccionar Categoría') }}
                                        </option>
                                        <option value="Nuevo">{{ __('Nuevo') }}</option>
                                        <option value="Debug">{{ __('Debug') }}</option>
                                        <option value="Design">{{ __('Design') }}</option>
                                    </select>
                                    <x-input-error for="catego.*.*"></x-input-error>
                                </div>

                                <div class="mb-3 col-5 w-full">
                                    <div class="w-full">
                                        <span>Descripcion</span>
                                        <div class="inline">
                                            <button type="button"
                                                class="bg-red-100 text-red-500 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full cursor-pointer dark:bg-red-500 dark:text-red-300"
                                                wire:click.prevent="removeCat({{ $key }}, {{ $itemCat }})"
                                                title="Eliminar Producto">
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                                    data-bs-trigger="hover focus" data-bs-content="Eliminar Producto"
                                                    data-bs-placement="top">
                                                    Eliminar
                                                </span>
                                            </button>
                                        </div>
                                        <textarea wire:model="descripcion.{{ $itpan }}.{{ $itemCat }}"
                                            class="resize-none w-full rounded-md dark:bg-slate-800 dark:border-gray-700 {{ $errors->has('descripcion.*.*') ? 'is-invalid' : '' }} "
                                            name="descripcion.{{ $itpan }}.{{ $itemCat }}" required autofocus
                                            autocomplete="descripcion.{{ $itpan }}.{{ $itemCat }}"></textarea>

                                        <x-input-error for="descripcion.*.*"></x-input-error>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addVersion" wire:loading.attr="disabled">
                <div wire:loading wire:target="addVersion" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                {{ __('Aceptar') }}
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgVersion')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>