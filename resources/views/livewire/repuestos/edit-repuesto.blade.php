<div>

    <button wire:click="confirmRepuestoEdit({{ $repuesto_id }})" wire:loading.attr="disabled"
        data-target="EditRepuesto{{ $repuesto_id }}" class="tooltip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-blue-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>

    <x-dialog-modal wire:model="EditRepuesto" id="EditRepuesto{{ $repuesto_id }}" class="flex items-center">
        <x-slot name="title">
            {{ __('Editar Repuesto') }}
        </x-slot>

        <x-slot name="content" class="relative">
                <div class="flex flex-wrap justify-evenly gap-2 text-start">
                    <div class="mb-3 col-6">
                        <x-label value="{{ __('Producto') }}" />

                        <select id="producto" wire:model="producto"
                            class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('producto') ? 'is-invalid' : '' }}"
                            name="producto" required aria-required="true" disabled>
                            <option hidden value="" selected>Seleccionar producto</option>
                            @foreach ($productos as $productol)
                                @if ($productol->flag_trash == 0)
                                    <option value="{{ $productol->id }}"
                                        @if ($producto == $productol->id) {{ 'selected' }} @endif>
                                        {{ $productol->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error for="producto"></x-input-error>
                    </div>

                    <div class="mb-3 col-6">
                        <x-label value="{{ __('Cantidad') }}" />

                        <x-input wire:model="cantidad"
                            class="w-1/2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                            type="text" name="cantidad" :value="old('cantidad')" required autofocus autocomplete="cantidad"
                            onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                        <x-input-error for="cantidad"></x-input-error>
                    </div>

                    <div class="w-full">
                        <x-label value="{{ __('Descripcion') }}" />

                        <textarea wire:model="descripcion"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }} resize-none"
                            name="descripcion" required autofocus autocomplete="descripcion"></textarea>

                        <x-input-error for="descripcion"></x-input-error>
                    </div>
                </div>


                <div class="mb-3 col-12">

                    <div class="mb-3 col-6" x-data="{ isEvidencia: false, progress: 0 }" x-on:livewire-upload-start="isEvidencia = true"
                        x-on:livewire-upload-finish="isEvidencia = false"
                        x-on:livewire-upload-error="isEvidencia = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <x-label value="{{ __('Evidencia') }}" />

                        <form>
                            <label class="block">
                                <span class="sr-only">Elegir Archivo</span>
                                <input wire:model="evidencias" type="file"
                                    accept="image/*, .pdf, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 {{ $errors->has('remision.1') ? 'is-invalid' : '' }}"
                                    name="evidencias" required />
                            </label>
                        </form>

                        <x-input-error for="evidencias"></x-input-error>

                        <!-- Progress Bar -->
                        <div wire:loading wire:target="evidencias"></div>
                        <div class="progress" x-show="isEvidencia" id="archivoEvidencia">
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

                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                        <div class="row">
                            @if ($evidencias)
                                <x-label value="{{ __('Archivos Seleccionados') }}" class="text-center w-full" />
                                <br>
                                <div class="flex flex-wrap gap-1 justify-center">
                                    @foreach ($evidencias as $item)
                                        <div class="col-3 flex flex-wrap gap-2 justify-center max-w-[300px] relative border p-4 shadow rounded-md"
                                            wire:key="{{ $loop->index }}">
                                            @if (
                                                $item->getMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                                                    $item->getMimeType() == 'application/msword')
                                                <div
                                                    class=" flex flex-col gap-2 justify-center items-center max-w-[150px]">
                                                    <figure class="max-w-[100px]">
                                                        <img class="w-full"
                                                            src="{{ asset('img/icons/word-2019.svg') }}">
                                                    </figure>
                                                    <p class=" text-sm">{{ $item->getClientOriginalName() }}</p>
                                                    @if (strlen($item->getSize()) == 4)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 5)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 6)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 7)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 8)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @elseif ($item->getMimeType() == 'application/pdf')
                                                <div
                                                    class=" flex flex-col gap-2 justify-center items-center max-w-[250px]">
                                                    <figure class="max-w-[150px]">
                                                        <img class="w-full" src="{{ asset('img/icons/pdf.png') }}">
                                                    </figure>
                                                    <p>{{ $item->getClientOriginalName() }}</p>
                                                    @if (strlen($item->getSize()) == 4)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 5)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 6)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 7)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 8)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @elseif (
                                                $item->getMimeType() == 'image/png' ||
                                                    $item->getMimeType() == 'image/jpg' ||
                                                    $item->getMimeType() == 'image/jpeg' ||
                                                    $item->getMimeType() == 'image/webp')
                                                <div
                                                    class=" flex flex-col gap-2 justify-center items-center max-w-[250px]">
                                                    <figure class="max-w-[150px]">
                                                        <img class="w-full" src="{{ $item->temporaryUrl() }}">
                                                    </figure>
                                                    <p>{{ $item->getClientOriginalName() }}</p>
                                                    @if (strlen($item->getSize()) == 4)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 5)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 6)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 7)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 8)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @else
                                                <div
                                                    class=" flex flex-col gap-2 justify-center items-center max-w-[250px]">
                                                    <figure class="max-w-[150px]">
                                                        <img class="w-100" src="{{ asset('img/icons/file.png') }}">
                                                    </figure>
                                                    <p>{{ __('Archivo no Soportado') }}</p>
                                                    @if (strlen($item->getSize()) == 4)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 5)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 6)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 3) . ' ' . 'KB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 7)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 1) . ' ' . 'MB') }}
                                                        </p>
                                                    @elseif (strlen($item->getSize()) == 8)
                                                        <p>
                                                            {{ __(substr($item->getSize(), 0, 2) . ' ' . 'MB') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                            <button type="button" class=" absolute top-3 right-3"
                                                wire:click="removeMe({{ $loop->index }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                    class="w-6 h-6 text-slate-500" fill="CurrentColor">
                                                    <path
                                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 text-center mb-3">
                        <div class="row">
                            @if ($evidenciaArc)
                                <x-label value="{{ __('Archivos Almacenados') }}" />
                                <br>
                                <div class="flex flex-wrap gap-1 justify-center">
                                    @foreach ($evidenciaArc as $antigArch)
                                        @if ($antigArch->flag_trash == 0)
                                            <div
                                                class="col-3 flex flex-wrap gap-2 justify-center max-w-[300px] relative border p-2 shadow rounded-md">
                                                @if (
                                                    $antigArch->mime_type == 'image/png' ||
                                                        $antigArch->mime_type == 'image/jpg' ||
                                                        $antigArch->mime_type == 'image/jpeg' ||
                                                        $antigArch->mime_type == 'image/webp')
                                                    <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                        data-lightbox="imagenes-edit-{{ $antigArch->repuesto_id }}"
                                                        data-title="{{ $antigArch->nombre_archivo }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Visualizar">
                                                        <div class=" flex flex-col gap-2 justify-center items-center max-w-[150px]"
                                                            tabindex="0" data-bs-toggle="popover"
                                                            data-bs-trigger="hover focus"
                                                            data-bs-content="Presione para visualizar"
                                                            data-bs-placement="top">
                                                            <figure class="max-w-[100px]">
                                                                <img class="w-full"
                                                                    src="{{ asset('storage/' . $antigArch->archivo_path) }}">
                                                            </figure>
                                                            <p class=" text-sm">{{ $antigArch->nombre_archivo }}</p>
                                                            @if (strlen($antigArch->size) == 4)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 5)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 6)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 7)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 8)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @elseif ($antigArch->mime_type == 'application/pdf')
                                                    <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                        download="" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Visualizar">
                                                        <div class=" flex flex-col gap-2 justify-center items-center max-w-[150px]"
                                                            tabindex="0" data-bs-toggle="popover"
                                                            data-bs-trigger="hover focus"
                                                            data-bs-content="Presione para descargar"
                                                            data-bs-placement="top">
                                                            <figure class="max-w-[100px]">
                                                                <img class="w-full"
                                                                    src="{{ asset('img/icons/pdf.png') }}">
                                                            </figure>

                                                            <p> {{ $antigArch->nombre_archivo }} </p>
                                                            @if (strlen($antigArch->size) == 4)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 5)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 6)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 7)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 8)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @elseif ($antigArch->mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                    <a href="{{ asset('storage/' . $antigArch->archivo_path) }}"
                                                        download="" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Visualizar">
                                                        <div class=" flex flex-col gap-2 justify-center items-center max-w-[150px]"
                                                            tabindex="0" data-bs-toggle="popover"
                                                            data-bs-trigger="hover focus"
                                                            data-bs-content="Presione para descargar"
                                                            data-bs-placement="top">
                                                            <figure class="max-w-[100px]">
                                                                <img class="w-full"
                                                                    src="{{ asset('img/icons/word-2019.svg') }}">
                                                            </figure>
                                                            <p class=" text-sm"> {{ $antigArch->nombre_archivo }} </p>
                                                            @if (strlen($antigArch->size) == 4)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 5)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 6)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 3) . ' ' . 'KB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 7)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 1) . ' ' . 'MB') }}
                                                                </p>
                                                            @elseif (strlen($antigArch->size) == 8)
                                                                <p>
                                                                    {{ __(substr($antigArch->size, 0, 2) . ' ' . 'MB') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @endif
                                                <button type="button" class=" absolute top-3 right-3"
                                                    wire:click="removeArch({{ $antigArch->id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Doble click para Eliminar">
                                                    <span class="d-inline-block" tabindex="0"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="Doble click para Eliminar"
                                                        data-bs-placement="top">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                            class="w-6 h-6 text-slate-500 hover:text-red-500"
                                                            fill="CurrentColor">
                                                            <path
                                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                        </svg>
                                                    </span>
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
            <x-danger-button class="mr-2" wire:click="EditarRepuesto({{ $repuesto_id }})"
                wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('EditRepuesto')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
