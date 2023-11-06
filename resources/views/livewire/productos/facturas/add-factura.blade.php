<div>
    <x-button wire:click="$set('addFactura',true)" class="float-right flex gap-2 items center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 448 512" fill=currentColor>
            <path d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/>
        </svg>
        <div>{{ __('Añadir Factura') }}</div>    
    </x-button>
    <x-dialog-modal wire:model="addFactura" class="flex items-center">
        <x-slot name="title">Nueva Factura</x-slot>
        <x-slot name="content">
            <div class="flex flex-wrap justify-evenly items-center gap-3">
                @if ($user->role != "Gerente")    
                    <div>
                        <x-label value="{{ __('Estación') }}" for="estacion" />
                        <select wire:model="estacion" name="estacion" required id="estacion" class="border-gray-300 rounded-md">
                            <option hidden value="" selected>Seleccionar Estación</option>
                            @foreach ($estaciones as $es)
                                <option value="{{ $es->id }}">{{ $es->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="estacion"></x-input-error>
                        </select>
                    </div>
                @endif
                <div>
                    <x-label value="{{ __('Proveedor') }}" for="proveedor" />
                    <select wire:model="proveedor" name="proveedor" id="proveedor" required class="max-w-[220px] border-gray-300 rounded-md">
                        <option hidden value="" selected>Seleccionar Proveedor</option>
                        @foreach ($proveedores as $p)
                            <option value="{{ $p->id }}">{{ $p->titulo_proveedor }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="proveedor"></x-input-error>
                    </select>
                </div>
                <div>
                    <x-label value="{{ __('Folio Fiscal en Factura') }}" for="folio"/>
                    <x-input wire:model="folio" class="form-control" type="text" name="folio" id="folio" required  maxlength="36"/>
                    <x-input-error for="folio"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Monto Total') }}" for="monto"/>
                    <x-input wire:model="monto" class="form-control" type="number" name="monto" id="monto" required min="0" value="0"/>
                    <x-input-error for="monto"></x-input-error>
                </div>
                <div wire:ignore>
                    <x-label value="{{ __('Producto') }}" for="pFacturas" />
                    <select name="productosList[]" id="pFacturas" required multiple class="border-gray-300 rounded-md">
                        @if ($productos !=null)
                            @foreach ($productos as $producto)
                                <option value="{{$producto->id}}">{{$producto->producto}}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-input-error for="productosList"></x-input-error>
                </div>
                <div class="mb-3 col-12 w-full"
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2"/>
                    <input type="file" wire:model="evidencias" class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                    multiple name="evidencias" required autocomplete="evidencias" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    <x-input-error for="evidencias"></x-input-error>

                    <!-- Progress Bar -->
                    {{-- <div wire:loading wire:target="evidencias">Subiendo...</div>
                    <div class="progress" x-show="isUploading" id="archivo">
                        <progress class="progress-bar progress-bar-striped bg-success progress-bar-animated" max="100" x-bind:value="progress"></progress>
                    </div>
                    @error('evidencias.*')
                        <span class="error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror --}}
                    <div wire:loading wire:target="evidencias"></div>
                    <div class="progress" x-show="isUploading" id="archivoRemis">
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
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" wire:click="addFactura" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('addFactura',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    <script>
        $('#pFacturas').select2({
            placeholder: "Seleccionar producto(s)",
            allowClear: true
        }).on('change', function(){
           @this.set('productosList', $(this).val());
        });
   </script>
</div>
