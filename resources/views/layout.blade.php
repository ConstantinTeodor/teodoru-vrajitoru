<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="applocale" content="{{ session('applocale', 'en') }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

    @vite('resources/scss/app.scss')
    @vite('resources/js/app.js')

    @hasSection('seo')
        @yield('seo')
    @endif
</head>

<body class="min-h-dvh flex flex-col bg-primary-background">
    <x-header/>

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-footer/>
</body>
