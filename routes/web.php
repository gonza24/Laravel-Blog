<?php


Route::get('/', 'HomeController@index')->name('home');

Route::get('posts','PostController@index')->name('post.index');

Route::get('post/{slug}','PostController@details')->name('post.details');

Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');
Route::post('comment/{post}','CommentController@store')->name('comment.store');

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
	Route::post('favorite/{post}/add', 'FavoriteController@add')->name('post.favorite'); 
});


Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function(){
	Route::get('/dashboard','DashboardController@index')->name('dashboard');
	
	Route::get('settings', 'SettingsController@index')->name('settings');
	Route::put('profile-update','SettingsController@updateProfile')->name('profile.update');
	Route::put('password-update','SettingsController@updatePassword')->name('password.update');

	Route::resource('tag','TagController');
	Route::resource('category','CategoryController');
	Route::resource('post','PostController');

	Route::get('/pending/post', 'PostController@pending')->name('post.pending');
	Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');

	Route::get('favorite','FavoriteController@index')->name('favorite.index');

	Route::get('comments/', 'CommentController@index')->name('comment.index');
	Route::delete('comments', 'CommentController@destroy')->name('comment.destroy');

	Route::get('/subscriber','subscriberController@index')->name('subscriber.index');
	Route::delete('/subscriber/{subscriber}','subscriberController@destroy')->name('subscriber.destroy');
});

Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']], function(){
	Route::get('/dashboard','DashboardController@index')->name('dashboard');

	Route::get('settings', 'SettingsController@index')->name('settings');
	Route::put('profile-update','SettingsController@updateProfile')->name('profile.update');
	Route::put('password-update','SettingsController@updatePassword')->name('password.update');

	Route::resource('post','PostController');

	Route::get('favorite','FavoriteController@index')->name('favorite.index');

});