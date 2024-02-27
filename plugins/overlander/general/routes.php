<?php

use Overlander\General\Api\Brands;
use Overlander\General\Api\ContactUs;
use Overlander\General\Api\SupportivePages;

Route::group([
  'prefix' => '/api/{ver}/general',
], function () {

  Route::get('supportive-page', [SupportivePages::class, 'getApi']);

  Route::post('contact-us', [ContactUs::class, 'sendMessage']);

  Route::get('brand', [Brands::class, 'getApi']);
});
