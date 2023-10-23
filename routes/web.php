<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Asset Category
    Route::delete('asset-categories/destroy', 'AssetCategoryController@massDestroy')->name('asset-categories.massDestroy');
    Route::resource('asset-categories', 'AssetCategoryController');

    // Asset Location
    Route::delete('asset-locations/destroy', 'AssetLocationController@massDestroy')->name('asset-locations.massDestroy');
    Route::resource('asset-locations', 'AssetLocationController');

    // Asset Status
    Route::delete('asset-statuses/destroy', 'AssetStatusController@massDestroy')->name('asset-statuses.massDestroy');
    Route::resource('asset-statuses', 'AssetStatusController');

    // Asset
    Route::delete('assets/destroy', 'AssetController@massDestroy')->name('assets.massDestroy');
    Route::post('assets/media', 'AssetController@storeMedia')->name('assets.storeMedia');
    Route::post('assets/ckmedia', 'AssetController@storeCKEditorImages')->name('assets.storeCKEditorImages');
    Route::post('assets/parse-csv-import', 'AssetController@parseCsvImport')->name('assets.parseCsvImport');
    Route::post('assets/process-csv-import', 'AssetController@processCsvImport')->name('assets.processCsvImport');
    Route::resource('assets', 'AssetController');

    // Assets History
    Route::resource('assets-histories', 'AssetsHistoryController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Pppoe
    Route::delete('pppos/destroy', 'PppoeController@massDestroy')->name('pppos.massDestroy');
    Route::post('pppos/media', 'PppoeController@storeMedia')->name('pppos.storeMedia');
    Route::post('pppos/ckmedia', 'PppoeController@storeCKEditorImages')->name('pppos.storeCKEditorImages');
    Route::post('pppos/parse-csv-import', 'PppoeController@parseCsvImport')->name('pppos.parseCsvImport');
    Route::post('pppos/process-csv-import', 'PppoeController@processCsvImport')->name('pppos.processCsvImport');
    Route::resource('pppos', 'PppoeController');

    // Kompart
    Route::delete('komparts/destroy', 'KompartController@massDestroy')->name('komparts.massDestroy');
    Route::post('komparts/media', 'KompartController@storeMedia')->name('komparts.storeMedia');
    Route::post('komparts/ckmedia', 'KompartController@storeCKEditorImages')->name('komparts.storeCKEditorImages');
    Route::post('komparts/parse-csv-import', 'KompartController@parseCsvImport')->name('komparts.parseCsvImport');
    Route::post('komparts/process-csv-import', 'KompartController@processCsvImport')->name('komparts.processCsvImport');
    Route::resource('komparts', 'KompartController');

    // Kompartnadajniki
    Route::delete('kompartnadajnikis/destroy', 'KompartnadajnikiController@massDestroy')->name('kompartnadajnikis.massDestroy');
    Route::post('kompartnadajnikis/media', 'KompartnadajnikiController@storeMedia')->name('kompartnadajnikis.storeMedia');
    Route::post('kompartnadajnikis/ckmedia', 'KompartnadajnikiController@storeCKEditorImages')->name('kompartnadajnikis.storeCKEditorImages');
    Route::post('kompartnadajnikis/parse-csv-import', 'KompartnadajnikiController@parseCsvImport')->name('kompartnadajnikis.parseCsvImport');
    Route::post('kompartnadajnikis/process-csv-import', 'KompartnadajnikiController@processCsvImport')->name('kompartnadajnikis.processCsvImport');
    Route::resource('kompartnadajnikis', 'KompartnadajnikiController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
