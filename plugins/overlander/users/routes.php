<?php

// NOTE:: Group APIs with the same functionality
use Overlander\Users\Api\ExistsMember\GetQuestions;
use Overlander\Users\Api\ExistsMember\StepOne;
use Overlander\Users\Api\ExistsMember\StepTwo;
use Overlander\Users\Api\Users\ChangePassword;
use Overlander\Users\Api\Users\Get;
use Overlander\Users\Api\Users\Login;
use Overlander\Users\Api\Users\Logout;
use Overlander\Users\Api\Users\Register;
use Overlander\Users\Api\Users\ResetPassword;
use Overlander\Users\Api\Users\Update;
use Overlander\Users\Api\Users\UpdateByToken;
use Overlander\Users\Api\Users\VerificationCheck;
use Overlander\Users\Api\Users\VerificationSend;

Route::group([
    'prefix' => '/api/{ver}/user',
    'middleware' => ['rest']
], function () {
    Route::post('/register', Register::class);

    Route::post('/send-verification-code', VerificationSend::class);

    Route::post('/verify-code', VerificationCheck::class);

    Route::post('/login', Login::class);

    Route::post('/update', Update::class);

    Route::post('/reset-password', ResetPassword::class);

    Route::post('/change-password', ChangePassword::class);

    Route::post('/update-information', UpdateByToken::class);
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
    Route::post('/step-1', StepOne::class);

    Route::post('/step-2', StepTwo::class);

    Route::get('questions/get', GetQuestions::class);
});
