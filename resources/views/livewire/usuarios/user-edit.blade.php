<div class="" id="">

    <button wire:click="confirmUserEdit({{ $user_edit_id }})" wire:loading.attr="disabled" class="tooltip"
        data-target="EditUsuario{{ $user_edit_id }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-300">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        <span class="tooltiptext">Editar</span>
    </button>

    <x-dialog-modal wire:model="EditUsuario" id="EditUsuario{{ $user_edit_id }}" class="flex items-center">
        <x-slot name="title">
           <span class="dark:text-white"> {{ __('Editar Usuario') }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="bg-white dark:bg-gray-600 shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Nombre') }}" />
                        <x-input wire:model="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                            name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error for="name"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Usuario') }}" />
                        <x-input wire:model.defer="username" class="{{ $errors->has('username') ? 'is-invalid' : '' }}"
                            type="text" name="username" :value="old('username')" required autofocus
                            autocomplete="username" />
                        <x-input-error for="username"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-full px-3">
                        <x-label value="{{ __('Correo Electrónico') }}" />
                        <x-input wire:model.defer="email" class="w-full{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            type="email" name="email" :value="old('email')" required />
                        <x-input-error for="email"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Rol') }}" />
                        <select id="role" wire:model="role"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 {{ $errors->has('role') ? 'is-invalid' : '' }}"
                            name="role" required aria-required="true">
                            @foreach ($permisos as $permisol)
                                <option value="{{ $permisol->id }}"
                                    @if ($role == $permisol->id) {{ 'selected' }} @endif>
                                    {{ $permisol->titulo_permiso }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="role"></x-input-error>
                    </div>
                    <div class="mb-3 col-6">
                        <x-label value="{{ __('Zona') }}" />
                        <div class="max-h-[100px] min-w-[120px] overflow-y-auto">
                            @foreach ($zonas as $tag)
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="zonasUpdate" value="{{ $tag->id }}" name="names[]" id="{{ $tag->name }}">
                                    <label for="{{ $tag->name }}">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error for="zona"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Status') }}" />
                        <select id="status" wire:model="status"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
                            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1{{ $errors->has('status') ? 'is-invalid' : '' }}"
                            name="status" required aria-required="true">
                            <option hidden value="">Seleccionar Status</option>
                            <option value="Activo" @if ($status == 'Activo') {{ 'selected' }} @endif>
                                Activo</option>
                            <option value="Inactivo" @if ($status == 'Inactivo') {{ 'selected' }} @endif>
                                Inactivo</option>
                        </select>
                        <x-input-error for="status"></x-input-error>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-2">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label value="{{ __('Contraseña') }}" />
                        <x-input wire:model="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            type="password" name="password" required autocomplete="new-password"
                            wire:keydown.enter="addUsuario" />
                        <x-input-error for="password"></x-input-error>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <x-label value="{{ __('Confirmar Contraseña') }}" />
                        <x-input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            type="password" wire:model="password_confirmation" name="password_confirmation" required
                            autocomplete="new-password" wire:keydown.enter="addUsuario" />
                        <x-input-error for="password_confirmation"></x-input-error>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-danger-button class="mr-2" wire:click="EditarUsuario({{ $user_edit_id }})"
                wire:loading.attr="disabled">
                Aceptar
            </x-danger-button>

            <x-secondary-button wire:click="$toggle('EditUsuario')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
