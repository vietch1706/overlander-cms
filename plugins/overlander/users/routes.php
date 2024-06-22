<?php

Route::group([
    'prefix' => '/api/{ver}/users',
], function () {
    Route::post('user/register', 'Overlander\Users\Api\Users@register');
    Route::get('existing-user/step-1', 'Overlander\Users\Api\ExistUsers@setp1SendCode');
    Route::get('existing-user/step-1-phone-verification', 'Overlander\Users\Api\ExistUsers@step1VerifyCode');
    Route::get('existing-user/step-2', 'Overlander\Users\Api\ExistUsers@step2Questions');
    Route::get('user/send-verification-code', 'Overlander\Users\Api\Users@sendCode');
    Route::get('user/get', 'Overlander\Users\Api\Users@getUser');
    Route::get('user/verify-code', 'Overlander\Users\Api\Users@verifyCode');
    Route::get('user/check-exist', 'Overlander\Users\Api\Users@checkExistUser');
    Route::post('user/login', 'Overlander\Users\Api\Users@login');
    Route::get('user/change-password', 'Overlander\Users\Api\Users@resetPassword');
});
