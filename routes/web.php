<?php

use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;


Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');
Route::get('search','SearchController@search')->name('search');

// Post route:
Route::get('post/{slug}', 'PostController@details')->name('post.details');
Route::get('posts', 'PostController@index')->name('all.posts');

//post by cat $ tag 
Route::get('category/{slug}', 'PostController@postByCategory')->name('category.posts');
Route::get('tag/{slug}', 'PostController@postByTag')->name('tag.posts');

Route::get('profile/{username}','AuthorController@profile')->name('author.profile');

Route::group(['middleware' => 'auth'], function () {

    Route::post('favorite/{post}/add', 'FavoriteController@add')->name('favorite.post');
    Route::post('comment/{post}', 'CommentController@store')->name('comment.store');

});

//Admin All Route:
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('authors','AuthorController@index')->name('author.index');
    Route::delete('author/{id}','AuthorController@destroy')->name('author.destroy');
    //comment system Route
    Route::get('comments', 'CommentController@index')->name('comment.index');
    Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    //    Profile settings Route
    Route::get('setting', 'SettingController@index')->name('setting');
    Route::put('profile-update', 'SettingController@ProfileUpdate')->name('update.profile');
    Route::put('password-update', 'SettingController@updatePassword')->name('update.password');

    //    Post,tag,category route
    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');

    //Post approved Route
    Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');
    Route::get('/pending/post', 'PostController@pending')->name('post.pending');

    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');

    Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{id}', 'SubscriberController@destroy')->name('subscriber.delete');
});



//Author All Route:
Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('post', 'PostController');

    //comment system Route
    Route::get('comments', 'CommentController@index')->name('comment.index');
    Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    //    Profile settings Route
    Route::get('setting', 'SettingController@index')->name('setting');
    Route::put('profile-update', 'SettingController@ProfileUpdate')->name('update.profile');
    Route::put('password-update', 'SettingController@updatePassword')->name('update.password');
});


View::composer('layouts.frontend.include.footer',function ($view){
    $categories = App\Category::all();
    $view->with('categories',$categories);
});
