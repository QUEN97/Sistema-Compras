<div class="text-black dark:text-slate-400">
    <button wire:click="ShowFactura({{$facturaID}})" wire:loading.attr="disabled" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-indigo-500 transition duration-300" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>
    <x-dialog-modal wire:model="showFactura" class="flex items-center">
        <x-slot name="title">
            {{ __('Información del Registro') }} #{{$facturaID}}
        </x-slot>
        <x-slot name="content" class="relative">
            {{-- si no ponemos el IF sale un error, esto se debe a la función Render del componente --}}
            @if ($factura)    
                <div class="flex flex-wrap justify-evenly items-center gap-3 border-b py-2">
                    <div>
                        <span class="font-bold">Asignado a la estación:</span>
                        <div>{{$factura->estacion}}</div>
                    </div>
                    <div>
                        <span class="font-bold">Creado el día:</span>
                        <div>{{$factura->created_at}}</div>
                    </div>
                    <div>
                        <span class="font-bold">Proveedor:</span>
                        <div class="text-left">{{$factura->titulo_proveedor}}</div>
                    </div>
                    <div>
                        <span class="font-bold">Folio Fiscal:</span>
                        <div class="text-left">{{$factura->folio_fiscal}}</div>
                    </div>
                </div>
                <div class="py-2 mt-1">
                    <span class="font-bold">Productos registrados:</span>
                    <ul class="border rounded-md flex flex-wrap justify-evenly items-center gap-3 py-2 list-disc  marker:text-lime-600">
                         @foreach ($productos as $pr)
                            <li>{{$pr->name}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex">
                    <span class="font-bold">Monto registrado:</span>
                    <div>${{$factura->monto}}</div>
                </div>
            @endif
            <br>
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
            
            <div class="absolute right-1.5	top-1.5">
                <button wire:click="$toggle('showFactura')" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg"fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-orange-800 transition duration-300" viewBox="0 0 320 512" >
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
                    </svg>
                </button>
            </div>
        </x-slot>
        <x-slot name="footer">
        </x-slot>
    </x-dialog-modal>
</div>
