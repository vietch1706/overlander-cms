<?php

use Overlander\Users\Api\Users;

Route::group([
  'prefix' => '/api/{ver}/users',
], function () {

  Route::post('user', [Users::class, 'getApi']);
});
