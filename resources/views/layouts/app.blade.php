<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            {{-- <!-- Language Selector -->
            <div class="relative ml-6">
                <button id="languageSelector" class="flex items-center text-gray-700 hover:text-blue-600">
                    <x-icon name="flag-language-{{ app()->getLocale() }}" class="h-5 w-5 mr-2"/>
                    <span class="uppercase">{{ app()->getLocale() }}</span>
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="languageDropdown" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-md hidden">
                    <form method="POST" action="{{ route('change.language') }}">
                        @csrf
                        <button type="submit" name="locale" value="en" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <x-icon name="flag-language-en" class="h-5 w-5 mr-2"/> English
                        </button>
                        <button type="submit" name="locale" value="fr" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <x-icon name="flag-language-fr" class="h-5 w-5 mr-2"/> Français
                        </button>
                    </form>
                </div>
            </div> --}}


            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer with Git Info -->
            @if(app()->environment('local', 'development', 'staging'))
            <footer class="py-3 bg-gray-100 border-t border-gray-200 text-center text-xs text-gray-600">
                <div class="container mx-auto">
                    {{ config('app.name') }} v{{ config('app.version', '1.0.0') }} 
                    @if(app()->make('git.info')->hasGitInfo())
                        <span class="px-2">|</span> {{ app()->make('git.info')->getVersionInfo() }}
                    @endif
                </div>
            </footer>
            @endif
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>
</html>
