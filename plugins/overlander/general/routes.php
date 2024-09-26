<?php

use Overlander\General\Api\Banners\GetBanner;
use Overlander\General\Api\Brands\GetBrand;
use Overlander\General\Api\ContactUs\CreateMessage;
use Overlander\General\Api\Countries\GetCountry;
use Overlander\General\Api\Interests\GetInterest;
use Overlander\General\Api\Stores\GetStore;
use Overlander\General\Api\SupportivePages\GetSpPage;

Route::group([
    'prefix' => '/api/{ver}/general',
    'middleware' => ['rest'],
], function () {

    Route::get('supportive/get', GetSpPage::class);

    Route::get('brand/get', GetBrand::class);

    Route::get('store/get', GetStore::class);

    Route::get('banner/get', GetBanner::class);

    Route::get('country/get', GetCountry::class);

    Route::get('interest/get', GetInterest::class);

});
Route::group([
    'prefix' => '/api/{ver}/general',
    'middleware' => ['rest'],
], function () {
    Route::post('contact-us/create', CreateMessage::class);
});
