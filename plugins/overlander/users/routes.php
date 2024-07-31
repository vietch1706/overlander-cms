<?php

// NOTE:: Group APIs with the same functionality
use Overlander\Users\Api\Logout;
use Overlander\Users\Api\Users\Get;
use Overlander\Users\Api\Users\Login;
use Overlander\Users\Api\Users\Register;
use Overlander\Users\Api\Users\ResetPassword;
use Overlander\Users\Api\Users\VerificationSend;
use Overlander\Users\Api\Users\VerificationCheck;
use Overlander\Users\Api\Users\CheckExist;
use Overlander\Users\Api\Users\ChangePassword;

Route::group([
    'prefix' => '/api/{ver}/user',
    'middleware' => ['rest']
], function () {
    Route::post('/register', Register::class);

    Route::post('/send-verification-code', VerificationSend::class);

    Route::post('/verify-code', VerificationCheck::class);

    Route::post('/check-exist', CheckExist::class);

    Route::post('/login', Login::class);

    Route::post('/reset-password', ResetPassword::class);

    Route::post('/change-password', ChangePassword::class);
});

// NOTE:: use middleware auth for all api need authentication
Route::group([
    'prefix' => '/api/{ver}/user',
    'middleware' => ['rest', 'auth']
], function () {
    Route::get('/me', Get::class);
    Route::get('/logout', Logout::class);
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
