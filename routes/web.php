<?php
// ADMIN

Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'admin.'], function() {
	
	// Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLoginForm');

	Route::post('login', 'Auth\LoginController@login')->name('login');

	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	Route::group(array('middleware'=>'admin'), function() {

		Route::resource('users', 'UserController');

		// Route::get('users/delete/{id}', array('as' => 'users.delete', 'uses' => 'UsersController@delete'));

		Route::resource('categories', 'CategoryController');
		Route::resource('articles', 'ArticleController');
		Route::resource('roles', 'RoleController');

	});

});

// CUSTOMER

Route::group(['prefix' => '', 'namespace' => 'Frontend'], function() {

	Route::get('', 'HomeController@index')->name('index');

});






// Route::get('/', function () {
//     return view('welcome');
// });
