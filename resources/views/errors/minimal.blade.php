@extends("layouts.frontend")

@section('main')

    <div class="section">
        <section class="container">
            <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                @yield('code')
            </div>

            <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                @yield('message')
            </div>
        </section>
    </div>

@endsection
