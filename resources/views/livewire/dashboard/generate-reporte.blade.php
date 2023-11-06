<div>
    <div class="">
        <x-button class="btn-sm" wire:click="showModalFormReporte">
            <i class="fa-solid fa-plus"></i>
            {{ __('Nuevo Reporte') }}
        </x-button>
    </div>

    <x-dialog-modal wire:model="newgReporte" id="modalReporte" class="flex items-center">
        <x-slot name="title">
            {{ __('Nuevo Reporte') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col gap-4">
                <div class="flex gap-3 flex-wrap">
                    <div class="col-12 p-0">
                        <x-label value="{{ __('Tipo de Reporte') }}" />

                        <select id="tiporepor" wire:model="tiporepor"
                                class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('tiporepor') ? 'is-invalid' : '' }}" 
                                name="tiporepor" required aria-required="true">
                                <option hidden value="" selected>{{ __('Seleccionar Tipo de Reporte') }}</option>
                                <option value="Solicitudes">{{ __('Solicitudes') }}</option>
                                <option value="Almacenes">{{ __('Almacenes') }}</option>
                                <option value="Repuestos">{{ __('Repuestos') }}</option>
                                <option value="Zonas">{{ __('Zonas') }}</option>
                                <option value="Estaciones">{{ __('Estaciones') }}</option>
                                <option value="Productos">{{ __('Productos') }}</option>
                                <option value="Categorias">{{ __('Categorias') }}</option>
                                <option value="Proveedores">{{ __('Proveedores') }}</option>
                                <option value="Gastos">{{ __('General de Gastos') }}</option>
                        </select>
                        <x-input-error for="tiporepor"></x-input-error>
                    </div>
                    @if ($statRepor != null)
                        <div class="mb-3 col-12">
                            <div class="col-12 p-0">
                                <x-label value="{{ __('Status') }}" />
        
                                <select id="reporSelec" wire:model="reporSelec"
                                        class="border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  {{ $errors->has('reporSelec') ? 'is-invalid' : '' }}" 
                                        name="reporSelec" required aria-required="true">
                                        <option hidden value="" selected>{{ __('Seleccionar el Status') }}</option>
                                        @foreach ($statRepor as $key => $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                </select>
                                <x-input-error for="reporSelec"></x-input-error>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex gap-3 flex-wrap">
                    <div class="mb-3 col-6">
                        <x-label value="{{ __('Fecha de Inicio') }}" />
                        
                        <input wire:model="fechIni" class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-black {{ $errors->has('fechIni') ? 'is-invalid' : '' }}" type="date" name="" id="">
    
                        <x-input-error for="fechIni"></x-input-error>
                    </div>
    
                    <div class="mb-3 col-6">
                        <x-label value="{{ __('Fecha de Fin') }}" />
                        
                        <input wire:model="fechFin" class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-dark-eval-0 dark:border-gray-700 dark:text-black {{ $errors->has('fechFin') ? 'is-invalid' : '' }}" type="date" name="" id="">
    
                        <x-input-error for="fechFin"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addReporte" wire:loading.attr="disabled">
                <div wire:loading wire:target="addReporte" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>

                {{ __('Aceptar') }}
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgReporte')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>


