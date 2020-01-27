<?php

Route::get('/', 'JobController@index')->name('guest.jobs.index');
Route::get('/add', 'JobController@create')->name('guest.jobs.create');
Route::post('/add', 'JobController@store')->name('guest.jobs.store');
Route::get('/jobs/{job}', 'JobController@show')->name('guest.jobs.show');
Route::middleware(['signed'])->group(function () {
    Route::get('/jobs/{job}/edit', 'JobController@edit')->name('guest.jobs.edit');
    Route::put('/jobs/{job}', 'JobController@update')->name('guest.jobs.update');
    Route::delete('/jobs/{job}', 'JobController@destroy')->name('guest.jobs.destroy');
});
