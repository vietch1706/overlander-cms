<?php

Route::group([
    'prefix' => '/api/{ver}/general',
], function () {

    Route::get('supportive/get', \Overlander\General\Api\SupportivePages\GetAll::class);

    Route::post('contact-us/get', \Overlander\General\Api\ContactUs\GetAll::class);

    Route::get('brand/get', \Overlander\General\Api\Brands\GetAll::class);

    Route::get('store/get', \Overlander\General\Api\Stores\GetAll::class);

    Route::get('banner/get', \Overlander\General\Api\Banners\GetAll::class);

    Route::get('country/get', \Overlander\General\Api\Countries\GetAll::class);

    Route::get('interest/get', \Overlander\General\Api\Interests\GetAll::class);

    Route::get('interest/get', \Overlander\General\Api\Interests\GetAll::class);
});
