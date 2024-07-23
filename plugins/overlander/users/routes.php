<?php

// NOTE:: Group APIs with the same functionality
Route::group([
    'prefix' => '/api/{ver}/user',
    'middleware' => ['rest']
], function () {
    Route::post('/register', \Overlander\Users\Api\Users\Register::class);

    Route::post('/send-verification-code', 'Overlander\Users\Api\Users@sendCode');

    Route::post('/verify-code', 'Overlander\Users\Api\Users@verifyCode');

    Route::post('/check-exist', 'Overlander\Users\Api\Users@checkExistUser');

    Route::post('/login', \Overlander\Users\Api\Users\Login::class);

    Route::post('/reset-password', 'Overlander\Users\Api\Users@resetPassword');
});

// NOTE:: use middleware auth for all api need authentication
Route::group([
    'prefix' => '/api/{ver}/user',
    'middleware' => ['rest', 'auth']
], function () {
    Route::get('/me', 'Overlander\Users\Api\Users@getUser');
    Route::get('/logout', \Overlander\Users\Api\Logout::class);
});

// NOTE:: Group APIs with the same functionality [1]
Route::group([
    'prefix' => '/api/{ver}/existing-user',
    'middleware' => ['rest']
], function () {
    Route::post('/step-1', 'Overlander\Users\Api\ExistUsers@step1');

    Route::post('/step-1-verification', 'Overlander\Users\Api\ExistUsers@step1VerifyCode');

    Route::post('/step-2', 'Overlander\Users\Api\ExistUsers@step2');

    Route::get('/get-questions', 'Overlander\Users\Api\ExistUsers@getQuestions');
});
