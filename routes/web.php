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

Route::get('/', ['middleware' => 'guest', function () {
    return view('welcome');
}]);

Auth::routes();

// Home Controller
Route::get('/about', 'HomeController@index')->name('about');
Route::get('/ToS', 'HomeController@ToS')->name('tos');
Route::get('/Privacy', 'HomeController@privacy')->name('privacy');
Route::get('/cookie', 'HomeController@cookie')->name('cookie');
Route::get('/contact-us', 'HomeController@contact')->name('contact');
Route::post('/contact-us/submit', 'HomeController@store')->name('submit');

// Users Controller
Route::get('/home', 'UsersController@index')->name('home');
Route::get('/dashboard', 'UsersController@dashboard')->name('dashboard');
Route::get('/profile/{id}', 'UsersController@show')->name('profile');
Route::get('/edit/{id}', 'UsersController@edit')->name('edit');
Route::put('/update/{id}', 'UsersController@update')->name('update');
Route::post('/upload', 'UsersController@upload')->name('bg-upload');
Route::get('/password', 'UsersController@password')->name('password');
Route::put('/complete/{id}', 'UsersController@complete')->name('complete');
Route::post('/ajaxRequest', 'UsersController@ajaxRequest')->name('ajaxRequest');
Route::get('/search', 'UsersController@search')->name('search');
Route::get('/loadmore', 'UsersController@dashboard')->name('more');
Route::get('/notifications', 'UsersController@notifications');
Route::post('/ajaxNotif', 'UsersController@ajaxNotif');
Route::get('/follower/{id}', 'UsersController@follower');
Route::get('/following/{id}', 'UsersController@following');
Route::get('/history/{id}', 'UsersController@history');

Route::get('/back', 'Controller@back')->name('back');

// Login Controller
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// Posts Controller
Route::post('/poster/submit', 'PostsController@store')->name('post');
Route::post('ajaxRequestLike', 'PostsController@ajaxRequestLike')->name('ajaxRequestLike');
Route::post('ajaxRequestIns', 'PostsController@ajaxRequestIns')->name('ajaxRequestIns');
Route::delete('/post/delete/{id}', 'PostsController@destroy')->name('post_delete');
Route::get('/poster/favorite/{id}', 'PostsController@fav')->name('fav');
Route::get('/poster/unfavorite/{id}', 'PostsController@unfav')->name('unfav');
Route::post('/wall/{id}', 'PostsController@wall')->name('wall');
Route::post('/edit/{id}', 'PostsController@update')->name('editpos');
Route::get('/posts/{id}', 'PostsController@show')->name('show');
Route::get('/poster/block/{id}', 'PostsController@block')->name('post_block');
Route::get('/poster/unblock/{id}', 'PostsController@unblock')->name('post_unblock');

// Image Controller
Route::post('/image/upload', 'ImageController@store')->name('upload');
Route::post('ajaxRequestLove', 'ImageController@ajaxRequestLove')->name('ajaxRequestLove');
Route::post('ajaxRequestInst', 'ImageController@ajaxRequestInst')->name('ajaxRequestInst');
Route::delete('/image/delete/{id}', 'ImageController@destroy')->name('img_delete');
Route::get('/image/favorite/{id}', 'ImageController@fav')->name('fav_img');
Route::get('/image/unfavorite/{id}', 'ImageController@unfav')->name('unfav_img');
Route::post('/editcaption/{id}', 'ImageController@update')->name('editcaption');
Route::get('/Image/{id}', 'ImageController@show')->name('image');
Route::get('/image/block/{id}', 'ImageController@block')->name('image_block');
Route::get('/image/unblock/{id}', 'ImageController@unblock')->name('image_unblock');

// Comments Controller
Route::post('/comment/submit', 'CommentsController@store')->name('comment');
Route::post('/comment/image', 'CommentsController@store')->name('imagecomment');
route::get('/comment', 'CommentsController@index')->name('show_comment');
Route::post('/edit_comment/{id}', 'CommentsController@update')->name('editcom');
Route::delete('/comment/delete/{id}', 'CommentsController@destroy')->name('com_delete');
Route::get('/comment/block/{id}', 'CommentsController@block')->name('comment_block');
Route::get('/comment/unblock/{id}', 'CommentsController@unblock')->name('comment_unblock');

// Message Controller
Route::post('/message/submit', 'MessagesController@store')->name('send');
Route::post('/reply/submit', 'MessagesController@store')->name('reply');
Route::get('/message', 'MessagesController@index')->name('message');
Route::get('/messages', 'MessagesController@notif');
Route::get('/message/read/{id}', 'MessagesController@show')->name('read');
Route::put('/message/update/{id}', 'MessagesController@update')->name('msg_update');
Route::delete('/message/delete/{id}', 'MessagesController@destroy')->name('delete');
Route::get('/reply/{id}', 'MessagesController@create')->name('create');

// Report Controller
Route::post('/poster/reported', 'ReportController@postReport')->name('post_report');
Route::post('/image/reported', 'ReportController@imageReport')->name('image_report');
Route::post('/comment/reported', 'ReportController@commentReport')->name('comment_report');

Route::get('/share/poster/{id}', 'UsersController@share')->name('share');
Route::get('/share/image/{id}', 'UsersController@sharing')->name('sharing');
Route::get('/share/profile/{id}', 'UsersController@shareIt')->name('shareIt');

Route::get('/linked', 'UsersController@linked')->name('linked');
