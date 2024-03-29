<?php

use Overlander\General\Api\Brands;
use Overlander\General\Api\ContactUs;
use Overlander\General\Api\Stores;
use Overlander\General\Api\SupportivePages;
use Overlander\General\Api\Banners;

Route::group([
  'prefix' => '/api/{ver}/general',
], function () {

  Route::get('supportive-page', [SupportivePages::class, 'getApi']);

  Route::post('contact-us', [ContactUs::class, 'getApi']);

  Route::get('brand', [Brands::class, 'getApi']);

  Route::get('store', [Stores::class, 'getApi']);

  Route::get('banner', [Banners::class, 'getApi']);
});
