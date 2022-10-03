<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('general.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Message success --}}
                    @if(session()->has('message'))
                        <div class="p-4 mb-4 text-lg font-medium text-center text-green-600 bg-green-100 rounded-lg">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <h1 class="mb-3 text-3xl">
                        {{ __('general.type_your_link') }}
                    </h1>

                    <form method="POST" action="{{ route('links.store') }}">
                        @csrf

                        <!-- Link -->
                        <div>
                            <x-input-label for="link" :value="__('attributes.link')" />

                            <x-text-input id="link" class="block mt-1 w-full" type="url" name="origin_link" :value="old('origin_link')" required autofocus />

                            <x-input-error :messages="$errors->get('origin_link')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('general.shorten_link') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
