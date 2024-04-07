<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/threads');
});


Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index');

Route::get('threads', 'App\Http\Controllers\ThreadsController@index')->name('threads');
Route::get('threads/create', 'App\Http\Controllers\ThreadsController@create');
Route::get('threads/search', 'App\Http\Controllers\SearchController@show');
Route::get('threads/{channel}/{thread}', 'App\Http\Controllers\ThreadsController@show');
Route::patch('threads/{channel}/{thread}', 'App\Http\Controllers\ThreadsController@update');
Route::delete('threads/{channel}/{thread}', 'App\Http\Controllers\ThreadsController@destroy');
// Route::post('threads', 'App\Http\Controllers\ThreadsController@store')->middleware('must-be-confirmed');
Route::post('threads', 'App\Http\Controllers\ThreadsController@store');
Route::get('threads/{channel}', 'App\Http\Controllers\ThreadsController@index');

Route::post('locked-threads/{thread}', 'App\Http\Controllers\LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'App\Http\Controllers\LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::get('/threads/{channel}/{thread}/replies', 'App\Http\Controllers\RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'App\Http\Controllers\RepliesController@store');
Route::patch('/replies/{reply}', 'App\Http\Controllers\RepliesController@update');
Route::delete('/replies/{reply}', 'App\Http\Controllers\RepliesController@destroy')->name('replies.destroy');

Route::post('/replies/{reply}/best', 'App\Http\Controllers\BestRepliesController@store')->name('best-replies.store');

Route::post('/threads/{channel}/{thread}/subscriptions', 'App\Http\Controllers\ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'App\Http\Controllers\ThreadSubscriptionsController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'App\Http\Controllers\FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'App\Http\Controllers\FavoritesController@destroy');

Route::get('/profiles/{user}', 'App\Http\Controllers\ProfilesController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'App\Http\Controllers\UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'App\Http\Controllers\UserNotificationsController@destroy');

Route::get('/register/confirm', 'App\Http\Controllers\Auth\RegisterConfirmationController@index')->name('register.confirm');

Route::get('api/users', 'App\Http\Controllers\Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'App\Http\Controllers\Api\UserAvatarController@store')->middleware('auth')->name('avatar');

Route::get('/telegram/show_connect', 'App\Http\Controllers\TelegramController@showConnectButton')->name('telegram.show_connect');
Route::get('/telegram/connect', 'App\Http\Controllers\TelegramController@callback')->name('telegram.connect');
// Route::get('/telegram/callback', 'TelegramController@callback')->name('telegram.callback');


// Banners
Route::get('banners', 'App\Http\Controllers\BannersController@index')->name('banners');
Route::post('banners', 'App\Http\Controllers\BannersController@store')->name('banners.store');
Route::get('/banners/create', 'App\Http\Controllers\BannersController@create')->name('banners.create');
Route::get('/banners/{banner}/edit', 'App\Http\Controllers\BannersController@edit')->name('banners.edit');
Route::post('/banners/update', 'App\Http\Controllers\BannersController@updateBanner')->name('banners.update');
Route::delete('/banners/{banner}', 'App\Http\Controllers\BannersController@destroy')->name('banners.destroy');
