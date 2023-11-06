<div>
    <x-button wire:click="$set('usercomment',true)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
        </svg>
        <span>{{ $comments->count() }}</span>
    </x-button>

    <x-dialog-modal wire:model="usercomment" class="flex items-center" >

        <x-slot name="title">
            <span>Comentarios</span>
        </x-slot>
        <x-slot name="content">
            @if ($comments->count() > 0)
                <ul class="flex flex-col items-center max-h-[320px] overflow-y-auto" >
                    @foreach ($comments as $comment)
                        <li>
                            <a
                                class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none">
                                <img class="object-cover w-10 h-10 rounded-full"
                                    src="{{ asset('img/logo/blank-profile-picture-973460_1280.webp') }}"
                                    alt="username" />
                                <div class="w-full pb-2">
                                    <div class="flex justify-between">
                                        <span
                                            class="block ml-2 font-semibold text-gray-600 dark:text-white">{{ $comment->user->name }}</span>
                                        <span
                                            class="block ml-2 text-xs text-gray-600 dark:text-white">{{ $comment->created_at->format('M d, Y H:i a') }}</span>
                                    </div>
                                    <span class="block ml-2 text-sm text-gray-600 dark:text-white">{{ $comment->content }}</span>
                                </div>
                                <button wire:click="DeleteComment({{ $comment->id }})"
                                    class="p-2 text-gray-500 hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5 text-red-500">
                                        <path fill-rule="evenodd"
                                            d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="mt-2 p-4 " style="display: flex; justify-content: center;">
                    <img src="{{ asset('img/logo/buzon.png') }}" style="max-width: 150px" alt="Sin Comentarios">
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('usercomment',false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

</div>
