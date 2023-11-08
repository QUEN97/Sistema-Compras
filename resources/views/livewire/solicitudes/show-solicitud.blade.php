<div>
    <button wire:click="confirmShowSolicitud({{ $solicitud_show_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="ShowSolicitud{{ $solicitud_show_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-yellow-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="tooltiptext">Ver Más</span>
    </button>

    <x-dialog-modal wire:model="ShowgSolicitud" id="ShowSolicitud{{ $solicitud_show_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Información General de la Solicitud de Productos') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col justify-center items-center">
                <div class="grid grid-cols-2 gap-2 px-2 w-full">
                    <div
                        class="flex flex-col items-start justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                        <p class="text-sm text-gray-600 dark:text-white">Estación:</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            <span class="uppercase">{{ $this->name }}</span>
                        </p>
                    </div>
                    <div
                        class="flex flex-col justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                        <p class="text-sm text-gray-600 dark:text-white">Fecha de registro:</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            <span class="uppercase">{{ $this->created_at }}</span>
                        </p>
                    </div>
                </div>
                <div
                    class="flex flex-col items-center justify-center rounded-2xl e bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm  text-gray-600 dark:text-white">Archivo PDF:</p>
                    <p class="font-medium items-start text-red-500 dark:text-white">
                        <a class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-gray-800"
                            href="{{ asset('storage/solicitudes-pdfs/' . $this->pdf) }}" download>
                            {{ $this->pdf }}
                            <span
                                class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-red-800 bg-red-200 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </span>
                        </a>
                    </p>
                </div>
                @if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                    <div class="flex flex-wrap gap-2 justify-center">
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                            <p class="text-sm text-gray-600 dark:text-white">Precio total:</p>
                            @if ($solicitudes)
                                <span class="text-base font-medium text-navy-700 dark:text-white">
                                    ${{ number_format($solicitudes->total + $solicitudes->iva - $solicitudes->isr, 2) }}
                                </span>
                            @endif
                        </div>
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                            <p class="text-sm text-gray-600 dark:text-white">Subtotal:</p>
                            @if ($solicitudes)
                                <span class="text-base font-medium text-navy-700 dark:text-white">
                                    ${{ number_format($solicitudes->total, 2) }}
                                </span>
                            @endif
                        </div>
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                            <p class="text-sm text-gray-600 dark:text-white">IVA:</p>
                            @if ($solicitudes)
                                <span class="text-base font-medium text-navy-700 dark:text-white">
                                    ${{ number_format($solicitudes->iva, 2) }}
                                </span>
                            @endif
                        </div>
                        <div
                            class="flex flex-col items-center justify-center rounded-2xl  bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                            <p class="text-sm text-gray-600 dark:text-white">ISR:</p>
                            @if ($solicitudes)
                                <span class="text-base font-medium text-navy-700 dark:text-white">
                                    ${{ number_format($solicitudes->isr, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($observaciones)
                    <div class="border rounded-lg w-full overflow-hidden max-h-[320px] overflow-y-auto">
                        <details>
                            <summary class="bg-gray-100 py-2 px-4 cursor-pointer dark:text-black">Click para
                                mostrar/ocultar
                                Historial de Observaciones</summary>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Id</th>
                                        <th class="px-4 py-2">Observación</th>
                                        <th class="px-4 py-2">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($observaciones as $observa)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs"> # {{ $observa->id }}</span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs">
                                                    {{ $observa->observacion }}
                                                </span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="text-xs">
                                                    {{ $observa->created_format }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="3">Sin datos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </details>
                    </div>
                @endif

                <br>

                @if ($solicitudes)
                    <div class="border rounded-lg w-full overflow-hidden max-h-[320px] overflow-y-auto">
                        <details>
                            <summary class="bg-gray-100 py-2 px-4 cursor-pointer dark:text-black">Click para
                                mostrar/ocultar
                                Productos Solicitados</summary>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Id</th>
                                        <th class="px-4 py-2">Imagen</th>
                                        <th class="px-4 py-2">Producto</th>
                                        <th class="px-4 py-2">Cantidad</th>
                                        <th class="px-4 py-2">Estado</th>
                                    </tr>
                                </thead>
                                @if ($solicitudes->tipo_compra == 'Ordinario')
                                    <tbody>
                                        @forelse($solicitudes->productos as $produc)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"> # {{ $produc->pivot->id }}</span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @if ($produc->product_photo_path == null)
                                                        <img class="rounded-full w-16 h-16" name="photo"
                                                            src="{{ asset('storage/product-photos/imagedefault.jpg') }}" />
                                                    @else
                                                        <img class="rounded-full w-16 h-16" name="photo"
                                                            src="{{ asset('storage/' . $produc->product_photo_path) }}" />
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        {{ $produc->name }}
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        {{ $produc->pivot->cantidad }}
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if ($produc->pivot->flag_trash == 0)
                                                            <i class="fa-solid fa-file-lines text-success"></i>
                                                            {{ __('En Solicitud') }}
                                                        @else
                                                            <i class="fa-solid fa-file-lines text-danger"></i>
                                                            {{ __('Eliminado de la solicitud') }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border px-4 py-2" colspan="5">Sin datos.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                @else
                                    <tbody>
                                        @forelse($this->productsext as $ext)
                                            <tr>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs"># {{ $ext->id ?? ' ' }}</span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <img class="rounded-full w-16 h-16" name="photo"
                                                        src="{{ asset('storage/product-photos/imagedefault.jpg') }}" />
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        {{ $ext->producto_extraordinario ?? ' ' }}
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        {{ $ext->cantidad ?? ' ' }}
                                                    </span>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <span class="text-xs">
                                                        @if (isset($ext->flag_trash) && $ext->flag_trash == 0)
                                                            <p style="display: flex; align-items: center;">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5 text-green-400">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9.661 2.237a.531.531 0 01.678 0 11.947 11.947 0 007.078 2.749.5.5 0 01.479.425c.069.52.104 1.05.104 1.59 0 5.162-3.26 9.563-7.834 11.256a.48.48 0 01-.332 0C5.26 16.564 2 12.163 2 7c0-.538.035-1.069.104-1.589a.5.5 0 01.48-.425 11.947 11.947 0 007.077-2.75zm4.196 5.954a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <span> {{ __('En Solicitud') }}</span>
                                                            </p>
                                                        @else
                                                            <p style="display: flex; align-items: center;">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5 text-red-400">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10.339 2.237a.532.532 0 00-.678 0 11.947 11.947 0 01-7.078 2.75.5.5 0 00-.479.425A12.11 12.11 0 002 7c0 5.163 3.26 9.564 7.834 11.257a.48.48 0 00.332 0C14.74 16.564 18 12.163 18 7.001c0-.54-.035-1.07-.104-1.59a.5.5 0 00-.48-.425 11.947 11.947 0 01-7.077-2.75zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <span>{{ __('Eliminado Solicitud') }}</span>
                                                            </p>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border px-4 py-2" colspan="5">Sin datos.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                @endif
                            </table>
                        </details>
                    </div>
                    @if ($solicitudes->evidencias->count() > 0)
                        <br>
                        <div class="border rounded-lg w-full overflow-hidden max-h-[320px] overflow-y-auto">
                            <details>
                                <summary class="bg-gray-100 py-2 px-4 cursor-pointer dark:text-black">
                                    Click para mostrar/ocultar evidencias
                                </summary>
                                <div class="border w-full flex flex-wrap gap-2 p-1">
                                    @foreach ($solicitudes->evidencias as $antigArch)
                                        <div
                                            class="p-3 relative max-w-[16rem] border rounded-md shadow-md dark:bg-slate-700 dark:border-slate-700">
                                            @if (
                                                $antigArch->mime_type == 'image/png' ||
                                                    $antigArch->mime_type == 'image/jpg' ||
                                                    $antigArch->mime_type == 'image/jpeg' ||
                                                    $antigArch->mime_type == 'image/webp')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                    target="_blank"
                                                    data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}"
                                                    data-title="{{ $antigArch->nombre_archivo }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Visualizar" class="text-xs">
                                                    <figure class="d-inline-block max-w-[160px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para visualizar"
                                                        data-bs-placement="top">
                                                        <img class="w-full"
                                                            src="{{ asset('storage/' . $antigArch->archivo_path) }}">
                                                        <p class="break-all">{{ $antigArch->nombre_archivo }}</p>
                                                    </figure>
                                                </a>
                                            @elseif ($antigArch->mime_type == 'application/pdf')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                    target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Visualizar" class="text-xs">
                                                    <figure class="d-inline-block max-w-[160px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para descargar"
                                                        data-bs-placement="top">
                                                        <img class="w-100" src="{{ asset('img/icons/pdf.png') }}">
                                                        <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                    </figure>
                                                </a>
                                            @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                    target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Visualizar" class="text-xs">
                                                    <figure class="d-inline-block max-w-[160px]" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Presione para descargar"
                                                        data-bs-placement="top">
                                                        <img class="w-100"
                                                            src="{{ asset('img/icons/word-2019.svg') }}">
                                                        <p class="break-all"> {{ $antigArch->nombre_archivo }} </p>
                                                    </figure>
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </details>
                        </div>
                    @endif
                @endif
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-secondary-button wire:click="$toggle('ShowgSolicitud')" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
