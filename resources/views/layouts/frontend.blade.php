@extends('layouts.base')

@section('meta_common')
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}"/>
    @yield('meta')
@endsection

@section('meta-og_common')
    @yield('meta-og')
@endsection

@section('styles_common')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix(config('urls.css').'/frontend/styles.min.css') }}">
    @yield('styles')
@endsection

@section('page')

    @include('frontend.chunks.header')

        <main class="main">
            @yield('main')
        </main>

        <x-modal/>

    @include('frontend.chunks.footer')

@endsection

@section('scripts_common')

    <script src="{{ mix(config('urls.js').'/frontend/app.js') }}"></script>

    @yield('scripts')

    <x-metric/>

@endsection
