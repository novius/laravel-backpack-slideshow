# Laravel Backpack Slideshow
[![Travis](https://img.shields.io/travis/novius/laravel-backpack-slideshow.svg?maxAge=1800&style=flat-square)](https://travis-ci.org/novius/laravel-backpack-slideshow)
[![Packagist Release](https://img.shields.io/packagist/v/novius/laravel-backpack-slideshow.svg?maxAge=1800&style=flat-square)](https://packagist.org/packages/novius/laravel-backpack-slideshow)
[![Licence](https://img.shields.io/packagist/l/novius/laravel-backpack-slideshow.svg?maxAge=1800&style=flat-square)](https://github.com/novius/laravel-backpack-slideshow#licence)

Admin interface for managing slideshow


## Installation

In your terminal:

```bash
composer require novius/laravel-backpack-slideshow
```

Finally, run:

```php?start_inline=1
php artisan vendor:publish --provider="Novius\Backpack\Slideshow\SlideshowServiceProvider" --tag="routes"
php artisan vendor:publish --provider="Novius\Backpack\Slideshow\SlideshowServiceProvider" --tag="lang"
php artisan vendor:publish --provider="Novius\Backpack\Slideshow\SlideshowServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Novius\Backpack\Slideshow\SlideshowServiceProvider" --tag="views"
php artisan vendor:publish --provider="Novius\Backpack\Slideshow\SlideshowServiceProvider" --tag="config"

php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"

php artisan migrate
```


## Usage & Features

### Integration on admin panel:

Add code bellow to : `resources/views/vendor/backpack/base/inc/sidebar.blade.php` 

```php
<li>
  <a href="{{ route('crud.slideshow.index') }}" title="">
    <i class="fa fa-picture-o"></i>
    <span>{{ trans('backpack_slideshow::slideshow.slideshow') }}</span>
  </a>
</li>
```

### You can go and create your slideshow.

### Then you can display your slideshow like this:
```php
// The function "display" takes one parameter:
//  1. Slug => Identifies the slideshow
<?php echo \Novius\Backpack\Slideshow\Models\Slideshow::display('slugOfMySlideshow'); ?>
```
### Feel free to override the base view to suit your needs.
```
/resources/views/vendor/laravel-backpack-slideshow/slider.blade.php
```
## Testing

Run the tests with:

```bash
./test.sh
```


## Lint

Run php-cs with:

```bash
./cs.sh
```


## Contributing

Contributions are welcome!
Leave an issue on Github, or create a Pull Request.


## Licence

This package is under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
