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

Route::get('generate-sitemap', function () {
    \App\Jobs\GenerateSitemap::dispatch();
    return redirect()->route('article.index');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/kucukler', function () {
    return ('bu sayfada KÜÇÜKLER gezebilir');
})->name('sadecekucukler');

Route::get('/buyuklereozel', function () {
    return ('bu sayfada sadece büyükler gezebilir');
})->middleware('auth', 'checkage:22');

Route::get('/feed', 'HomeController@index')->name('feed')->middleware('auth');

Route::get('articles', 'ArticleController@index')->name("article.index");
Route::get('articles/new', 'ArticleController@create')->name("article.create")->middleware('auth');
Route::post('articles', 'ArticleController@store')->name("article.store")->middleware('auth');
Route::get('articles/{article}', 'ArticleController@detail')->name("article.detail");
Route::get('articles/{article}/edit', 'ArticleController@edit')->name("article.edit")->middleware('auth');
Route::post('articles/{id}/edit', 'ArticleController@editstore')->name("article.update")->middleware('auth');
Route::delete('articles/{id}/edit', 'ArticleController@delete')->name("article.delete")->middleware('auth');
Route::post('articles/{article}/comment', 'ArticleController@addComment')->name("article.addcomment")->middleware('auth');
Route::delete('articles/{article}/comment', 'ArticleController@deleteComment')->name("article.deletecomment")->middleware('auth');

Route::get('author/{user}', 'ProfileController@profileView')->name("user.articles");
Route::get('author/update', 'ProfileController@profileUpdate')->name("user.update")->middleware('auth');
Route::get('author/follow/{user}', 'ProfileController@follow')->name("user.follow")->middleware('auth');
Route::get('author/unfollow/{user}', 'ProfileController@unFollow')->name("user.unfollow")->middleware('auth');
Route::get('notification/{notif}', 'ProfileController@notification')->name("user.notif")->middleware('auth');

Route::get('tags/{tag}', 'ArticleController@listTagArticles')->name("tag.articles");

Route::get('hava-durumu/', 'HomeController@showWeather')->name("havadurumu");
