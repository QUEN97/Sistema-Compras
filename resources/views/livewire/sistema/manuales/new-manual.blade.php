<div class="">
    <x-button wire:click="showModalFormManual">
        {{ __('Nuevo Manual') }}
    </x-button>

    <x-dialog-modal wire:model="newgManual" id="modalManual" class="flex items-center">
        <x-slot name="title">
            {{ __('Nuevo Manual') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap">
                <div class="mr-3 mb-3">
                    <x-label value="{{ __('Paneles') }}" />

                    <select id="panel" wire:model="panel"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('panel') ? 'is-invalid' : '' }}"
                        name="panel" required aria-required="true">
                        <option hidden value="" selected>Seleccionar Panel</option>
                        @foreach ($paneles as $panel)
                            @if ($panel->flag_trash == 0 && $panel->pivot->re == 1 && $panel->titulo_panel != 'Facturas')
                                <option value="{{ $panel->id }}">{{ $panel->titulo_panel }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error for="panel"></x-input-error>
                </div>

                <div class="ml-3 mb-3">
                    @foreach ($permisos as $it)
                        <div class="block min-h-6 pl-7">
                           <label >
                            <input wire:model="permis" value="{{ $it->id }}"
                                class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 dark:border-neutral-600 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary dark:checked:border-primary checked:bg-primary dark:checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent{{ $errors->has('permis') ? 'is-invalid' : '' }}"
                                type="checkbox" id="{{ $it->id }}">
                            <label for="{{ $it->id }}">
                                {{ __($it->titulo_permiso) }}
                            </label>
                           </label>
                        </div>
                    @endforeach
                    <x-input-error for="permis"></x-input-error>
                </div>

                <div class="w-full px-3">
                    <div class="mb-3 col-6" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <x-label value="{{ __('Manual') }}" />

                        <form>
                            <label class="block">
                                <span class="sr-only">Elegir Archivo</span>
                                <input wire:model.defer="manual" type="file" accept=".pdf"
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
                        <x-input-error for="manual"></x-input-error>
                    </div>

                </div>
                
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addManual" wire:loading.attr="disabled">
                <div wire:loading wire:target="addManual" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>

                {{ __('Aceptar') }}
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgManual')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
