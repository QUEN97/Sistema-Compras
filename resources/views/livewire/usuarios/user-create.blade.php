<div>
    <x-button
        class="float-right  text-gray-100 dark:bg-gray-700 "
        wire:click="showModalFormUsuario">
        <i class="fa-solid fa-user-plus"></i>
        {{ __('Nuevo Usuario') }}
    </x-button>

    <x-dialog-modal wire:model="newgUsuario" id="modalUsuario" class="flex items-center">
        <x-slot name="title">
            Nuevo Usuario
        </x-slot>

        <x-slot name="content">
            <div class="bg-white  shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Nombre') }}" />
                        <x-input wire:model.defer="name"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('name') ? 'is-invalid' : '' }}"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Usuario') }}" />
                        <x-input wire:model.defer="username"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('username') ? 'is-invalid' : '' }}"
                            type="text" name="username" :value="old('username')" required autofocus
                            autocomplete="username" />
                        <x-input-error for="username"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-full px-3">
                        <x-label value="{{ __('Correo Electrónico') }}" />
                        <x-input wire:model.defer="email"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            type="email" name="email" :value="old('email')" required />
                        <x-input-error for="email"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Rol') }}" />
                        <select id="permiso" wire:model="permiso"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ $errors->has('permiso') ? 'is-invalid' : '' }}"
                            name="permiso" required aria-required="true">
                            <option hidden value="" selected>Seleccionar Rol</option>
                            @foreach ($permisos as $permiso)
                                <option value="{{ $permiso->id }}">{{ $permiso->titulo_permiso }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="permiso"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3" wire:ignore>
                        <x-label value="{{ __('Zona') }}" />
                        <select id="select2" name="zonasList[ ]"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                            multiple="multiple">
                            @foreach ($zonas as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="zona"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Contraseña') }}" />
                        <x-input wire:model.defer="password"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            type="password" name="password" required autocomplete="new-password"
                            wire:keydown.enter="addUsuario" />
                        <x-input-error for="password"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Confirmar Contraseña') }}" />
                        <x-input
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                        dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            type="password" wire:model.defer="password_confirmation" name="password_confirmation"
                            required autocomplete="new-password" wire:keydown.enter="addUsuario" />
                        <x-input-error for="password_confirmation"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="addUsuario" wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('newgUsuario')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    <script>
        $('#select2').select2({
            placeholder: "Seleccionar zona(s)...",
            allowClear: true
        }).on('change', function() {
            @this.set('zonasList', $(this).val());
        });
    </script>

</div>
