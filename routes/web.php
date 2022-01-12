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

/**
 * HOME
 */

Route::get('/', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);

Route::get('/alert', function (){
    return redirect()->route('home')->with('info','You have signed up!');
});

/**
 * Auth
 */

Route::get('/signup', [
    'as' => 'auth.signup',
    'uses' => 'AuthController@getSignup',
    'middleware' => ['guest'],
]);

Route::post('/signup', [
    'uses' => 'AuthController@postSignup',
    'middleware' => ['guest'],
]);

Route::get('/signin', [
    'as' => 'auth.signin', 
    'uses' => 'AuthController@getSignin',
    'middleware' => ['guest'],
]);

Route::post('/signin', [
    'uses' => 'AuthController@postSignin',
    'middleware' => ['guest'],
]);

Route::get('/signout', [
    'as' => 'auth.signout', 'uses' => 'AuthController@getSignout'
]);

/**
 * Search
 */

Route::get('/search', [
    'as' => 'search.results', 
    'uses' => 'SearchController@getResults',
    'middleware' => ['auth'],
]);

/**
 *  Profile
 */

Route::get('/user/{username}', [
    'as' => 'profile.index', 'uses' => 'ProfileController@getProfile'
]);

Route::get('/profile/edit', [
    'as' => 'profile.edit', 
    'uses' => 'ProfileController@getEdit',
    'middleware' => ['auth'],
]);

Route::post('/profile/edit', [
    'as' => 'profile.edit', 
    'uses' => 'ProfileController@postEdit',
    'middleware' => ['auth'],
]);

/**
 * Friends
 */

Route::get('/friends', [
    'as' => 'friends.index', 
    'uses' => 'FriendController@getIndex',
    'middleware' => ['auth'],
]);

Route::get('/friends/add/{username}', [
    'as' => 'friend.add', 
    'uses' => 'FriendController@getAdd',
    'middleware' => ['auth'],
]);

Route::get('/friends/accept/{username}', [
    'as' => 'friend.accept', 
    'uses' => 'FriendController@getAccept',
    'middleware' => ['auth'],
]);

Route::post('/friends/delete/{username}', [
    'as' => 'friend.delete', 
    'uses' => 'FriendController@postDelete',
    'middleware' => ['auth'],
]);

/**
 * Statuses
 */

Route::post('/status', [
    'as' => 'status.post', 
    'uses' => 'StatusController@postStatus',
    'middleware' => ['auth'],
]);

Route::post('/status/{statusId}/reply', [
    'as' => 'status.reply', 
    'uses' => 'StatusController@postReply',
    'middleware' => ['auth'],
]);

Route::get('/status/{statusId}/like', [
    'as' => 'status.like', 
    'uses' => 'StatusController@getLike',
    'middleware' => ['auth'],
]);