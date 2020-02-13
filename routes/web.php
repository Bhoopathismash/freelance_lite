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

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');

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
Route::get('/package', 'HomeController@package')->name('package');
//Route::get('/user_package/{id}', 'HomeController@userPackage')->name('userPackage');

Route::get('/profile', 'HomeController@profile')->name('profile');
Route::get('/profile_update', 'HomeController@profileUpdate')->name('profileUpdate');
Route::post('/change/password', 'HomeController@update_password');

//Job Hire
Route::get('/joblist', 'HomeController@jobList')->name('jobList');
Route::get('/post_job', 'HomeController@postJob')->name('postJob');
Route::post('/post_job_store', 'HomeController@postJobStore')->name('postJobStore');
Route::get('/edit_post/{id}', 'HomeController@editPost')->name('editPost');
Route::post('/post_job_update/{id}', 'HomeController@postJobUpdate')->name('postJobUpdate');


Route::get('/jobs', 'HomeController@jobs')->name('jobs');
Route::get('/view_post/{id}', 'HomeController@viewPost')->name('viewPost');


Route::post('/bid_job/{post_id}', 'HomeController@bidJob')->name('bidJob');

Route::get('/chat/{post_id}/{hirer_id}/{worker_id}', 'HomeController@chat')->name('chat');
Route::post('/chat_send', 'HomeController@chatSend')->name('chatSend');

Route::get('/refresh_chat', 'HomeController@refreshChat')->name('refreshChat');
Route::get('/user_log_status/{id}', 'HomeController@userLogStatus')->name('userLogStatus');

Route::post('/assign_job', 'HomeController@assignJob')->name('assignJob');
Route::get('/release_milestone/{id}', 'HomeController@releaseMilestone')->name('releaseMilestone');
Route::post('/milestone_pay', 'HomeController@milestonePay')->name('milestonePay');

Route::get('/update_bid_package', 'HomeController@updateBidPackage')->name('updateBidPackage');

// route for to show payment form using get method
Route::get('pay_package/{id}', 'RazorpayController@payPackage')->name('payPackage');
Route::get('pay', 'RazorpayController@pay')->name('pay');

// route for make payment request using post method
Route::post('packagePayment', 'RazorpayController@packagePayment')->name('packagePayment');

// mileStonePayment
Route::post('mileStonePayment', 'RazorpayController@mileStonePayment')->name('mileStonePayment');

Route::get('/logout', 'HomeController@logout')->name('logout');