<?php

namespace Novius\Backpack\Slideshow;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Novius\Backpack\CRUD\Events\ImageUploadedEvent;
use Novius\Backpack\Slideshow\Models\Slideshow;

class SlideshowServiceProvider extends LaravelServiceProvider
{
    public $routeFilePath = '/../routes/backpack/slideshow.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../routes' => base_path().'/routes'], 'routes');
        $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang/vendor/backpack')], 'lang');
        $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'migrations');
        $this->publishes([__DIR__.'/../resources/views' => resource_path('views/vendor/backpack')], 'views');
        $this->publishes([__DIR__.'/../config' => config_path('backpack')], 'config');

        $this->loadTranslationsFrom(realpath(__DIR__.'/../resources/lang'), 'backpack_slideshow');
        $this->mergeConfigFrom(__DIR__.'/../config/slideshow.php','backpack.slideshow');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // setup the routes
        $this->setupRoutes();
    }

    /**
     * Define the routes for the application.
     */
    protected function setupRoutes()
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }
}
