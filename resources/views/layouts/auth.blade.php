<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'L.Employee') }} - @yield('title', 'Login')</title>
    <meta name="description" content="Employee Management System - Login">

    @vite(['resources/css/auth.css'])
    @livewireStyles
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @if(!file_exists(public_path('build/manifest.json')))
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @endif
</head>

<body>
    {{ $slot }}

    @livewireScripts
</body>

</html>
