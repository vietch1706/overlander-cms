<?php
if (Config::get('legato.api::override_router')) {
    return;
}

Route::group([
    'prefix' => 'api/{ver}/auth',
    'middleware' => ['lang', 'rest'],
], function () {
    Route::post('register', \Legato\Api\Api\AuthRegister::class);
    Route::post('login', \Legato\Api\Api\AuthLogin::class);
    Route::post('logout', \Legato\Api\Api\AuthLogout::class)->middleware('auth');
    Route::post('password-forgot', \Legato\Api\Api\AuthPasswordForgot::class);
    Route::post('password-reset', \Legato\Api\Api\AuthPasswordReset::class);
    Route::post('password-change', \Legato\Api\Api\AuthPasswordChange::class)->middleware('auth');
    Route::post('verification-send', \Legato\Api\Api\AuthVerificationSend::class);
    Route::post('verification-check', \Legato\Api\Api\AuthVerificationCheck::class);
});
