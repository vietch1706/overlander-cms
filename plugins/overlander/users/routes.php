<?php

Route::group([
  'prefix' => '/api/{ver}/users',
], function () {

  Route::post('user/register', 'Overlander\Users\Api\Users@register');
  Route::get('existing-user/step-1', 'Overlander\Users\Api\ExistUsers@codeStep1');
  Route::get('existing-user/step-1-validation', 'Overlander\Users\Api\ExistUsers@validationStep1');
  Route::get('user/register/send-verification-code', 'Overlander\Users\Api\Users@sendCode');
  Route::get('user/register/verify-code', 'Overlander\Users\Api\Users@verifyCode');
  Route::post('user/login', 'Overlander\Users\Api\Users@login');
});
