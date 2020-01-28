<?php

Route::get('/home', 'AdminController@index')->name('home');

Route::get('/users', 'AdminController@userindex')->name('users');
Route::get('/jobs', 'AdminController@jobindex')->name('jobs');

Route::resource('category', 'CategoryController');
