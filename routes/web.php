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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->middleware('verified');
Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');

Route::get('/threads/search', 'SearchController@show');

Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::patch('threads/{channel}/{thread}', 'ThreadController@update');
Route::post('threads', 'ThreadController@store');
Route::get('threads/{channel}', 'ThreadController@index');

Route::post('locked-threads/{thread}', 'LockedThreadController@store')->name('locked-thread.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadController@destroy')->name('locked-thread.destroy')->middleware('admin');

Route::post('pinned-threads/{thread}', 'PinnedThreadController@store')->name('pinned-thread.store')->middleware('admin');
Route::delete('pinned-threads/{thread}', 'PinnedThreadController@destroy')->name('pinned-thread.destroy')->middleware('admin');

Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::get('/replies/{reply}/favorites', 'FavoritesController@store');
Route::get('/replies/{reply}/unfavorites', 'FavoritesController@destroy')->name('replies.delete');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::delete('replies/{reply}', 'ReplyController@destroy');
Route::patch('replies/{reply}', 'ReplyController@update');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

Route::view('scan', 'scan');

Route::group([
    'prefix'=>'admin',
    'middleware'=>'admin',

], function () {
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/channels', 'ChannelController@index')->name('admin.channels');
    Route::get('/allchannel', 'ChannelController@show');
    Route::delete('channels/{channel}', 'ChannelController@destroy');
    Route::post('/channels', 'ChannelController@store');
    Route::patch('/channels/{channel}', 'ChannelController@update');
});
