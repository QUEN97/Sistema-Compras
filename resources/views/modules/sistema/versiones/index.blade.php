<x-app-layout>
    @section('title', 'Versiones')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Versiones del sistema') }}
            </h2>
            @if (Auth::user()->id == 1 || Auth::user()->email == 'desarrollo@fullgas.com.mx')
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                @livewire('sistema.versiones.new-version')
                @livewire('sistema.versiones.user-comments')
            </div>
            @else
                @auth
                @livewire('sistema.versiones.comment-form')
                @endauth
            @endif
        </div>
    </x-slot>

    @livewire('sistema.versiones.table-versiones')

</x-app-layout>
