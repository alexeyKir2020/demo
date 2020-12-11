@extends('layouts.frontend')

@section('main')
    <div class="section">
        <div class="container">
            <div class="card">
                <div class="card-title">
                    <ul class="tabs row">
                        <li class="tab col xs5"><a class="{{ request()->routeIs('auth.form.login') ? 'active' : '' }}" href="#login">@lang('auth.login.title')</a></li>
                        <li class="tab col xs7"><a class="{{ request()->routeIs('auth.form.register') ? 'active' : '' }}" href="#register">@lang('auth.register.title')</a></li>
                    </ul>
                </div>

                <form id="login" class="form_login card-stacked" method="POST" action="{{ route('api.auth.login') }}">
                            @csrf
                            <div class="card-content">
                                <div class="form-group row">
                                    <x-text-field
                                        name="username"
                                        type="email"
                                        required
                                        autocomplete="username"
                                        value="{{ old('username') }}"
                                        :errors="$errors"
                                        minlength="3"
                                        maxlength="100"
                                    >
                                        @lang('auth.username.label')
                                    </x-text-field>
                                </div>
                                <div class="form-group row">
                                    <x-text-field
                                        id="login-password"
                                        name="password"
                                        type="password"
                                        required
                                        autocomplete="password"
                                        :errors="$errors"
                                        minlength="6"
                                        maxlength="100"
                                    >
                                        @lang('auth.password.label')
                                    </x-text-field>
                                </div>
                                <div class="form-group row remember_row">
                                    <div class="col-md-4 offset-md-2">
                                        <x-checkbox
                                            id="login-remember"
                                            name="remember"
                                            checked="{{ old('remember') ? 'checked' : '' }}"
                                        >
                                            @lang('auth.login.remember')
                                        </x-checkbox>
                                    </div>

                                    <div class="col-md-4">
                                        @if(Route::has('password.request'))
                                            <a class="link" href="{{ route('password.request') }}">
                                                @lang('auth.login.reset')
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <x-button
                                    id="login"
                                    type="submit"
                                    class="waves-effect waves-light form_login__submit"
                                >
                                    @lang('auth.login.signin')
                                </x-button>
                            </div>
                        </form>

                <form id="register" class="card-stacked" method="POST" action="{{ route('api.auth.register') }}">
                    @csrf
                    <div class="card-content">
                        <div class="form-group row">
                            <x-text-field
                                name="email"
                                type="email"
                                required
                                autocomplete="username"
                                value="{{ old('username') }}"
                                :errors="$errors"
                                minlength="3"
                                maxlength="100"
                            >
                                @lang('auth.username.label')
                            </x-text-field>
                        </div>
                        <div class="form-group row">
                            <x-text-field
                                id="register-password"
                                name="password"
                                type="password"
                                required
                                autocomplete="password"
                                :errors="$errors"
                                minlength="6"
                                maxlength="100"
                            >
                                @lang('auth.password.label')
                            </x-text-field>
                        </div>

                        <div class="form-group row">
                            <x-text-field
                                id="register-password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                :errors="$errors"
                                minlength="6"
                                maxlength="100"
                            >
                                @lang('auth.password.password_confirmation.label')
                            </x-text-field>
                        </div>
                    </div>
                    <div class="card-action">
                        <x-button
                            id="register"
                            type="submit"
                            class="waves-effect waves-light form_login__submit"
                        >
                            @lang('auth.register.button')
                        </x-button>
                    </div>
                </form>

                <div class="card-action social-action">
                    <div class="card-action__label social-action__title">@lang('auth.social.title')</div>
                    <ul class="social__container">
                        <li><a class="btn-floating purple" href="/api/v1/login/facebook" ><i class="mdi large mdi-facebook" title="Facebook"></i></a></li>
                        <li><a class="btn-floating purple" href="#" ><i class="mdi large mdi-instagram" title="Telegram"></i></a></li>
                        <li><a class="btn-floating purple" href="#" ><i class="mdi large mdi-vk" title="Telegram"></i></a></li>
                        <li><a class="btn-floating purple" href="#" ><i class="mdi large mdi-telegram" title="Telegram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
