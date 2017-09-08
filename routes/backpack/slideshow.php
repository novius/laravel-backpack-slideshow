<?php

Route::group([
    'namespace' => 'Novius\Backpack\Slideshow\Http\Controllers\Admin',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'admin'],
], function () {
    CRUD::resource('slideshow', 'SlideshowCrudController');
    CRUD::resource('slide', 'SlideCrudController');
});
