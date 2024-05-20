<?php

use Overlander\General\Api\Brands;
use Overlander\General\Api\ContactUs;
use Overlander\General\Api\Stores;
use Overlander\General\Api\SupportivePages;
use Overlander\General\Api\Banners;

Route::group([
  'prefix' => '/api/{ver}/general',
], function () {

  Route::get('supportive-page/get', 'Overlander\General\Api\SupportivePages@getAllSupportivePages');

  Route::post('contact-us', 'Overlander\General\Api\ContactUs@getAllMessages');

  Route::get('brand', 'Overlander\General\Api\Brand@getAllBrands');

  Route::get('store', [Stores::class, 'getApi']);

  Route::get('banner', [Banners::class, 'getApi']);

  Route::get('phonecode/get', 'Overlander\General\Api\Country@getCountry');
});
