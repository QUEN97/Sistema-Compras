<x-app-layout>
    @section('title', 'Usuarios Eliminados')
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Usuarios Eliminados') }}
            </h2>
        </div>
    </x-slot>
    <div class="content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-xl sm:rounded-lg">
                    {{-- inicio tabla usuarios --}}
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-800 shadow-md m-5 mt-12">
                        <table class="border-collapse w-full bg-white text-center text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-800 hidden lg:table-cell"">
                                        Nombre</th>
                                    <th
                                        class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-800 hidden lg:table-cell"">
                                        Email</th>
                                    {{-- <th class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-800 hidden lg:table-cell"">Status</th> --}}
                                    <th
                                        class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-800 hidden lg:table-cell"">
                                        Eliminado</th>
                                    <th
                                        class=" p-3 font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-800 hidden lg:table-cell"">
                                        Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @if (count($trashed) > 0)
                                    @foreach ($trashed as $user)
                                        <tr
                                            class="bg-white dark:bg-gray-600 lg:hover:bg-gray-100 dark:lg:hover:bg-gray-500 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                            <td
                                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                                <span
                                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                                <div class="text-sm">
                                                    <div class="font-medium text-gray-700">{{ $user->name }}</div>
                                                    <div class="text-gray-400">{{ $user->role }}</div>
                                                </div>
                                            </td>
                                            <td
                                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                                <span
                                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                                {{ $user->email }}
                                            </td>
                                            {{-- <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                            @if ($user->status == 'Activo')
                            <span class="rounded bg-green-200 py-1 px-3 text-xs text-green-500 font-bold">{{$user->status}}</span>
                            @else
                            <span class="rounded bg-red-200 py-1 px-3 text-xs text-red-500 font-bold">{{$user->status}}</span>
                            @endif
                          </td> --}}
                                            <td
                                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                                <span
                                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Eliminado</span>
                                                {{ $user->deleted_at }}
                                            </td>
                                            <td
                                                class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800">
                                                <span
                                                    class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Opciones</span>
                                                <div class="grid grid-cols-1">
                                                    <div>
                                                        {{-- restaurar --}}
                                                        @if ($valid->pivot->restpap == 1)
                                                        <form method="POST" action="{{ route('user_restore') }}"
                                                            onsubmit="return confirm('Restaurar Usuario');">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id"
                                                                value="{{ $user->id }}" required />
                                                            <button type="submit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor"
                                                                    class="w-6 h-6 text-gray-400 hover:text-green-800">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                    {{-- <div>
                                                        
                                                        <form method="POST"
                                                            action="{{ route('deleteuser_permanently') }}"
                                                            onsubmit="return confirm('Eliminar de manera permanente al usuario);">

                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="id"
                                                                value="{{ $user->id }}" required />
                                                            <button type="submit">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="w-5 h-5 text-gray-400 hover:text-red-500">
                                                                    <path fill-rule="evenodd"
                                                                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static dark:border-gray-800 dark:bg-gray-600"
                                            colspan="4">
                                            <span
                                                class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Sin
                                                registros</span>
                                           <span class="dark:text-gray-400"> {{ __('No hay usuarios eliminados') }}</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-2 ml-2 mb-2">
                            <a class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-600 dark:text-white  rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500   active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"
                                href="{{ route('users') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    {{-- fin tabla usuarios --}}
                </div>
            </div>
        </div>
</x-app-layout>
