<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Asset
    Route::post('assets/media', 'AssetApiController@storeMedia')->name('assets.storeMedia');
    Route::apiResource('assets', 'AssetApiController');

    // Assets History
    Route::apiResource('assets-histories', 'AssetsHistoryApiController', ['except' => ['store', 'show', 'update', 'destroy']]);

    // Pppoe
    Route::post('pppos/media', 'PppoeApiController@storeMedia')->name('pppos.storeMedia');
    Route::apiResource('pppos', 'PppoeApiController');

    // Kompart
    Route::post('komparts/media', 'KompartApiController@storeMedia')->name('komparts.storeMedia');
    Route::apiResource('komparts', 'KompartApiController');

    // Kompartnadajniki
    Route::post('kompartnadajnikis/media', 'KompartnadajnikiApiController@storeMedia')->name('kompartnadajnikis.storeMedia');
    Route::apiResource('kompartnadajnikis', 'KompartnadajnikiApiController');
});
