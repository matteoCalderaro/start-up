<div  x-data="{isOpen : false}" class="relative" >
    <button @click=
        "isOpen = !isOpen
        if(isOpen){
            Livewire.emit('getNotifications')
        }
    ">
        <svg class="h-8 w-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
        </svg>
        @if ($notificationCount)
            <div class="absolute rounded-full bg-red text-white text-xxs w-6 h-6 flex items-center justify-center border-2 -top-1 -right-1">{{ $notificationCount }}</div>
        @endif
    </button>
    <ul
        x-show="isOpen" x-transition.origin.top
        x-cloak
        @click.away="isOpen = false"
        @keydown.escape.window="isOpen = false"
        class="absolute w-76 md:w-96 text-left bg-white shadow-dialog rounded-xl z-10 text-sm max-h-128 overflow-y-auto text-gray-700 md:-right-12 -right-28"
    >
        @if ($notifications->isNotEmpty() && ! $isLoading)
            @foreach ($notifications as $notification)
                <li>
                    <a
                        href="{{ route('idea.show', $notification->data['idea_slug'] )}}"
                        {{-- @click.prevent="
                            isOpen = false
                        " --}}
                        class="flex hover:bg-gray-100 transition duration-150 ease-in px-5 py-3"
                    >
                    <img src="{{ $notification->data['user_avatar'] }}" alt="" class="w-10 h-10 rounded-full">
                    <div class="ml-4">
                        <div class="line-clamp-6">
                                <span class="font-semibold">{{ $notification->data['user_name'] }}</span>
                                comment on
                                <span class="font-semibold">{{ $notification->data['idea_title'] }}</span>:
                                <span>"{{ $notification->data['comment_body'] }}"</span>
                            </div>
                        <div class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                    </a>
                </li>
            @endforeach
            <li class="border-t border-gray-300 text-center">
                <button
                class="w-full block font-semibold hover:bg-gray-100 transition duration-150 ease-in px-5 py-4"
                >
                Mark all as read
                </button>
            </li>
        @elseif ($isLoading)
            @foreach (range(1,3) as $item)
                <li class="animate-pulse flex items-center transition duration-150 ease-in px-5 py-4">
                    <div class="bg-gray-400 rounded-xl w-10 h-10"></div>
                    <div class="ml-4 flex-1 space-y-2">
                        <div class="bg-gray-400 w-full rounded h-4"></div>
                        <div class="bg-gray-400 w-full rounded h-4"></div>
                        <div class="bg-gray-400 w-1/2 rounded h-4"></div>
                    </div>
                </li>
            @endforeach
        @else
            <li class="mx-auto w-40 py-6">
                <img src="{{ asset('img/no-ideas.svg')}}" alt="No Ideas" class="mx-auto" style="mix-blend-mode:luminosity">
                <div class="text-gray-400 text-center font-bold mt-7">
                    No new notifications
                </div>
            </li>
        @endif




    </ul>
</div>