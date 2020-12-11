@extends('layouts.frontend')

@section('main')
    <div class="section">
        <div class="container">
            <div class="card">
                <div class="card-title">
                    <ul class="tabs row">
                        <li class="tab col s6"><a href="#test1">Войти</a></li>
                        <li class="tab col s6"><a class="active" href="#test2">Зарегистроваться</a></li>
                    </ul>
                </div>

                <form id="test1" class="card-stacked" method="POST" action="{{ route('api.auth.login') }}">
                            @csrf
                            <div class="card-content">
                                <div class="form-group row">
                                    <x-text-field
                                        name="email"
                                        type="email"
                                        required
                                        autocomplete="email"
                                        value="{{ old('email') }}"
                                        :errors="$errors"
                                        minlength="3"
                                        maxlength="100"
                                    >
                                        @lang('auth.login.email.label')
                                    </x-text-field>
                                </div>
                                <div class="form-group row">
                                    <x-text-field
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                        autocomplete="password"
                                        :errors="$errors"
                                        minlength="6"
                                        maxlength="100"
                                    >
                                        @lang('auth.login.password.label')
                                    </x-text-field>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 offset-md-2">
                                        <x-checkbox
                                            id="remember"
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
                                    type="submit"
                                    class="waves-effect waves-light"
                                >
                                    <x-slot name="text">@lang('auth.login.signin')</x-slot>
                                </x-button>
                            </div>
                        </form>

                <form id="test2" class="card-stacked" method="POST" action="{{ route('auth.register') }}">
                    @csrf
                    <div class="card-content">
                        <div class="form-group row">
                            <x-text-field
                                name="email"
                                type="email"
                                required
                                autocomplete="email"
                                value="{{ old('email') }}"
                                :errors="$errors"
                                minlength="3"
                                maxlength="100"
                            >
                                @lang('auth.login.email.label')
                            </x-text-field>
                        </div>
                        <div class="form-group row">
                            <x-text-field
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="password"
                                :errors="$errors"
                                minlength="6"
                                maxlength="100"
                            >
                                @lang('auth.login.password.label')
                            </x-text-field>
                        </div>

                        <div class="form-group row">
                            <x-text-field
                                id="password_confiramtion"
                                name="password_confiramtion"
                                type="password"
                                required
                                :errors="$errors"
                                minlength="6"
                                maxlength="100"
                            >
                                @lang('auth.login.password_confiramtion.label')
                            </x-text-field>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="card-action__label">@lang('auth.login.no-account')</div>

                        <x-button
                            id="register"
                            href="{{ route('api.auth.register') }}"
                            class="waves-effect waves-light"
                        >
                            <x-slot name="text">@lang('auth.login.register')</x-slot>
                        </x-button>
                    </div>
                </form>

                <div class="card-action">
                    <div class="card-action__label">@lang('auth.login.social')</div>
                    <ul class="social__container">
                        <li><a class="btn-floating purple" href="" ><i class="large mdi mdi-home-circle-outline"></i></a></li>
                        <li><a class="btn-floating purple" href="/api/v1/login/facebook" ><i class="mdi large mdi-facebook" title="Facebook"></i></a></li>
                        <li><a class="btn-floating purple" href="#" ><i class="mdi large mdi-telegram" title="Telegram"></i></a></li>
                        <li><a class="btn-floating purple" href="#" ><i class="mdi large mdi-instagram" title="Instagram"></i></a></li>
                        <li><a class="btn-floating purple" href="#" ><i class="mdi large mdi-vk" title="vkontakte"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
