<div>
    <button wire:click="confirmFacturaEdit({{ $facturaID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 hover:text-indigo-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>
    <x-dialog-modal wire:model="editFactura" class="text-black">
        <x-slot name="title">Editar Registro #{{$facturaID}}</x-slot>
        <x-slot name="content">
            <div class="flex justify-around items-center flex-wrap gap-3">
                <div>
                    <x-label value="{{ __('Estación') }}" for="estacion" />
                    <select wire:model="estacion" name="estacion" required id="estacion" class="border-gray-300 rounded-md dark:bg-slate-800 dark:border-gray-700">
                        @if ($estaciones !=null)
                            @foreach ($estaciones as $es)
                                <option value="{{ $es->id }}">{{ $es->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-input-error for="estacion"></x-input-error>
                    </select>
                </div>
                <div>
                    <x-label value="{{ __('Proveedor') }}" for="proveedor"/>
                    <x-input wire:model="proveedor" class="form-control w-full" type="text" name="proveedor" id="proveedor" required disabled/>
                    <x-input-error for="proveedor"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Monto Total') }}" for="monto"/>
                    <x-input wire:model="monto" class="form-control" type="number" name="monto" id="monto" required min="0" value="0"/>
                    <x-input-error for="monto"></x-input-error>
                </div>
                <div>
                    <x-label value="{{ __('Folio Fiscal en Registrado') }}" for="folio"/>
                    <x-input wire:model="folio" class="form-control" type="text" name="folio" id="folio" required  maxlength="36"/>
                    <x-input-error for="folio"></x-input-error>
                </div>
            </div>
            <div class="my-3 pt-2 flex justify-center items-center flex-col">
                <x-label value="{{ __('Productos') }}" for="pFacturas" class="border-b border-gray-400 w-full text-left"/>
                <div class="flex items-start flex-wrap gap-2 max-h-28 overflow-y-auto px-5 mt-2">
                    @foreach ($productos as $pr)
                        <div class="flex flex-row items-center gap-0.5">
                            <input type="checkbox" wire:model="productosUpdate" value="{{$pr->id }}" name="productosUpdate[]" id="{{$pr->producto}}{{$facturaID}}" class="hidden peer{{-- text-blue-600 bg-gray-100 border-gray-300 rounded dark:ring-offset-gray-800 dark:border-gray-600 --}}">
                            <label for="{{$pr->producto}}{{$facturaID}}" class="break-all text-start w-full border py-1 px-2 rounded-md border-gray-300 cursor-pointer peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white">
                                {{$pr->producto}}
                            </label>
                        </div>
                    @endforeach
                    <x-input-error for="productosUpdate"></x-input-error>
                </div>
            </div>
            <div class="py-3">
                <div class="mb-3 flex gap-2 items-center justify-ceter flex-col"
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <x-label value="{{ __('Evidencias') }}" class="border-b border-gray-400 w-full text-left"/>
                    <input type="file" wire:model="evidencias" class="flex flex-wrap file:text-sm file:font-semibold file:bg-blue-300 file:text-blue-700 hover:file:bg-blue-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0"
                    multiple name="evidencias" required autocomplete="evidencias" accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    <x-input-error for="evidencias"></x-input-error>

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
            <div>
                {{-- comienza para evidencias --}}
                {{-- Preview cuando se sube un archivo --}}
                <div class="col-md-12 col-sm-12 col-xs-12 text-center mb-3">
                    <div class="row">
                        @if ($evidencias)
                            <x-label value="{{ __('Imagenes Seleccionadas') }}" />
                            <div class="flex justyfy-venly flex-wrap gap-3 py-2">
                                @foreach ($evidencias as $item)
                                    <div class="max-w-[90px] p-1 relative" wire:key="{{$loop->index}}">
                                        @if ($item->getMimeType() == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $item->getMimeType() == "application/msword")
                                            <img class="w-full" src="{{ asset('img/icons/word-2019.svg') }}">
                                            <p class="break-all">{{ $item->getClientOriginalName() }}</p>
                                            <p>{{ $item->getSize() }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'MB') }}
                                                </p>
                                            @endif
                                        @elseif ($item->getMimeType() == "application/pdf")
                                            <img class="w-full" src="{{ asset('img/icons/pdf.png') }}">
                                            <p>{{ $item->getClientOriginalName() }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'MB') }}
                                                </p>
                                            @endif
                                        @elseif ($item->getMimeType() == "image/png" || $item->getMimeType() == "image/jpg" || $item->getMimeType() == "image/jpeg" 
                                                                || $item->getMimeType() == "image/webp")
                                            <img class="w-full" src="{{ $item->temporaryUrl() }}">
                                            <p class="break-all">{{ $item->getClientOriginalName() }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'MB') }}
                                                </p>
                                            @endif
                                        @else
                                            <img class="w-full" src="{{ asset('img/icons/file.png') }}">
                                            <p>{{ __('Archivo no Soportado') }}</p>
                                            @if (strlen($item->getSize()) == 4)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  5)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  6)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 3). ' ' .'KB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  7)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 1). ' ' .'MB') }}
                                                </p>
                                            @elseif (strlen($item->getSize()) ==  8)
                                                <p>
                                                    {{ __(substr($item->getSize(), 0, 2). ' ' .'MB') }}
                                                </p>
                                            @endif
                                        @endif
                                        <button type="button" class="absolute top-0 right-0" wire:click="removeMe({{$loop->index}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Archivos en BD --}}
                <div class="col-md-12 col-sm-12 col-xs-12 text-center mb-3">
                    <div>
                        @if ($evidenciaArc)
                            @if ($evidenciaArc->count() > 0)
                            <label class="flex justify-center gap-3 items-center text-white bg-amber-600 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="16" height="16" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/>
                                </svg>
                                {{ __('Archivos Almacenados') }}
                            </label>
                                <div class="flex justyfy-venly flex-wrap gap-3 py-2">
                                    @foreach ($evidenciaArc as $antigArch)
                                        @if ($antigArch->flag_trash == 0)
                                            <div class="relative p-1">
                                                @if ($antigArch->mime_type == "image/png" || $antigArch->mime_type == "image/jpg" || $antigArch->mime_type == "image/jpeg" 
                                                                        || $antigArch->mime_type == "image/webp")
                                                    <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}" data-title="{{ $antigArch->nombre_archivo }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs p-1.5">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para visualizar" data-bs-placement="top">
                                                            <img class="w-full" src="{{ asset('storage/'.$antigArch->archivo_path) }}">
                                                            <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                                            @if (strlen($antigArch->size) == 4)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  5)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  6)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 3). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  7)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1). ' ' .'MB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  8)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2). ' ' .'MB') }}
                                                                </p>
                                                            @endif
                                                            </figure>
                                                    </a>
                                                @elseif ($antigArch->mime_type == "application/pdf")
                                                    <a href="{{ asset('storage/'.$antigArch->archivo_path) }}" download=""
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                            <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                            @if (strlen($antigArch->size) == 4)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  5)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  6)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 3). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  7)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1). ' ' .'MB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  8)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2). ' ' .'MB') }}
                                                                </p>
                                                            @endif
                                                            </figure>
                                                    </a>
                                                @elseif ($antigArch->mime_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                                                    <a  href="{{ asset('storage/'.$antigArch->archivo_path) }}" download=""
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" class="text-xs">
                                                        <figure class="d-inline-block max-w-[90px]" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Presione para descargar" data-bs-placement="top">
                                                            <img class="w-100" src="{{ asset('img/icons/word-2019.svg') }}">
                                                            <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                            @if (strlen($antigArch->size) == 4)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  5)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  6)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 3). ' ' .'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  7)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1). ' ' .'MB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) ==  8)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2). ' ' .'MB') }}
                                                                </p>
                                                            @endif
                                                            </figure>
                                                    </a>
                                                @endif
                                                <button type="button" class="absolute top-0 right-0" wire:click="removeArch({{$antigArch->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="Doble click para Eliminar">
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Doble click para Eliminar" data-bs-placement="top">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill w-5 h-5 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 16 16">
                                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col justify-center items-center gap-3 py-6 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="max-w-[100px]  icon icon-tabler icon-tabler-folder-off" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 4h1l3 3h7a2 2 0 0 1 2 2v8m-2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 1.189 -1.829"></path>
                                        <path d="M3 3l18 18"></path>
                                     </svg>
                                    <span class="text-xl">No se encontraron Archivos</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-danger-button class="mr-2" wire:click="FacturaUpdate({{$facturaID}})" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$set('editFactura',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>