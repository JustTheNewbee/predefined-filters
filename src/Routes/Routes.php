<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'filter'], function () {
        Route::post('save', 'Polyloans\Filter\Controllers\StoreFilterController@store');
        Route::post('tabs', 'Polyloans\Filter\Controllers\StoreFilterController@getTabs');
        Route::post('delete/{id}', 'Polyloans\Filter\Controllers\StoreFilterController@delete');

        Route::post('vue-predefined-tabs', 'Polyloans\Filter\Controllers\StoreFilterController@getJsonTabs');
    });
});
