@php
    $valid = Auth::user()->permiso->panels;
    
    $modul = 'hidden';
    
    $produc = 'hidden';
    
    $sistem = 'hidden';
    
    foreach ($valid as $permis) {
        for ($i = 4; $i <= 7; $i++) {
            if ($permis->pivot->re == 1 && $permis->pivot->panel_id == $i) {
                $modul = 'block';
            }
        }
    
        for ($i = 8; $i <= 9; $i++) {
            if ($permis->pivot->re == 1 && $permis->pivot->panel_id == $i) {
                $produc = 'block';
            }
        }
    }
@endphp
<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @foreach ($valid as $item)
        @if ($item->pivot->panel_id == 1 && $item->pivot->re == 1)
            <x-sidebar.link title="Solicitudes" href="{{ route('solicitudes') }}" :isActive="request()->routeIs('solicitudes')">
                <x-slot name="icon">
                    <x-icons.solicitudes class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.link>
        @endif
    @endforeach

    @foreach ($valid as $item)
        @if ($item->pivot->panel_id == 2 && $item->pivot->re == 1)
            <x-sidebar.link title="Almacenes" href="{{ route('almacenes') }}" :isActive="request()->routeIs('almacenes')">
                <x-slot name="icon">
                    {{-- <x-icons.almacen class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> --}}
                    <svg class="flex-shrink-0 w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"></path>
                      </svg>
                </x-slot>
            </x-sidebar.link>
        @endif
    @endforeach
    @foreach ($valid as $item)
        @if ($item->pivot->panel_id == 3 && $item->pivot->re == 1)
            <x-sidebar.link title="Repuestos" href="{{ route('repuestos') }}" :isActive="request()->routeIs('repuestos')">
                <x-slot name="icon">
                    <x-icons.repuesto class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.link>
        @endif
    @endforeach

    {{-- Modúlos --}}
    <div class="{{ $modul }}">
        <x-sidebar.dropdown title="Modúlos" :active="Str::startsWith(
            request()
                ->route()
                ->uri(),
            'buttons',
        )">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            @foreach ($valid as $item)
                @if ($item->pivot->panel_id == 4 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Usuarios" href="{{ route('users') }}" :active="request()->routeIs('users')" />
                @endif
                @if ($item->pivot->panel_id == 5 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Roles" href="{{ route('roles') }}" :active="request()->routeIs('roles')" />
                @endif
                @if ($item->pivot->panel_id == 6 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Zonas" href="{{ route('zonas') }}" :active="request()->routeIs('zonas')" />
                @endif
                @if ($item->pivot->panel_id == 7 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Estaciones" href="{{ route('estaciones') }}" :active="request()->routeIs('estaciones')" />
                @endif
            @endforeach
        </x-sidebar.dropdown>
    </div>

    {{-- Productos --}}
    <div class="{{ $produc }}">
        <x-sidebar.dropdown title="Productos" :active="Str::startsWith(
            request()
                ->route()
                ->uri(),
            'buttons',
        )">
            <x-slot name="icon">
                <svg class="flex-shrink-0 w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"></path>
                  </svg>
                {{-- <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> --}}
            </x-slot>
            @foreach ($valid as $item)
                @if ($item->pivot->panel_id == 8 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Facturas" href="{{ route('facturas') }}" :active="request()->routeIs('facturas')" />
                @endif
                @if ($item->pivot->panel_id == 8 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Proveedores" href="{{ route('proveedores') }}" :active="request()->routeIs('proveedores')" />
                @endif
                @if ($item->pivot->panel_id == 9 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Categorías" href="{{ route('categorias') }}" :active="request()->routeIs('categorias')" />
                @endif
                @if ($item->pivot->panel_id == 8 && $item->pivot->re == 1)
                    <x-sidebar.sublink title="Productos" href="{{ route('productos') }}" :active="request()->routeIs('productos')" />
                @endif
            @endforeach
        </x-sidebar.dropdown>
    </div>

    {{-- Sistema --}}
    <x-sidebar.dropdown title="Sistema" :active="Str::startsWith(
        request()
            ->route()
            ->uri(),
        'buttons',
    )">
        <x-slot name="icon">
            {{-- <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> --}}
            <svg class="flex-shrink-0 w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></path>
              </svg>
        </x-slot>

        @foreach ($valid as $item)
            @if ($item->pivot->panel_id == 10 && $item->pivot->re == 1)
                <x-sidebar.sublink title="Manuales" href="{{ route('manuales') }}" :active="request()->routeIs('manuales')" />
            @endif
        @endforeach
        <x-sidebar.sublink title="Versiones" href="{{ route('versiones') }}" :active="request()->routeIs('versiones')" />
        
    </x-sidebar.dropdown>

</x-perfect-scrollbar>
