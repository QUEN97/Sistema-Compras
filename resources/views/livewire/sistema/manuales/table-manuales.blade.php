<div class="grid grid-cols-2 gap-4">
    @if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3)
        @foreach ($manuals as $item)
            <div
                class="mx-left mt-2 w-80 transform overflow-hidden rounded-lg bg-white shadow-md  hover:shadow-lg">
                <a href="{{ asset('storage/' . $item->manual_path) }}" target="_blank">
                    <img class="w-full object-cover object-center" src="{{ asset('img/icons/pdf.png') }}"
                        alt="Manual del Sistema" />
                </a>

                @if ($valid->pivot->de == 1)
                    @livewire('sistema.manuales.manual-delete', ['manID' => $item->id])
                @endif

                <div class="p-4">
                    <h2 class="mb-2 text-lg font-medium dark:text-white text-gray-900">
                        {{ __($item->panel->titulo_panel) }}
                    </h2>
                    <p class="mb-2 text-base dark:text-gray-300 text-gray-700">
                        <a class="text-sm text-red-500 no-underline hover:underline hover:text-red-700"
                            href="{{ asset('storage/' . $item->manual_path) }}" target="_blank">
                            {{ __($item->titulo_manual . ' (') }}
                            @if (strlen($item->size) == 3)
                                {{ __(substr($item->size, 0, 2) . ' ' . 'KB )') }}
                            @elseif (strlen($item->size) == 4)
                                {{ __(substr($item->size, 0, 1) . ' ' . 'KB )') }}
                            @elseif (strlen($item->size) == 5)
                                {{ __(substr($item->size, 0, 2) . ' ' . 'KB )') }}
                            @elseif (strlen($item->size) == 6)
                                {{ __(substr($item->size, 0, 3) . ' ' . 'KB )') }}
                            @elseif (strlen($item->size) == 7)
                                {{ __(substr($item->size, 0, 1) . ' ' . 'MB )') }}
                            @elseif (strlen($item->size) == 8)
                                {{ __(substr($item->size, 0, 2) . ' ' . 'MB )') }}
                            @endif
                        </a>
                    </p>
                    <span class="mb-3">
                        @foreach ($item->permisos as $ite)
                            <span
                                class="bg-green-100 text-green-500 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-gray-900 dark:text-gray-300">
                                {{ __($ite->titulo_permiso) }} </span>
                        @endforeach
                    </span>
                    <div class="flex items-center mt-3">
                        {{-- <p class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">$20.00</p> --}}
                        {{-- <p class="text-base  font-medium text-gray-500 line-through dark:text-gray-300">$25.00</p> --}}
                        <p class="ml-auto font-medium text-xs text-gray-500">{{ $item->created_at }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @foreach ($manuals as $tem)
            @foreach ($tem->permisos as $item)
                @if ($item->pivot->permiso_id == Auth::user()->permiso_id)
                    <div
                        class="mx-left mt-2 w-80 transform overflow-hidden rounded-lg bg-white dark:bg-dark-eval-1 shadow-md  hover:shadow-lg">
                        <a href="{{ asset('storage/' . $tem->manual_path) }}" target="_blank">
                            <img class="w-full object-cover object-center" src="{{ asset('img/icons/pdf.png') }}"
                                alt="Manual del Sistema" />
                        </a>

                        <div class="p-4">
                            <h2 class="mb-2 text-lg font-medium dark:text-white text-gray-900">
                                {{ __($tem->panel->titulo_panel) }}
                            </h2>
                            <p class="mb-2 text-base dark:text-gray-300 text-gray-700">
                                <a class="text-sm text-red-500 no-underline hover:underline hover:text-red-700"
                                    href="{{ asset('storage/' . $tem->manual_path) }}" target="_blank">
                                    {{ __($tem->titulo_manual . ' (') }}
                                    @if (strlen($tem->size) == 3)
                                        {{ __(substr($tem->size, 0, 2) . ' ' . 'KB )') }}
                                    @elseif (strlen($tem->size) == 4)
                                        {{ __(substr($tem->size, 0, 1) . ' ' . 'KB )') }}
                                    @elseif (strlen($tem->size) == 5)
                                        {{ __(substr($tem->size, 0, 2) . ' ' . 'KB )') }}
                                    @elseif (strlen($tem->size) == 6)
                                        {{ __(substr($tem->size, 0, 3) . ' ' . 'KB )') }}
                                    @elseif (strlen($tem->size) == 7)
                                        {{ __(substr($tem->size, 0, 1) . ' ' . 'MB )') }}
                                    @elseif (strlen($tem->size) == 8)
                                        {{ __(substr($tem->size, 0, 2) . ' ' . 'MB )') }}
                                    @endif
                                </a>
                            </p>
                            <span class="mb-3">
                                @foreach ($tem->permisos as $ite)
                                    <span
                                        class="bg-green-100 text-green-500 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-dark-eval-3 dark:text-gray-300">
                                        {{ __($ite->titulo_permiso) }} </span>
                                @endforeach
                            </span>
                            <div class="flex items-center mt-3">
                                {{-- <p class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">$20.00</p> --}}
                                {{-- <p class="text-base  font-medium text-gray-500 line-through dark:text-gray-300">$25.00</p> --}}
                                <p class="ml-auto font-medium text-xs text-gray-500 dark:text-white">{{ $item->created_at }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach
    @endif
    <x-confirmation-modal wire:model="confirmingManuDeletion">
        <x-slot name="title">
            {{ __('Eliminar') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Está seguro que desea eliminar el manual?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingManuDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteManu ({{ $confirmingManuDeletion }})"
                wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
