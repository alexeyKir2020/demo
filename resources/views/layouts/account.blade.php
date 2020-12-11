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
    <link rel="stylesheet" href="{{ mix(config('urls.css').'/frontend/account/styles.min.css') }}">
    @yield('styles')
@endsection

@section('page')


    <main class="main">
        <v-app id="account-app" class="page">
            <Layout
                :user-name='@json(auth()->user()->username)'
                :user-id='@json(auth()->user()->id)'
                :user-token='@json(auth()->user()->currentAccessToken())'>
            </Layout>
        </v-app>
    </main>

@endsection

@section('scripts_common')

    <script src="{{ mix(config('urls.js').'/frontend/account/app.js') }}"></script>

    @yield('scripts')

    <x-metric/>

@endsection
