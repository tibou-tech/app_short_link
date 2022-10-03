<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('general.list_links') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Message errors --}}
                    @if(session()->has('message'))
                        <div class="p-4 mb-4 text-lg font-medium text-center text-red-600 bg-red-100 rounded-lg">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                   <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('general.url_key') }} </th>
                            <th scope="col">{{ __('general.url_origin') }} </th>
                            <th scope="col">{{ __('general.url_short') }} </th>
                            @auth
                                <th scope="col">{{ __('general.action') }} </th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($links as $key => $link )
                            <tr>
                                <th scope="row"> {{ ++ $key }} </th>
                                <td> {{ $link->key }} </td>
                                <td> {{ $link->origin_link }} </td>
                                <td>
                                    <a
                                        href="{{ route('links.show', ['link' => $link->key]) }}"
                                        target="__blank"
                                    >
                                        {{ config('app.url') . '/links/' . $link->key }}
                                    </a>
                                </td>
                                @can('delete_links', $link)
                                    <td>
                                        <form action="{{ route('links.destroy', ['link' => $link->key]) }}" method="POST" >

                                            @method('DELETE')

                                            @csrf

                                            <button type="submit" class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-600">
                                                {{ __('general.delete') }}
                                            </button>

                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                   </table>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

