<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') || localStorage.setItem('darkMode', 'system')}"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      x-bind:class="{'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}"

>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ setting('site_title') ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=almarai:wght@400;600;700&display=swap">
    <!-- wireUi Scripts -->
    <wireui:scripts/>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
</head>

<body
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
        x-data="{ isSideMenuOpen : false }"
>
<x-notifications/>
<div
        class="flex h-screen bg-secondary-50 dark:bg-secondary-900"
        :class="{ 'overflow-hidden': isSideMenuOpen }"
>
    @include('assets.admin.sidebar.desktop-sidebar')
    @include('assets.admin.sidebar.mobile-sidebar')

    <div class="flex flex-col flex-1 w-full">
        <header class="z-10 py-4 bg-white shadow-md dark:bg-secondary-800">
            @include('assets.admin.header.header')
        </header>
        <main class="h-full overflow-y-auto">
            <div class="container px-6 mx-auto grid">
            @if (isset($header))

                <!-- Page Heading -->
                    {{ $header }}
                @endif
                {{ $slot }}
            </div>
        </main>
    </div>
</div>
@stack('modals')

@livewireScripts
</body>
</html>
