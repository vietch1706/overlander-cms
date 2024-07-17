<?php

Route::group([
    'prefix' => '/api/{ver}/users',
], function () {
    Route::post('user/register', 'Overlander\Users\Api\Users@register');

    Route::post('existing-user/step-1', 'Overlander\Users\Api\ExistUsers@step1');

    Route::post('existing-user/step-1-verification', 'Overlander\Users\Api\ExistUsers@step1VerifyCode');

    Route::post('existing-user/step-2', 'Overlander\Users\Api\ExistUsers@step2');

    Route::post('user/send-verification-code', 'Overlander\Users\Api\Users@sendCode');

    Route::get('user/get', 'Overlander\Users\Api\Users@getUser');

    Route::post('user/verify-code', 'Overlander\Users\Api\Users@verifyCode');

    Route::post('user/check-exist', 'Overlander\Users\Api\Users@checkExistUser');

    Route::post('user/login', \Overlander\Users\Api\Login::class);

    Route::post('user/reset-password', 'Overlander\Users\Api\Users@resetPassword');

    Route::get('existing-user/get-questions', 'Overlander\Users\Api\ExistUsers@getQuestions');

});
