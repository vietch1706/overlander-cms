<?php

use Overlander\General\Api\Banners;
use Overlander\General\Api\Stores;

Route::group([
    'prefix' => '/api/{ver}/general',
], function () {

    Route::get('supportive/get', 'Overlander\General\Api\SupportivePages@getAllSupportivePages');

    Route::post('contact-us', 'Overlander\General\Api\ContactUs@getAllMessages');

    Route::get('brand', 'Overlander\General\Api\Brand@getAllBrands');

    Route::get('store', [Stores::class, 'getApi']);

    Route::get('banner', [Banners::class, 'getApi']);

    Route::get('phonecode/get', 'Overlander\General\Api\Country@getCountry');
    
    Route::get('interests/get', 'Overlander\General\Api\Interests@getInterests');
});
