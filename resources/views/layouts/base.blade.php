<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="language" content="{{ app()->getLocale() }}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ mix(config('urls.images') .'/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ mix(config('urls.images') .'/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ mix(config('urls.images') .'/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ mix(config('urls.images') .'/favicon/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ mix(config('urls.images') .'/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ mix(config('urls.images') .'/favicon/favicon.ico') }}">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="{{ mix(config('urls.images') .'/favicon/browserconfig.xml') }}">
        <meta name="theme-color" content="#ffffff">

        <link rel="dns-prefetch" href="//fonts.gstatic.com">

        @yield('styles_common')

        @yield('meta_common')
        @yield('meta-og_common')

    </head>

    <body class="page">

        @yield('page')
        @yield('scripts_common')

    </body>
</html>
