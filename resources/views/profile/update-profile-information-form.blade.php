<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('INFORMACIÓN DE PERFIL') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualizar datos de información de perfil para: ') . Auth::user()->name }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photo" x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                " />

                <x-label for="photo" value="{{ __('Imagen') }}" />

                <!-- Current Profile Photo -->
                <div class="relative mt-2" x-show="! photoPreview">
                    @if (Auth::user()->profile_photo_path)
                        <img class="w-full object-cover rounded-md" style="width:520px"
                            src="/storage/{{ Auth::user()->profile_photo_path }}" alt="{{ Auth::user()->name }}" />
                        <button class="absolute top-0 bg-green-500  p-2 rounded hover:bg-green-300 m-2" type="button"
                            x-on:click.prevent="$refs.photo.click()"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 text-white hover:text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </button>
                        @if ($this->user->profile_photo_path)
                            <button type="button" class="absolute top-12 bg-red-500  p-2 rounded hover:bg-red-300 m-2"
                                wire:click="deleteProfilePhoto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-white hover:text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </button>
                        @endif
                    @else
                        <img class="w-full object-cover rounded-md" style="width:320px"
                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        <button class="absolute top-0 bg-green-500  p-2 rounded hover:bg-green-300 m-2" type="button"
                            x-on:click.prevent="$refs.photo.click()"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 text-white hover:text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block w-80 h-80 bg-center bg-no-repeat bg-cover "
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div>
            <!-- Rol Asignado -->
            <div class="col-span-6 sm:col-span-4 mb-2">
                <x-label for="rol" value="{{ __('Rol Asignado') }}" />
                <x-input id="rol" type="text"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                    autocomplete="rol" disabled value="{{ Auth::user()->permiso->titulo_permiso }}" />
                <x-input-error for="rol" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4 mb-2">
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-input id="name" type="text"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                    wire:model.defer="state.name" autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <!--  Username -->
            <div class="col-span-6 sm:col-span-4 mb-2">
                <x-label for="username" value="{{ __('Usuario') }}" />
                <x-input id="username" type="text"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                    wire:model.defer="state.username" autocomplete="username" />
                <x-input-error for="username" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4 mb-2">
                <x-label for="email" value="{{ __('Correo electronico') }}" />
                <x-input id="email" type="email"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm1 dark:border-gray-600 dark:bg-dark-eval-1
dark:text-gray-300 dark:focus:ring-offset-dark-eval-1"
                    wire:model.defer="state.email" />
                <x-input-error for="email" class="mt-2" />

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                        !$this->user->hasVerifiedEmail())
                    <p class="text-sm mt-2">
                        {{ __('Your email address is unverified.') }}

                        <button type="button" class="underline text-sm text-blue-600 hover:text-blue-700"
                            wire:click.prevent="sendEmailVerification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>
