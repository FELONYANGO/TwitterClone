<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- create a success session before the form  -->
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ __('Success!') }}</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <!-- making the session disappear after a few seconds -->
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.remove()" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>{{ __('Close') }}</title>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.95 5.05a.75.75 0 011.06 1.06L11.06 12l4.95 4.95a.75.75 0 11-1.06 1.06L10 13.06l-4.95 4.95a.75.75 0 01-1.06-1.06L8.94 12 4.05 7.05a.75.75 0 011.06-1.06L10 10.94l4.95-4.95z"></path>
                </svg>
        </div>
        @endif
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea name="message" placeholder="{{ __('What\'s on your mind?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
        </form>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

            @forelse ($chirps as $chirp)

            <div class="p-6 flex space-x-2">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />

                </svg>

                <div class="flex-1">

                    <div class="flex justify-between items-center">

                        <div>

                            <span class="text-gray-800">{{ $chirp->user->name }}</span>

                            <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->diffForHumans() }}</small>
                            @unless ($chirp->created_at->eq($chirp->updated_at))

                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>

                            @endunless
                        </div>
                        @if ($chirp->user->is(auth()->user()))

                        <x-dropdown>

                            <x-slot name="trigger">

                                <button>

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">

                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />

                                    </svg>

                                </button>

                            </x-slot>

                            <x-slot name="content">

                                <x-dropdown-link :href="route('chirps.edit', $chirp)">

                                    {{ __('Edit') }}

                                </x-dropdown-link>
                                <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">

                                    @csrf

                                    @method('delete')

                                    <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">

                                        {{ __('Delete') }}

                                    </x-dropdown-link>

                                </form>

                            </x-slot>

                        </x-dropdown>

                        @endif
                    </div>

                    <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>

                </div>

            </div>
            @empty

            <div class="p-6 text-center text-gray-600">

                <p>{{ __('No chirps yet.') }}</p>

            </div>
            @endforelse

        </div>
       
    </div>
</x-app-layout>