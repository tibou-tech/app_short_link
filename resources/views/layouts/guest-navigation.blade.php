<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard' , ['locale' => app()->getLocale()]) }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('dashboard' , ['locale' => app()->getLocale()])" :active="request()->routeIs('dashboard')">
                            {{ __('general.dashboard') }}
                        </x-nav-link>
                    </div>
                @endauth

                @guest
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                            {{ __('general.welcome') }}
                        </x-nav-link>
                    </div>
                @endguest

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('links.index' , ['locale' => app()->getLocale()])" :active="request()->routeIs('links.index')">
                        {{ __('general.list_links') }}
                    </x-nav-link>
                </div>


                <div class="lang ml-6">
                    <select onchange="changeLanguage(this.value)" >
                        <option
                            {{ session()->has('locale') ? (app()->getLocale() === 'en' ? 'selected' : '') : '' }}
                            value="en"
                        >
                            {{ __('general.english') }}
                        </option>
                        <option
                            {{ session()->has('locale') ? (app()->getLocale() === 'fr' ? 'selected' : '') : '' }}
                            value="fr"
                        >
                            {{ __('general.french') }}
                        </option>
                    </select>
                </div>
            </div>

        </div>
    </div>

</nav>

<script>
    function changeLanguage(newLang)
    {
        const url = window.location.href.split('//');

        const currentLang = url[1].split('/')[1];

        const link = window.location.href.replace(currentLang, newLang);

        window.location = link;
    }
</script>

<style>
    .lang {
        margin-top: 13px;
    }

    .lang select {
        border: none
    }

    .lang select:focus {
        box-shadow: none
    }
</style>
