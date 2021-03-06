<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::view('/', 'dashboard');

    Route::get('/initial/fitness', 'InitialValueController@fitness');
    Route::get('/initial/folding', 'InitialValueController@folding');
    Route::get('/initial/schedule', 'InitialValueController@schedule');


    // google
    Route::get('/google_auth', 'GoogleAuthController@redirect');
    Route::get('/google_auth/callback', 'GoogleAuthController@callback')
        ->name('google_auth.callback');

    Route::post('/logout', 'AdfsAuthController@logout')
        ->name('logout');
});

// adfs
Route::get('/auth', 'AdfsAuthController@login')
    ->name('login');
Route::get('/auth/callback', 'AdfsAuthController@callback')
    ->name('login.callback');
