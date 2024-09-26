<?php

use Overlander\Transaction\Api\PointHistory\GetByToken;

Route::group([
    'prefix' => '/api/{ver}/transaction/',
    'middleware' => ['rest']
], function () {
    Route::get('/point-history/get', GetByToken::class);
});
