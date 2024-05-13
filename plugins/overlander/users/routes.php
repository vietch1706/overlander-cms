<?php


Route::group([
  'prefix' => '/api/{ver}/users',
], function () {

  Route::post('user', 'Overlander\Users\Api\Users@register');
  Route::get('existing-user/step-1', 'Overlander\Users\Api\ExistUsers@codeStep1');
  Route::get('existing-user/step-1-validation', 'Overlander\Users\Api\ExistUsers@validationStep1');
});
