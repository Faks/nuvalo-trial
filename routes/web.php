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

use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return redirect()->route('filter');
})->name('home');

Route::get('/filter/{filter?}', 'FilterController@indexFilter')->name('filter');
Route::get('/filter2', 'FilterController@indexFilter2')->name('filter2');
//Axio Endpoint
Route::get('/json-filter2', 'FilterController@filter2Json');

Route::get('/filter3/{sort?}', 'FilterController@indexFilter3')->name('filter3');
//Axio Endpoint
Route::get('/json-filter3', 'FilterController@filter3Json');

Route::get('/api', 'HomeController@getDataFromApi');

Artisan::call('view:clear');
