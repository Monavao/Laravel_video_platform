<?php

Route::resource('series', 'SeriesController');
Route::resource('{series_by_id}/videos', 'VideosController');
Route::resource('users', 'UsersController');
