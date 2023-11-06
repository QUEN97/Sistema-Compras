<div>
    <x-button wire:click="$set('addProveedor',true)" class="float-right flex gap-2 items center ">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 448 512" fill='currentColor'>
            <path d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/>
        </svg>
        <div>Nuevo Proveedor</div>    
    </x-button>
    <x-dialog-modal wire:model="addProveedor" class="flex items-center">
        <x-slot name="title">Nuevo Proveedor</x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap items-center gap-5 p-3">
                <div>
                    <x-label value="{{ __('Nombre') }}" for="pnombre" />
                    <x-input wire:model="titulo_proveedor" type="text" name="titulo_proveedor"
                        id="pnombre" required autofocus autocomplete="titulo_proveedor" />
                    <x-input-error for="titulo_proveedor"></x-input-error>
                </div>

                <div>
                    <x-label value="{{ __('RFC') }}" for="rfc"/>
                    <x-input wire:model="rfc" id="rfc" type="text" name="rfc" :value="old('rfc')" required autofocus autocomplete="rfc" />
                    <x-input-error for="rfc"></x-input-error>
                </div>

               {{--  <div>
                    <x-label value="{{ __('Categoría') }}" for="categoria"/>
                    <select id="categoria" wire:model="categoria"
                            class="select-categorias form-select form-control {{ $errors->has('categoria') ? 'is-invalid' : '' }}
                            border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                            name="categoria" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Categoría</option>
                        @foreach ($categorias as $cate)
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="categoria"></x-input-error>
                </div> --}}
                <div class="flex flex-wrap gap-3">
                    <div>
                        <x-label value="{{ __('Método de Pago') }}" for="mpago"/>
                        <select wire:model="numRef" name="mpago" id="mpago"
                        class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option hidden value="" selected>Seleccionar Método</option>
                            <option value="CREDITO">CRÉDITO</option>
                            <option value="CONTADO">CONTADO</option>
                            <option value="REF">REF.NÚMERICA</option>
                        </select>
                        <x-input-error for="numRef"></x-input-error>
                    </div>
                    @if ($showRef)
                        <div>
                            <x-label value="{{ __('Referencia') }}" for="mpago"/>
                            <x-input wire:model="ref" type="number" name="referencia" required autofocus autocomplete="ref" />
                            <x-input-error for="ref"></x-input-error>
                            {{-- <input wire:model="ref" type="number" name="referencia" id="referencia"> --}}
                        </div>
                    @endif
                </div>
                <div class="flex flex-wrap gap-3">
                    <div>
                        <x-label value="{{ __('Banco') }}" for="banco"/>
                        {{-- <x-input wire:model="banco" id="banco" type="text" name="banco" required autofocus autocomplete="banco" /> --}}
                        <select wire:model="banco" name="banco" id="banco"
                            class="w-full text-sm border-gray-300 dark:bg-dark-eval-0 dark:text-black focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option hidden value="" selected>Seleccionar Banco</option>
                            <option value="BANAMEX">BANAMEX</option>
                            <option value="BANCO AZTECA">BANCO AZTECA</option>
                            <option value="BBVA BANCOMER">BBVA BANCOMER</option>
                            <option value="BANORTE">BANORTE</option>
                            <option value="HSBC">HSBC</option>
                            <option value="SANTANDER">SANTANDER</option>
                            <option value="SCOTIABANK">SCOTIABANK</option>
                            <option value="0">OTROS</option>
                        </select>
                        <x-input-error for="banco"></x-input-error>
                    </div>
                    @if ($showBank)
                        <div>
                            <x-label value="{{ __('Nombre del Banco') }}" for="Nbanco"/>
                            <x-input wire:model="Nbanco" id="Nbanco" type="text" name="Nbanco" required autofocus autocomplete="Nbanco" />
                            {{-- <input wire:model="Nbanco" type="text" name="banco" id="Nbanco"> --}}
                            <x-input-error for="Nbanco"></x-input-error>
                        </div>
                    @endif
                </div>
                <div>
                    <x-label value="{{ __('No.de Cuenta') }}" for="Ncuenta"/>
                    <x-input wire:model="Ncuenta" id="Ncuenta" type="number" name="Ncuenta" required autofocus autocomplete="Ncuenta" />
                    <x-input-error for="Ncuenta"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Clabe') }}" for="Nclave"/>
                    <x-input wire:model="Nclave" id="Nclave" type="number" name="Nclave" required autofocus autocomplete="Nclave" />
                    <x-input-error for="Nclave"></x-input-error>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" wire:click="addProveedor" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('addProveedor',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal></div>