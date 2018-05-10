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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/', 'ChatsController@index');
Route::get('/vue/{vue_capture?}', function () {
    return view('chat');
})->where('vue_capture','[\/\w\.-]*');
// Route::get('messages', 'ChatsController@fetchMessages');
// Route::post('messages', 'ChatsController@sendMessage');

// Route::get('get-messages/{friend}', 'ChatsController@userMessages');
// Route::get('messages/{friend}', 'InboxController@userMessages');
Route::prefix('api')->group(function () {
    Route::get('user', 'UserController@index');
    Route::get('getUser', 'UserController@current_user');
    Route::post('createChat', 'ChatsController@createChat');
    Route::post('getMessages', 'ChatsController@fetchMessages');
    Route::post('messages', 'ChatsController@sendMessage');
});
