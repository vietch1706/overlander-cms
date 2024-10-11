<?php

use Overlander\Transaction\Api\PointHistory\GetList;

Route::group([
    'prefix' => '/api/{ver}/transaction/',
    'middleware' => ['rest']
], function () {
    Route::get('/point-history/get', GetList::class);
});
