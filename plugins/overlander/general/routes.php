<?php

use Overlander\General\Api\Brands;
use Overlander\General\Api\ContactUs;
use Overlander\General\Api\Stores;
use Overlander\General\Api\SupportivePages;

Route::group([
  'prefix' => '/api/{ver}/general',
], function () {

  Route::get('supportive-page', [SupportivePages::class, 'getApi']);

  Route::post('contact-us', [ContactUs::class, 'getApi']);

  Route::get('brand', [Brands::class, 'getApi']);

  Route::get('stores', [Stores::class, 'getApi']);
});
