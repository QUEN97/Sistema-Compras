<div
    class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
    <div class="w-full">
        <div class="mb-2">
            <form action="{{ route('almacenes') }}" method="GET" class=" flex flex-wrap gap-2">
				@if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 4)
                <div>
                    <span>{{ __('Buscar por Estación') }}</span>
                    <select id="filterAlma"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('filterAlma') ? 'is-invalid' : '' }}"
                        name="filterAlma" required aria-required="true">
                        <option value="Todas">Todas</option>
                        @foreach ($estas as $filtAlm)
                            <option value="{{ $filtAlm->id }}">{{ $filtAlm->name }}</option>
                        @endforeach
                    </select>
                </div>
				@else
				<div>
                    <span>{{ __('Buscar por Categoría') }}</span>
                    <select id="filterAlma"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('filterAlma') ? 'is-invalid' : '' }}"
                        name="filterAlma" required aria-required="true">
                        <option value="Todas">Todas</option>
                        @foreach ($categos as $filtAlm)
                            <option value="{{ $filtAlm->id }}">{{ $filtAlm->name }}</option>
                        @endforeach
                    </select>
                </div>
				@endif
                <div>
                    @if (Auth::user()->permiso_id == 3)
                        <div class="ml-2">
                            
                                <input type="text" name="s"
                                    class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                    placeholder="Buscar Por Producto..." />
                            
                        </div>
                        {{-- <div class="float-right">
                            <x-input type="text" wire:model="search" placeholder="Buscar Por Producto" />
                        </div> --}}
                    @else
                        <div class="ml-2">
                            
                                <input type="text" name="s"
                                    class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md focus:border-gray-500 focus:ring-gray-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                    placeholder="Buscar..." />
                                </div>
                                {{-- <div class="float-right">
                                    <x-input type="text" wire:model="search" placeholder="Buscar Por Estación..." />
                                </div> --}}
                            
                    @endif
                </div>
                <button type="submit" class="ml-4 py-2 px-4 bg-gray-400 text-white rounded-md ">Buscar</button>
            </form>
        </div>
        @if (Auth::user()->permiso_id != 3 || Auth::user()->permiso_id == 4)
            <table class="border-collapse w-full bg-white text-center text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                            Id</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                            Producto</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                            Imagen</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                            Estación</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                            Stock</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                            Status</th>
                        <th
                            class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                            Fecha</th>
                        @if (Auth::user()->permiso_id == 1)
                            <th
                                class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                                Opciones</th>
                        @elseif ($valid->pivot->vermas == 1 || $valid->pivot->de == 1)
                            <th
                                class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 border border-gray-300 dark:border-gray-800 hidden lg:table-cell">
                                Opciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100 dark:border-gray-800 ">
                    @forelse ($allmacen as $allma)
                            <tr
                                class="bg-white dark:bg-gray-600 lg:hover:bg-gray-100 dark:lg:hover:bg-gray-500 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Id</span>
                                    {{ $allma->id }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Producto</span>
                                    {{ $allma->producto->name }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Imagen</span>
                                    @if ($allma->imagen == null)
                                    <img class="rounded-full" name="photo"
                                            src="{{ asset('storage/product-photos/imagedefault.jpg') }}"
                                            style="height: 4rem;" />
                                    @else
                                        <img class="rounded-full" name="photo"
                                            src="{{ asset('storage/' . $allma->imagen) }}" style="height: 4rem;" />
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Estación</span>
                                    {{ $allma->estacion->name }}
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Stock</span>
                                    @if ($allma->stock <= 5)
                                        <div
                                            class="tooltip bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            {{ $allma->stock }}
                                            <span class="tooltiptext">Stock de producto bajo, se recomienda solicitar
                                                más producto</span>
                                            <div>
                                            @else
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                    {{ $allma->stock }}</span>
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Activo</span>
                                    @if ($allma->status == 'Activo')
                                        <div class="flex flex-wrap">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4 text-green-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                {{ $allma->status }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-wrap">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4 text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                {{ $allma->status }}
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td
                                    class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                    <span
                                        class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Fecha</span>
                                    {{ date('d-m-Y H:i:s', strtotime($allma->fecha)) }}
                                </td>
                                @if ($valid->pivot->vermas == 1 || $valid->pivot->de == 1 || $valid->pivot->ed == 1)
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 dark:text-white text-center border border-b  block lg:table-cell relative lg:static dark:border-gray-800">
                                        <span
                                            class="lg:hidden absolute top-0 left-0 bg-gray-300 px-1 py-1 text-xs font-bold uppercase">Opciones</span>
										<div style="display: flex; justify-content: center;">
                                        <div class="flex gap-2">
                                            <div>
                                                @if ($valid->pivot->vermas == 1)
                                                    {{-- @livewire('almacenes.ver-mas-almacen', ['almacen_show_id' => $allma->id], key('ver-mas-almacen-'.$allma->id)) --}}
                                                    <livewire:almacenes.ver-mas-almacen :almacen_show_id="$allma->id"
                                                        :wire:key="'ver-mas-almacen-'.$allma->id">
                                                @endif
                                            </div>

                                            <div>
                                                @if ($valid->pivot->ed == 1 && $allma->stock != 0)
                                                    {{-- @livewire('almacenes.ver-mas-almacen', ['almacen_show_id' => $allma->id], key('ver-mas-almacen-'.$allma->id)) --}}
                                                    <livewire:almacenes.almacen-edit :almacen_edit_id="$allma->id" :almacen_produ_id="$allma->produ"
                                                        :wire:key="'edit-almacen-'.$allma->id">
                                                @endif
                                            </div>

                                            <div>
                                                @if ($valid->pivot->de == 1)
                                                    @livewire('almacenes.almacen-delete', ['almaID' => $allma->id])
                                                @endif
                                            </div>
                                        </div>
											</div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="p-4" colspan="8">
                                    <span class="text-danger text-lg">
                                        <i class="nav-icon fa-regular fa-face-sad-tear"></i>
                                        {{ __('No se encuentra "' . $search . $filterAlma . '" en esta tabla...') }}
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        @endif

        @if (Auth::user()->permiso_id == 3)
            <div class="flex flex-wrap justify-center items-stretch gap-3">
                @foreach ($allmacen as $produc)
                    {{-- {{$gerent->producto}} --}}
                    <div class="flex flex-wrap justify-center items-stretch gap-3">
                        <div
                            class="shadow-lg group container  rounded-md bg-white dark.bg-gray400 max-w-sm flex justify-center items-center  mx-left content-div">
                            <div>
                                <div class="w-full image-cover rounded-t-md">
                                    @if ($produc->stock <= 5)
                                        <div
                                            class="p-3 m-4 w-18 h-18 text-center bg-red-700 rounded-full  text-white float-right fd-cl group-hover:opacity-25">
                                            <span class="text-xs tracking-wide  font-bold font-sans"> Solicitar</span>
                                            <span class="text-xs tracking-wide  font-bold font-sans block">+</span>
                                            <span
                                                class="text-xs tracking-wide font-bold block font-sans">Producto</span>
                                        </div>
                                    @endif
                                </div>
                                <div
                                    class="py-6 px-2 bg-white dark:bg-gray-400 rounded-b-md fd-cl group-hover:opacity-25">
                                    <span
                                        class="block text-lg text-gray-800 font-bold tracking-wide">{{ $produc->producto->name }}</span>
                                    <span class="invisible">Nombre del Producto</span>
                                    <span class="block text-gray-600 text-sm">
                                        @if ($produc->stock <= 5)
                                            <span
                                                class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                                {{ __(' Total de productos disponibles:') . ' ' . $produc->stock }}
                                            </span>
                                            <span class="invisible">Solicitar Productos</span>
                                        @else
                                            <span
                                                class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                {{ __(' Total de productos disponibles:') . ' ' . $produc->stock }}
                                            </span>
                                            <span class="invisible">No Solicitar Productos</span>
                                        @endif
                                        <div>
                                            {{ __('Fecha de registro:') . ' ' . $produc->fecha }}
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="absolute opacity-0 fd-sh group-hover:opacity-100 transition-[opacity] duration-300">
                                <div class="pt-6 text-center">
                                    @if ($valid->pivot->de == 1)
                                        @livewire('almacenes.almacen-delete', ['almaID' => $produc->id])
                                    @endif
                                </div>
                                <div class="pt-8 text-center">
                                    @if ($valid->pivot->vermas == 1)
                                        <div>
                                            @livewire('almacenes.ver-mas-almacen', ['almacen_show_id' => $produc->id])
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($produc->imagen == null)
                            <style>
                                .content-div {
                                    background-image: url('storage/product-photos/imagedefault.jpg');
                                    background-repeat: no-repeat;
                                    background-size: cover;
                                    background-position: center;
                                }

                                .content-div:hover {
                                    background-image:
                                        linear-gradient(to right,
                                            rgba(73, 72, 72, 0.658), hsla(0, 1%, 48%, 0.712)),
                                        url('storage/product-photos/imagedefault.jpg');
                                }

                                .image-cover {
                                    height: 260px;
                                }

                                .content-div:hover .fd-cl {
                                    opacity: 0.25;
                                    transition: 0.3s all;
                                }

                                .content-div:hover .fd-sh {
                                    opacity: 1;
                                }
                            </style>
                        @else
                            <style>
                                .content-div {
                                    background-image: url('storage/<?php echo $produc->imagen; ?>');
                                    background-repeat: no-repeat;
                                    background-size: cover;
                                    background-position: center;
                                }

                                .content-div:hover {
                                    background-image:
                                        linear-gradient(to right,
                                            rgba(73, 72, 72, 0.658), hsla(0, 1%, 48%, 0.712)),
                                        url('storage/<?php echo $produc->imagen; ?>');
                                }

                                .image-cover {
                                    height: 260px;
                                }

                                .content-div:hover .fd-cl {
                                    opacity: 0.25;
                                }

                                .content-div:hover .fd-sh {
                                    opacity: 1;
                                }
                            </style>
                        @endif
                @endforeach
            </div>
        @endif



        {{ $allmacen->links() }}
    </div>
</div>