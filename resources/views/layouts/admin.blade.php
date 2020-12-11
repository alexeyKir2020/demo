@extends('layouts.base')

@section('styles_common')
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix(config('urls.css').'/admin/styles.min.css') }}">
@endsection

@section('page')

    <v-app id="admin-app" class="page">
        <Layout
            :user-name='@json(auth()->user()->email)'
            :user-id='@json(auth()->user()->id)'
            :user-token='@json(auth()->user()->currentAccessToken())'>
        </Layout>
    </v-app>

@endsection

@section('scripts_common')
    <script src="{{ mix(config('urls.js').'/admin/app.js') }}"></script>
@endsection
