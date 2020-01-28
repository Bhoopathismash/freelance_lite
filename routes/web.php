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

/*Route::get('/post-job', function(){
		return view('post_job');
})->name('postJob');*/

Route::get('/', 'StaticController@index');
Route::get('/home', 'StaticController@index')->name('home');
Route::get('/about', 'StaticController@about')->name('about');
Route::get('/faq', 'StaticController@faq')->name('faq');
Route::get('/contact', 'StaticController@contact')->name('contact');

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('admin.password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});


Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/profile', 'HomeController@profile')->name('profile');

//Job Hire
Route::get('/joblist', 'HomeController@jobList')->name('jobList');
Route::get('/post_job', 'HomeController@postJob')->name('postJob');
Route::post('/post_job_store', 'HomeController@postJobStore')->name('postJobStore');
Route::get('/edit_post/{id}', 'HomeController@editPost')->name('editPost');
Route::post('/post_job_update/{id}', 'HomeController@postJobUpdate')->name('postJobUpdate');


Route::get('/jobs', 'HomeController@jobs')->name('jobs');
Route::get('/view_post/{id}', 'HomeController@viewPost')->name('viewPost');


Route::get('/bid_job/{id}', 'HomeController@bidJob')->name('bidJob');