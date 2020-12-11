<?php
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Organisation;
use App\Models\Meta\City;
use App\Models\Meta\OrganisationType;


Route::name("api.")->group(function(){

    Route::group(['namespace' => 'v1', 'prefix' => 'v1', 'middleware' => ['XssSanitizer']], function () {

        Route::post('feedback', 'FeedbackController@sendEmail')->name('feedback.send');

        Route::post('login', 'Auth\LoginController@login')->name('auth.login');
        Route::post('register', 'Auth\RegisterController@register')->name("auth.register");

        Route::get('login/{auth_provider}', 'Auth\SocialController@redirectToProvider');
        Route::get('login/{auth_provider}/callback', 'Auth\SocialController@handleProviderCallback');

        Route::get('verify/{token}', 'Auth\RegisterController@verify')
            ->middleware('signed, throttle:6,1');



        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('logout', 'Auth\LoginController@logout');

            Route::get('media', 'MediaController@index')->name('media.index');
            Route::post('media/upload', 'MediaController@store')->name('media.store');
            Route::delete('media/{media}', 'MediaController@destroy')->name('media.destroy');
            Route::apiResource(Organisation::SlUG, Organisation::ENTITY.'Controller');
            Route::apiResource(User::SlUG, User::ENTITY.'Controller');


            Route::group(["prefix" => "meta"], function () {
                Route::apiResource(OrganisationType::SlUG, 'Meta\\'.OrganisationType::ENTITY.'Controller');
                Route::apiResource(City::SlUG, 'Meta\\'.City::ENTITY.'Controller');

            });
        });
    });
});






