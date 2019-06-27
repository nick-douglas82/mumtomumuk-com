<?php

use App\User;

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('get-details', 'API\PassportController@getDetails');
    Route::get('get-pending', 'ReviewController@allPending');
    Route::get('get-approved', 'ReviewController@allApproved');
    Route::post('reviews/review/{review}', 'ReviewController@update');

});