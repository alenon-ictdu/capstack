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




Route::group(['middleware' => 'prevent-back-history'],function(){
	Route::get('/', 'LandingPageController@home')->name('welcome');

	Route::any('/search', 'LandingPageController@search')->name('books-search');

	Route::any('/books/sort-by-year', 'LandingPageController@sortByYear')->name('sort-by-year');

	Route::get('/books/newly-added', 'LandingPageController@newlyAdded')->name('newly-added');

	Route::get('/books/a-z-list', 'LandingPageController@azList')->name('a-z-list');

	Route::get('/books/course/{id}', 'LandingPageController@course')->name('course');
    
	//Auth::routes();
	// Authentication Routes...
	$this->get('/login', 'Auth\LoginController@showLoginForm')->name('login');
	$this->post('/login', 'Auth\LoginController@login');
	$this->post('/logout', 'Auth\LoginController@logout')->name('logout');

	// Registration Routes...
	//$this->get('/naNljDFJvX', 'Auth\RegisterController@showRegistrationForm')->name('register');
	//$this->post('/naNljDFJvX', 'Auth\RegisterController@register');

	// Password Reset Routes...
	$this->get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	 $this->post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	$this->get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	$this->post('/password/reset', 'Auth\ResetPasswordController@reset');

	// export books
	Route::get('/exportbooks', 'BookController@exportBooks')->name('exportbooks');

	Route::get('/books', 'HomeController@index')->name('home');
	//Route::get('/home/search', 'HomeController@searchBook')->name('search.book');
	Route::get('/book/backup', 'BookController@backupBooks')->name('backup.book');

	Route::get('/book/borrow/{id}', 'BookController@viewBorrowBook')->name('view.borrow.book');
	Route::post('/book/borrow', 'BookController@borrowBook')->name('borrow.book');
	// Route::get('/borrowedbooks', 'BookController@bookBorrowed')->name('book.borrowed');
	/*Route::get('/book/borrowers/search', 'BookController@searchBorrowers')->name('search.borrowers');*/

	Route::get('/book/penalty', 'BookController@penalty')->name('book.penalty');

	Route::get('/book/borrow/edit/{id}', 'BookController@editBorrowBook')->name('edit.borrow.book');
	Route::match(['PUT', 'PATCH'], '/book/borrow/update/{id}', 'BookController@updateBorrowBook')->name('update.borrow.book');
	Route::delete('/book/borrow/{id}', 'BookController@destroyBorrowBook')->name('destroy.borrow.book');
	Route::get('borrowers', 'BookController@viewBorrowers')->name('view.borrowers');

	Route::get('/book/print-selected-books', 'BookController@selectBooks')->name('select-books');
	Route::post('/book/print-selected-books', 'BookController@printSelectedBookss')->name('print-selected-books');

	Route::get('/book/printbooks', 'BookController@printBooks')->name('books.print');
	// Route::post('/book/printselectedbooks', 'BookController@printSelectedBooks')->name('qr.selected.print');
	Route::resource('/book', 'BookController', ['except' => ['show']]);
	Route::resource('/course', 'CourseController', ['except' => ['show']]);
	Route::get('/book/{id}', 'PublicBookController@show')->name('book.show');
	Route::post('/book/add', 'BookController@storeAndNew')->name('book.store.new');

	Route::match(['PUT', 'PATCH'], '/book/update/{id}', 'BookController@updateAndView')->name('book.update.view');

	Route::get('user/settings', 'UserController@viewUser')->name('view.user');
	Route::post('user/settings/updatepicture', 'UserController@updatePicture')->name('update.picture');
	Route::post('user/settings/updateinfo', 'UserController@updateInfo')->name('update.info');
	Route::match(['PUT', 'PATCH'], 'user/settings/{id}', 'UserController@updatePassword')->name('update.password');

	Route::get('/dashboard', 'BookController@dashboard')->name('dashboard');

});