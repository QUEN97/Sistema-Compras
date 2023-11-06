<div>
    <button wire:click="confirmProveedorEdit({{ $proveedorID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>
    <x-dialog-modal wire:model="editProveedor" class="text-black">
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

                {{-- <div>
                    <x-label value="{{ __('Categoría') }}" for="categoria"/>
                    <select id="categoria" wire:model="categoria"
                            class="select-categorias form-select form-control {{ $errors->has('categoria') ? 'is-invalid' : '' }}
                            border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                            name="categoria" required aria-required="true">
                           
                        @foreach ($categorias as $cate)
                            <option value="{{ $cate->id }}"  @if ($categoria == $cate->id) selected @endif>{{ $cate->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="categoria"></x-input-error>
                </div> --}}
                <div class="flex flex-wrap gap-3">
                    <div>
                        <x-label value="{{ __('Método de Pago') }}" for="mpago"/>
                        <select wire:model="numRef" name="mpago" id="mpago"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700">
                           {{--  <option hidden value="" selected>Seleccionar Método</option> --}}
                           @if (is_numeric($ref))
                            <option value="REF" selected>REF.NÚMERICA</option>
                            <option value="CREDITO">CRÉDITO</option>
                            <option value="CONTADO">CONTADO</option>
                            {{$showRef=true}}
                           @endif
                           @if ($ref=="CREDITO")
                            <option value="CREDITO" selected >CRÉDITO</option>
                            <option value="CONTADO">CONTADO</option>
                            <option value="REF">REF.NÚMERICA</option>
                           @endif
                           @if ($ref=="CONTADO")
                            <option value="CONTADO" selected >CONTADO</option>
                            <option value="CREDITO">CRÉDITO</option>
                            <option value="REF">REF.NÚMERICA</option>
                           @endif
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
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:border-gray-700">
                            {{-- <option hidden value="" selected>Seleccionar Banco</option> --}}
                            @if ($Nbanco!="BANAMEX" && $Nbanco!="BANCO AZTECA" && $Nbanco!="BBVA BANCOMER" && $Nbanco!="BANORTE" && $Nbanco!="HSBC" && $Nbanco!="SANTANDER" && $Nbanco!="SCOTIABANK")
                                <option value="0" selected>OTROS</option>
                                <option value="BANAMEX">BANAMEX</option>
                                <option value="BANCO AZTECA">BANCO AZTECA</option>
                                <option value="BBVA BANCOMER">BBVA BANCOMER</option>
                                <option value="BANORTE">BANORTE</option>
                                <option value="HSBC">HSBC</option>
                                <option value="SANTANDER">SANTANDER</option>
                                <option value="SCOTIABANK">SCOTIABANK</option>
                                {{$showBank=true}}
                                
                            @else
                                <option hidden value="" selected>Seleccionar Banco</option>
                                <option value="BANAMEX">BANAMEX</option>
                                <option value="BANCO AZTECA">BANCO AZTECA</option>
                                <option value="BBVA BANCOMER">BBVA BANCOMER</option>
                                <option value="BANORTE">BANORTE</option>
                                <option value="HSBC">HSBC</option>
                                <option value="SANTANDER">SANTANDER</option>
                                <option value="SCOTIABANK">SCOTIABANK</option>
                                <option value="0">OTROS</option>
                            @endif
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
            <x-danger-button class="mr-2" wire:click="ProveedorUpdate({{$proveedorID}})" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('editProveedor',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>