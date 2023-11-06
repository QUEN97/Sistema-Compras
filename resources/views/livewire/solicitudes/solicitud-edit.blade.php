<div>
    <button wire:click="confirmSolicitudEdit({{ $solicitud_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="EditSolicitud{{ $solicitud_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar Solicitud</span>
    </button>

    <x-dialog-modal wire:model="EditSolicitud" id="EditSolicitud{{ $solicitud_id }}" class="flex items-center">
        <x-slot name="title">
            <span class="dark:text-white">{{ __('Editar Solicitud') }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap max-h-[320px] overflow-y-auto">
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Producto') }}" />
                    <select id="producto" wire:model="producto"
                        class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto') ? 'is-invalid' : '' }}"
                        name="producto" required aria-required="true">
                        <option hidden value="" selected>Seleccionar producto</option>
                        @foreach ($productos as $producto)
                            @if ($producto->status == 'Activo')
                                <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error for="producto"></x-input-error>
                </div>
                @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                    <div class="mb-3 mr-2 ">
                        <x-label value="{{ __('Proveedor') }}" />
                        <select id="proveedor" wire:model="proveedor"
                            class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('proveedor') ? 'is-invalid' : '' }}"
                            name="proveedor" required aria-required="true">
                            <option hidden value="" selected>Seleccionar proveedor</option>
                            @foreach ($proveedores as $provee)
                                @if ($provee->flag_trash == 0)
                                    <option value="{{ $provee->id }}">{{ $provee->titulo_proveedor }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error for="proveedor"></x-input-error>
                    </div>
                @endif
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Cantidad') }}" />
                    <x-input wire:model="cantidad"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                        type="number" name="cantidad" :value="old('cantidad')" required autofocus autocomplete="cantidad"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                    <x-input-error for="cantidad"></x-input-error>
                </div>
                <div class="mb-3 mr-2 ">
                    <x-label value="{{ __('Motivo') }}" />
                    <x-input wire:model="motivo"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('motivo') ? 'is-invalid' : '' }}"
                        type="text" name="motivo" :value="old('motivo')" required autofocus autocomplete="motivo" />
                    <x-input-error for="motivo"></x-input-error>
                </div>
				@if (Auth::user()->permiso_id==1 || Auth::user()->permiso_id==4 )
                	<div class="mb-3 mr-2 ">
                        <x-label value="{{ __('Subtotal de la solicitud') }}" />
                        <x-input wire:model="total"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('total') ? 'is-invalid' : '' }}"
                            type="number" name="total" :value="old('total')" required autofocus autocomplete="total"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="total"></x-input-error>
                    </div>
                    <div class="mb-3 mr-2 ">
                        <x-label value="{{ __('IVA en %') }}" />
                        <x-input wire:model="iva" min="0"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('total') ? 'is-invalid' : '' }}"
                            type="number" name="total" :value="old('total')" required autofocus autocomplete="total"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="iva"></x-input-error>
                    </div>
                    <div class="mb-3 mr-2 ">
                        <x-label value="{{ __('ISR en %') }}" />
                        <x-input wire:model="isr" min="0"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('total') ? 'is-invalid' : '' }}"
                            type="number" name="total" :value="old('total')" required autofocus autocomplete="total"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="isr"></x-input-error>
                    </div>
                @endif
				 @if (in_array($solicitudEs->categoria_id,[5,6,7]))
                    <div class="mb-1 col-12 w-full"
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                        <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left mb-2"/>
                        <input type="file" wire:model="evidencias" class=" pb-2 flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                        multiple name="evidencias" required autocomplete="evidencias" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <x-input-error for="evidencias"></x-input-error>
        
                        <!-- Progress Bar -->
                        <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-2 dark:bg-gray-700">
                            <div class="bg-red-600 h-2.5 rounded-full dark:bg-red-500 transition-[width] duration-500"  x-bind:style="`width:${progress}%`"></div>
                        </div>
                    </div>
                @endif
                <div class="mb-3 mr-2 ">
                    <a type="button" wire:click="EditarSolicitud({{ $solicitud_id }})"
                        class="cursor-pointer bg-green-100 hover:bg-green-200 text-green-800 text-base font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Nuevo</a>

                </div>
                <!--Vista productos solicitados -->
                <div class="grid grid-cols-4 gap-4 ">
                    @if ($solicitudEs)
                        {{-- <span class=" text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">{{ __('Productos Solicitados:') }}</span> --}}
                        @foreach ($solicitudEs->productos as $prod)
                            @if ($solicitudEs->deleted_at == null)
                                @if ($prod->status == 'Activo')
                                    <div class="mt-2 p-4">
                                        <span class="inline justify-center">
                                            @if ($prod->product_photo_path == null)
                                                <img name="photo" class="rounded-full"
                                                    src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                                    style="height: 4rem;" />
                                            @else
                                                <img name="photo" class="rounded-full"
                                                    src="{{ asset('storage/' . $prod->product_photo_path) }}"
                                                    style="height: 4rem;" />
                                            @endif
                                            <p class="text-xs dark:text-white">{{ $prod->name }}</p>
                                            <p>
                                                <span
                                                    class="text-xs bg-purple-100  text-purple-800  font-medium mr-2 px-2.5 py-0.5 rounded  dark:text-purple-800">
                                                    {{ __('Cantidad:') }}</span> <br>
                                                <button type="button"
                                                    class="bg-red-600 hover:bg-red-300 text-white text-xs font-semibold mr-2 px-0.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400"
                                                    wire:click="minusProduc({{ $prod->pivot->id }}, {{ $prod->id }})"
                                                    @if ($prod->pivot->cantidad == 0) {{ 'disabled' }} @endif>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M18 12H6" />
                                                    </svg>
                                                </button>
                                                <span
                                                    class="text-center dark:text-white ">{{ $prod->pivot->cantidad }}</span>
                                                <button type="button"
                                                    class="bg-green-600 hover:bg-green-300 text-white text-xs font-semibold mr-2 px-0.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400"
                                                    wire:click="moreProduc({{ $prod->pivot->id }}, {{ $prod->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6v12m6-6H6" />
                                                    </svg>
                                                </button>
                                            </p>
                                        </span>

                                        @if ($solicitudEs->productos->count() > 1)
                                            <button type="button"
                                                class="bg-red-600 hover:bg-red-300 text-white text-xs font-semibold mr-2 px-0.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400"
                                                wire:click="removeProduc({{ $prod->pivot->id }})">
                                                {{ __('Eliminar') }}
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
                {{-- Lista de productos sugeridos --}}
                <div class="w-full">
                    @if ($sugerencias)
                        @if ($sugerencias->count() > 0)
                            <h2 class="border-b py-1 text-lg">Sugerencias</h2>
                        @endif
                        <div class="flex gap-2 items-stretch w-full overflow-auto py-3">
                            @foreach ($sugerencias as $ps)
                                <div class="flex flex-col items-center gap-2 p-2 border w-[320px]" wire:ignore>
                                    @if (isset($ps->product_photo_path))
                                        <figure class="w-28 h-28 rounded-full overflow-hidden">
                                            @if ($ps->product_photo_path == null)
                                                <img name="photo" class="w-full"
                                                    src="{{ asset('storage/product-photos/imagedefault.jpg') }}" />
                                            @else
                                                <img name="photo" class="w-full"
                                                    src="{{ asset('storage/' . $prod->product_photo_path) }}" />
                                            @endif
                                        </figure>
                                    @endif
                                    <div class=" font-bold">
                                        @if (isset($ps->name))
                                            {{ $ps->name }}
                                        @endif
                                    </div>
                                    <div class="w-full bg-amber-300 p-1 ">
                                        @if (isset($ps->stock) && isset($ps->stock_fijo))
                                            <p>En almacén: {{ $ps->stock }}</p>
                                            <p>Stock sugerido: {{ $ps->stock_fijo }}</p>
                                        @endif

                                    </div>
                                    @if (isset($ps->ps_id))
                                        <button type="button"
                                            wire:click="addSugerencia({{ $ps->ps_id }},{{ $solicitud_id }})"
                                            class="flex gap-1  justify-center items-center w-full p-2 rounded-md bg-green-600 text-white hover:bg-green-500 transition duration-300">
                                            {{ __('Añadir') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                class="w-3 h-3" fill="currentColor">
                                                <path
                                                    d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3V320c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 53 43 96 96 96H352c53 0 96-43 96-96V352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V352z" />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
				<div class="w-full">
                <div >
                    @if ($solicitudEs->evidencias->count() > 0)
					
                            <label class="flex justify-center gap-3 items-center text-white bg-amber-600 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/>
                            </svg>
                            {{ __('Evidencias registradas') }}
                        </label>
                        <div class="flex flex-wrap gap-3 py-2">
                            @foreach ($solicitudEs->evidencias as $antigArch)
                                @if ($antigArch->flag_trash == 0)
                                    <div class="p-5 relative max-w-[18rem] border rounded-md shadow-md dark:bg-slate-700 dark:border-slate-700">
                                        @if ($antigArch->mime_type == "image/png" || $antigArch->mime_type == "image/jpg" || $antigArch->mime_type == "image/jpeg" 
                                                                || $antigArch->mime_type == "image/webp")
                                            <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank" data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}" data-title="{{ $antigArch->nombre_archivo }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                <figure class="d-inline-block max-w-[160px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para visualizar" data-bs-placement="top">
                                                    <img class="w-full" style="width:100px;" src="{{ asset('storage/'.$antigArch->archivo_path) }}">
                                                    <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                                </figure>
                                            </a>
                                        @elseif ($antigArch->mime_type == "application/pdf")
                                            <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                <figure class="d-inline-block max-w-[160px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                    <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                                    <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                </figure>
                                            </a>
                                        @elseif ($antigArch->mime_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                                            <a  href="{{ asset('storage/'.$antigArch->archivo_path) }}" target="_blank"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                <figure class="d-inline-block max-w-[160px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                    <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                                    <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                </figure>
                                            </a>
                                        @endif
                                        <button type="button" class="absolute top-1 right-1" wire:click="deleteEvidencia({{$antigArch->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg"  class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" stroke-width="0" fill="currentColor"></path>
                                                <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            </div>
			
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="GenPDF({{ $solicitud_id }})" wire:loading.attr="disabled">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                {{ __('Actualizar y Generar PDF') }}
            </x-danger-button>
            <x-secondary-button wire:click="$toggle('EditSolicitud')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
