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

Route::get('/subscribe', function(){
	return view('subscribe');
});	

Route::post('/subscribe', function(){
	return request()->all();
	//return user()->create($request->all());
	//return auth()->user()->newSubscription(request('plan'), request('plan'))->create(request('stripeToken'));
});

Auth::routes();
Route::get('/', 'FrontendController@welcome');
Route::get('/series/{series}', 'FrontendController@series')->name('series');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');
Route::get('/logout', function() { auth()->logout(); return redirect('/'); });
Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');
Route::get('/series', 'FrontendController@showAllseries')->name('all-series');

Route::middleware('auth')->group(function(){
	Route::post('/series/complete-video/{video}', 'WatchSeriesController@completeVideo');
	Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.display');
	Route::get('/series/{series}/video/{video}', 'WatchSeriesController@showVideo')->name('series.watch');
	Route::post('/subscription/change', 'SubscriptionsController@change')->name('subscriptions.change');
	Route::post('/subscribe', 'SubscriptionsController@subscribe');
	Route::get('/subscribe', 'SubscriptionsController@showSubscriptionForm');
});
