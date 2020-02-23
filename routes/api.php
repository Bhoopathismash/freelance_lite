<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('/signup' , 'UserApiController@signup');
Route::post('/logout' , 'UserApiController@logout');
Route::post('/forgot/password', 'UserApiController@forgot_password');

Route::get('/jobs', 'StaticController@jobs')->name('jobs');
Route::get('/view_post/{id}', 'StaticController@viewPost')->name('viewPost');

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/index' , 'HomeController@index');
    Route::post('/update_password' , 'HomeController@update_password');

    Route::get('/package', 'HomeController@package')->name('package');
	//Route::get('/user_package/{id}', 'HomeController@userPackage')->name('userPackage');

	Route::get('/profile', 'HomeController@profile')->name('profile');
	Route::post('/profile_update', 'HomeController@profileUpdate')->name('profileUpdate');
	Route::post('/change/password', 'HomeController@update_password');

	//Job Hire
	Route::get('/joblist', 'HomeController@jobList')->name('jobList');
	Route::get('/post_job', 'HomeController@postJob')->name('postJob');
	Route::post('/post_job_store', 'HomeController@postJobStore')->name('postJobStore');
	Route::get('/edit_post/{id}', 'HomeController@editPost')->name('editPost');
	Route::post('/post_job_update/{id}', 'HomeController@postJobUpdate')->name('postJobUpdate');


	Route::get('/my_jobs', 'HomeController@myJobs')->name('myJobs');
	Route::post('/bid_job/{post_id}', 'HomeController@bidJob')->name('bidJob');

	Route::post('/assign_job', 'HomeController@assignJob')->name('assignJob');
	Route::get('/release_milestone/{id}', 'HomeController@releaseMilestone')->name('releaseMilestone');
	Route::post('/milestone_pay', 'HomeController@milestonePay')->name('milestonePay');

	Route::get('/update_bid_package', 'HomeController@updateBidPackage')->name('updateBidPackage');

});
