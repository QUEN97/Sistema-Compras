<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight bg-black text-white dark:bg-dark-eval-3 p-2 rounded-lg">
                {{ $greeting }}
            </h2>

            @if ($valid->pivot->wr == 1)
            @livewire('dashboard.generate-reporte')
            @endif 
        </div>
    </x-slot>
    <div class="flex flex-wrap justify-center items-center gap-3 py-3">
        @if ($user->permiso_id == '1' || $user->permiso_id == '4')
            <div class="p-2 w-full">
                <div class="w-full">
                    <div class="flex flex-wrap justify-center gap-5">
                        <div
                            class=" flex items-center max-w-[280px] justify-between gap-3 p-3 shadow rounded-lg bg-white dark:bg-dark-eval-1 max-[400px]:w-full max-[400px]:justify-evenly">
                            <div class="bg-red-700 dark:bg-dark-eval-3 rounded-full flex justify-center items-center p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-gray-900 dark:text-white text-lg font-bold">Empleados</h2>
                                <h3 class=" text-xl text-center font-bold text-gray-500 dark:text-white ">
                                    {{ $totUsers }}</h3>
                                <p class="text-sm text-center font-semibold text-gray-400 dark:text-white">Registros</p>
                            </div>
                        </div>
                        <div
                            class=" flex items-center max-w-[280px] justify-between gap-3 p-3 shadow rounded-lg bg-white dark:bg-dark-eval-1 max-[400px]:w-full max-[400px]:justify-evenly">
                            <div class="bg-red-700 dark:bg-dark-eval-3 rounded-full flex justify-center items-center p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-gray-900 text-lg font-bold dark:text-white">Zonas</h2>
                                <h3 class=" text-xl text-center font-bold text-gray-500 dark:text-white ">
                                    {{ $totZonas }}</h3>
                                <p class="text-sm text-center font-semibold text-gray-400 dark:text-white">Registros</p>
                            </div>
                        </div>
                        <div
                            class=" flex items-center max-w-[280px] justify-between gap-3 p-3 shadow rounded-lg bg-white dark:bg-dark-eval-1 max-[400px]:w-full max-[400px]:justify-evenly">
                            <div class="bg-red-700 dark:bg-dark-eval-3 rounded-full flex justify-center items-center p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-gray-900 text-lg font-bold dark:text-white">Estaciones</h2>
                                <h3 class=" text-xl text-center font-bold text-gray-500 dark:text-white ">
                                    {{ $totEstas }}</h3>
                                <p class="text-sm text-center font-semibold text-gray-400 dark:text-white">Registros</p>
                            </div>
                        </div>
                        <div
                            class=" flex items-center max-w-[280px] justify-between gap-3 p-3 shadow rounded-lg bg-white dark:bg-dark-eval-1 max-[400px]:w-full max-[400px]:justify-evenly">
                            <div class="bg-red-700 dark:bg-dark-eval-3 rounded-full flex justify-center items-center p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-gray-900 text-lg font-bold dark:text-white">Categorias</h2>
                                <h3 class=" text-xl text-center font-bold text-gray-500 dark:text-white ">
                                    {{ $totCates }}</h3>
                                <p class="text-sm text-center font-semibold text-gray-400 dark:text-white">Registros</p>
                            </div>
                        </div>
                        <div
                            class=" flex items-center max-w-[280px] justify-between gap-3 p-3 shadow rounded-lg bg-white dark:bg-dark-eval-1 max-[400px]:w-full max-[400px]:justify-evenly">
                            <div class="bg-red-700 dark:bg-dark-eval-3 rounded-full flex justify-center items-center p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-gray-900 text-lg font-bold dark:text-white">Productos</h2>
                                <h3 class=" text-xl text-center font-bold text-gray-500 dark:text-white ">
                                    {{ $totProds }}</h3>
                                <p class="text-sm text-center font-semibold text-gray-400 dark:text-white">Registros</p>
                            </div>
                        </div>
                        <div
                            class=" flex items-center max-w-[280px] justify-between gap-3 p-3 shadow rounded-lg bg-white dark:bg-dark-eval-1 max-[400px]:w-full max-[400px]:justify-evenly">
                            <div class="bg-red-700 dark:bg-dark-eval-3 rounded-full flex justify-center items-center p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-gray-900 text-lg font-bold dark:text-white">Solicitudes</h2>
                                <h3 class=" text-xl text-center font-bold text-gray-500 dark:text-white ">
                                    {{ $totSolis }}</h3>
                                <p class="text-sm text-center font-semibold text-gray-400 dark:text-white">Registros</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div>
            @livewire('dashboard.dashboard-charts')
        </div>
        
    </div>
</x-app-layout>
