<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="icon" href="{{ asset('images/others/logo.png') }}" />

    {{-- Bootstrap 5.3.2 CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- Livewire --}}
    @livewireStyles

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    {{-- Custom CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
</head>
