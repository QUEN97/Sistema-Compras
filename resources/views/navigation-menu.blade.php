<nav aria-label="secondary" x-data="{ open: false }"
    class="sticky top-0 z-10 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white dark:bg-dark-eval-1"
    {{-- :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }" --}}>

    <div class="flex items-center gap-3">
        <x-button type="button" class="md:hidden" iconOnly variant="secondary" srText="Toggle dark mode"
            @click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>
    </div>

    <div class="flex items-center gap-3">
        <x-button type="button" class="hidden md:inline-flex" iconOnly variant="secondary" srText="Toggle dark mode"
            @click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" aria-hidden="true" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" aria-hidden="true" class="w-6 h-6" />
        </x-button>

               {{-- Notificaciones --}}
        <x-dropdown align="right" width="80">
            <x-slot name="trigger">
                @if (Auth::user()->unreadNotifications->count() == 0)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                @else
                    <div class="top-0 absolute left-3">
                        <p
                            class="flex h-2 w-2 items-center justify-center rounded-full bg-red-500 p-2 text-xs text-white">
                            {{ __(Auth::user()->unreadNotifications->count()) }} 
                        </p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 dark:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                @endif
            </x-slot>

            <x-slot name="content">
                <div class="block px-4 py-2 text-xs text-center text-gray-400">
                    @if (Auth::user()->unreadNotifications->count() == 1)
                        {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificación nueva') }}
                    @else
                        {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificaciones nuevas') }}
                    @endif
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                <div class="max-h-[320px] overflow-y-auto">
                    @if (auth()->user()->notifications->count())
                        <ul class="divide-y divide-gray-100">
                            @foreach (Auth::user()->notifications as $item)
                                @if ($item->type == 'App\Notifications\NotifiNewSolicitud')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('solicitudes') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                            </svg>
                                            {{ __('El Supervisor' . ' ' . '"' . $item->data['supervisor'] . '"' . ' ' . 'ha creado una nueva solicitud de productos con ID #' . $item->data['soliciId'] . ' en la Estación' . ' ' . '"' . $item->data['estacion']) }}
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiNewSolicitudGerente')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('solicitudes') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                            </svg>
                                            {{ __('El Gerente " ' . (isset($item->data['gerente']) ? $item->data['gerente'] : null) . ' " ha creado una nueva solicitud de productos con ID #' . $item->data['soliciId'] . ' en la Estación "' . $item->data['estacion']) }}
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiNewAdminSoli')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('solicitudes') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                            </svg>
                                            {{ __('"' . $item->data['userEs'] . ' " ' . ' ' . 'ha creado una solicitud con id #' . $item->data['soliciId'] . '  ' . 'para la estacion' . ' ' . $item->data['estacion']) }}
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiEditSolicitud')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('solicitudes') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                            </svg>
                                            {{ __('El Supervisor' . ' ' . '"' . $item->data['supervisor'] . '"' . ' ' . 'ha editado la solicitud' . ' ' . '#' . $item->data['soliNum'] . ' ' . 'en la Estación' . ' ' . '"' . $item->data['estacion']) }}
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiEditAdminSoli')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('solicitudes') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                            </svg>
                                            {{ __('"' . $item->data['userEs'] . ' " ' . ' ' . 'ha editado la solicitud con id #' . $item->data['soliNum'] . '  ' . 'de la estacion' . ' ' . $item->data['estacion']) }}
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiEditSolicitudGerente')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('solicitudes') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                            </svg>
                                            {{ __('El Gerente' . ' ' . '"' . (isset($item->data['gerente']) ? $item->data['gerente'] : null) . '"' . ' ' . 'ha editado la solicitud' . ' ' . '#' . $item->data['soliNum'] . ' ' . 'en la Estación' . ' ' . '"' . $item->data['estacion']) }}
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiNewAlmacenGerente')
                                    <div
                                        class="'block px-4 py-2 text-sm leading-5 text-gray-700  hover:text-gray-400 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:focus:text-white dark:focus:bg-dark-eval-3 dark:text-gray-400 dark:hover:text-gray-200 ">
                                        @if ($item->data['permiTie'] == 2)
                                            @if ($item->data['entradaSalida'] == 'Traspaso')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-5 h-5">
                                                    <path fill-rule="evenodd"
                                                        d="M13.2 2.24a.75.75 0 00.04 1.06l2.1 1.95H6.75a.75.75 0 000 1.5h8.59l-2.1 1.95a.75.75 0 101.02 1.1l3.5-3.25a.75.75 0 000-1.1l-3.5-3.25a.75.75 0 00-1.06.04zm-6.4 8a.75.75 0 00-1.06-.04l-3.5 3.25a.75.75 0 000 1.1l3.5 3.25a.75.75 0 101.02-1.1l-2.1-1.95h8.59a.75.75 0 000-1.5H4.66l2.1-1.95a.75.75 0 00.04-1.06z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <a href="{{ route('almacenes') }}"
                                                    wire:click="leerNoti({{ $item }})">{{ __('El Supervisor' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha solicitado un' . ' ' . $item->data['entradaSalida'] . ' ' . 'de productos en su bodega con Folio' . ' ' . '"' . $item->data['folio'] . '", Evidencia:') }}</a>

                                                <a href="{{ asset('storage/entradas-salidas-pdfs/' . $item->data['pdf']) }}"
                                                    target="_blank" class="">
                                                    {{ $item->data['pdf'] }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-3 h-3">
                                                        <path fill-rule="evenodd"
                                                            d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <div class="flex gap-20">
                                                    <span class="block text-sm text-blue-600">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($item->read_at != null)
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div class="text-sm">
                                                                {{ __('Leído') }}
                                                            </div>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5 text-blue-600">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <a
                                                    href="{{ route('almacenes') }}">{{ __('El Gerente' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha solicitado una' . ' ' . $item->data['entradaSalida'] . ' ' . 'de productos en su bodega con Folio' . ' ' . '"' . $item->data['folio'] . '", Evidencia:') }}</a>

                                                <a href="{{ asset('storage/entradas-salidas-pdfs/' . $item->data['pdf']) }}"
                                                    target="_blank" class="text-xs">
                                                    {{ $item->data['pdf'] }} <svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                        <path fill-rule="evenodd"
                                                            d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z"
                                                            clip-rule="evenodd" />
                                                        <path fill-rule="evenodd"
                                                            d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <div class="flex gap-20">
                                                    <span class="block text-sm text-blue-600">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($item->read_at != null)
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div class="text-sm">
                                                                {{ __('Leído') }}
                                                            </div>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5 text-blue-600">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd"
                                                    d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <a
                                                href="{{ route('almacenes') }}">{{ __('El Gerente' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha solicitado una' . ' ' . $item->data['entradaSalida'] . ' ' . 'de productos en su bodega con Folio' . ' ' . '"' . $item->data['folio'] . '", Evidencia:') }}</a>

                                            <a href="{{ asset('storage/entradas-salidas-pdfs/' . $item->data['pdf']) }}"
                                                target="_blank" class="text-bold text-xs">
                                                {{ $item->data['pdf'] }} <svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                    <path fill-rule="evenodd"
                                                        d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z"
                                                        clip-rule="evenodd" />
                                                    <path fill-rule="evenodd"
                                                        d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @elseif ($item->type == 'App\Notifications\NotifiAcepRechaAlmacen')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('almacenes') }}">
                                            @if ($item->data['permiTie'] == 2)
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('El Supervisor' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha ' . $item->data['acepRecha'] . ' la ' . $item->data['entradaSalida'] . ' #' . $item->data['entrasalID'] . ' con folio: "' . $item->data['folio'] . '" del producto "' . $item->data['produc'] . '" con ID #' . $item->data['epId']) }}
                                                <div class="flex gap-20">
                                                    <span class="block text-sm text-blue-600">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($item->read_at != null)
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div class="text-sm">
                                                                {{ __('Leído') }}
                                                            </div>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5 text-blue-600">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif ($item->data['permiTie'] != 2 && $item->data['permiTie'] != 3)
                                                @if ($item->data['entradaSalida'] == 'Traspaso')
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd"
                                                            d="M13.2 2.24a.75.75 0 00.04 1.06l2.1 1.95H6.75a.75.75 0 000 1.5h8.59l-2.1 1.95a.75.75 0 101.02 1.1l3.5-3.25a.75.75 0 000-1.1l-3.5-3.25a.75.75 0 00-1.06.04zm-6.4 8a.75.75 0 00-1.06-.04l-3.5 3.25a.75.75 0 000 1.1l3.5 3.25a.75.75 0 101.02-1.1l-2.1-1.95h8.59a.75.75 0 000-1.5H4.66l2.1-1.95a.75.75 0 00.04-1.06z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ __('"' . $item->data['userEs'] . '"' . ' ' . 'ha ' . $item->data['acepRecha'] . ' el ' . $item->data['entradaSalida'] . ' #' . $item->data['entrasalID'] . ' con folio: "' . $item->data['folio'] . '" del producto "' . $item->data['produc'] . '" con ID #' . $item->data['epId']) }}
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd"
                                                            d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ __('"' . $item->data['userEs'] . '"' . ' ' . 'ha ' . $item->data['acepRecha'] . ' la ' . $item->data['entradaSalida'] . ' #' . $item->data['entrasalID'] . ' con folio: "' . $item->data['folio'] . '" del producto "' . $item->data['produc'] . '" con ID #' . $item->data['epId']) }}
                                                @endif
                                            @endif
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiAcepRechaSolicitud')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link @class(['bg-blue-200' => !$item->read_at])
                                            href="{{ route('solicitudes') }}">
                                            @if ($item->data['permiTie'] == 2 && $item->data['acepRecha'] == 'Solicitado a Compras')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('El Supervisor' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha ' . $item->data['acepRecha'] . ' la solicitud #' . $item->data['soliciID']) }}
                                                <div class="flex gap-20">
                                                    <span class="block text-sm text-blue-600">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($item->read_at != null)
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div class="text-sm">
                                                                {{ __('Leído') }}
                                                            </div>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5 text-blue-600">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif ($item->data['acepRecha'] == 'Solicitud Rechazada')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('La solicitud #' . $item->data['soliciID'] . ' ha sido rechazada.') }}
                                                <div class="flex gap-20">
                                                    <span class="block text-sm text-blue-600">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($item->read_at != null)
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div class="text-sm">
                                                                {{ __('Leído') }}
                                                            </div>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5 text-blue-600">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif ($item->data['permiTie'] == 4 && $item->data['acepRecha'] == 'Enviado a Administración')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('"' . $item->data['userEs'] . '"' . ' ' . 'ha ' . $item->data['acepRecha'] . ' la solicitud #' . $item->data['soliciID']) }}
                                                <div class="flex gap-20">
                                                    <span class="block text-sm text-blue-600">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($item->read_at != null)
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div class="text-sm">
                                                                {{ __('Leído') }}
                                                            </div>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5 text-blue-600">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif ($item->data['acepRecha'] == 'Solicitud Aprobada')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('La solicitud #' . $item->data['soliciID'] . ' ha sido Aprobada.') }}
                                                <div class="flex gap-20">
                                                    <span class="block text-sm text-blue-600">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($item->read_at != null)
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div class="text-sm">
                                                                {{ __('Leído') }}
                                                            </div>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor"
                                                                class="w-5 h-5 text-blue-600">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiNewRepuesto')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('repuestos') }}">
                                            @if ($item->data['permiTie'] == 2)
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('El Supervisor' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha solicitado repuestos para "' . $item->data['produEs'] . '" para la estación "' . $item->data['estacEs'] . '" con ID #' . $item->data['esrepID']) }}
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('"' . $item->data['userEs'] . '"' . ' ' . 'ha solicitado repuestos para "' . $item->data['produEs'] . '" para la estación "' . $item->data['estacEs'] . '" con ID #' . $item->data['esrepID']) }}
                                            @endif
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiEditRepuesto')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('repuestos') }}">
                                            @if ($item->data['permiTie'] == 2)
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('El Supervisor' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha editado la solicitud repuestos de "' . $item->data['produEs'] . '" para la estación "' . $item->data['estacEs'] . '" con ID #' . $item->data['esrepID']) }}
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('"' . $item->data['userEs'] . '"' . ' ' . 'ha editado la solicitud repuestos de"' . $item->data['produEs'] . '" para la estación "' . $item->data['estacEs'] . '" con ID #' . $item->data['esrepID']) }}
                                            @endif
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @elseif ($item->type == 'App\Notifications\NotifiAcepRechaRepuesto')
                                    <li wire:click="leerNoti({{ $item }})" @class(['bg-blue-200' => !$item->read_at])>
                                        <x-dropdown-link href="{{ route('repuestos') }}">
                                            @if ($item->data['permiTie'] == 2 && $item->data['acepRecha'] == 'Solicitado a Compras')
                                                <img class="w-4" src="{{ asset('img/icons/icon-check.svg') }}"
                                                    alt="">
                                                {{ __('El Supervisor' . ' ' . '"' . $item->data['userEs'] . '"' . ' ' . 'ha ' . $item->data['acepRecha'] . ' el repuesto #' . $item->data['repuesID'] . ' del producto ' . $item->data['produEs']) }}
                                            @elseif ($item->data['permiTie'] != 2 && $item->data['permiTie'] != 3 && $item->data['acepRecha'] == 'Solicitado a Compras')
                                                <img class="w-4" src="{{ asset('img/icons/icon-check.svg') }}"
                                                    alt="">
                                                {{ __('"' . $item->data['userEs'] . '"' . ' ' . 'ha ' . $item->data['acepRecha'] . ' el repuesto #' . $item->data['repuesID'] . ' del producto ' . $item->data['produEs']) }}
                                            @elseif ($item->data['acepRecha'] == 'Repuesto Aprobado')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('La solicitud para el repuesto #' . $item->data['repuesID'] . ' ha sido aprobada por Compras.') }}
                                            @elseif ($item->data['acepRecha'] == 'Repuesto Rechazado')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('La solicitud para el repuesto #' . $item->data['repuesID'] . ' ha sido rechazada.') }}
                                            @endif
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                                @if ($item->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </x-dropdown-link>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <div>
                            <p align="center"><img src="{{ asset('img/logo/emptystate.svg') }}"
                                    style="max-width: 200px" alt="Sin notificaciones"></p>
                        </div>
                    @endif
                </div>
                @if (Auth::user()->unreadNotifications->count() >= 1)
                    <div class="block px-4 py-2 text-xs text-center text-gray-400">
                        @if (Auth::user()->unreadNotifications->count() == 1)
                            <button wire:click="readAllNotification({{ $item->notifiable_id }})"
                                class="text-xs justify-items-center content-center items-center text-gray-900 dark:text-white">Marcar
                                Como Leida</button>
                        @else
                            <button wire:click="readAllNotification({{ $item->notifiable_id }})"
                                class="text-xs justify-items-center content-center items-center text-gray-900 dark:text-white">Marcar
                                Como Leidas</button>
                        @endif
                    </div>
                @endif
            </x-slot>

        </x-dropdown>
        {{-- Notificaciones --}}

        <!-- Teams Dropdown -->
        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <x-dropdown align="right" width="60">
                <x-slot name="trigger">
                    <button type="button"
                        class="inline-flex items-center rounded-md p-2 text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring focus:ring-purple-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1 dark:text-gray-400 dark:hover:text-gray-200">
                        {{ Auth::user()->currentTeam->name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="w-60">
                        <!-- Team Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                            {{ __('Team Settings') }}
                        </x-dropdown-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-dropdown-link href="{{ route('teams.create') }}">
                                {{ __('Create New Team') }}
                            </x-dropdown-link>
                        @endcan

                        <div class="border-t border-gray-100 dark:border-gray-700"></div>

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" />
                        @endforeach
                    </div>
                </x-slot>
            </x-dropdown>
        @endif

        <!-- Settings Dropdown -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            @if (Auth::user()->profile_photo_path)
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="/storage/{{ Auth::user()->profile_photo_path }}"
                                    alt="{{ Auth::user()->name }}" />
                            @else
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            @endif
                        </button>
                        {{-- @else --}}
                        {{-- Here goes the span tag if you want quit the profile picture --}}
                        <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-white dark:hover:text-gray-300 bg-white dark:bg-transparent hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                            {{ Auth::user()->name }}

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                </span>
                @endif
            </x-slot>

            <x-slot name="content">
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Administrar Cuenta') }}
                </div>

                <x-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Perfil') }}
                </x-dropdown-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                        {{ __('API Tokens') }}
                    </x-dropdown-link>
                @endif

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
