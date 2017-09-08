<?php

namespace Novius\Backpack\Slideshow\Models;

use Backpack\CRUD\CrudTrait;
use Backpack\CRUD\ModelTraits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $table = 'slideshows';
    protected $primaryKey = 'id';

    protected $fillable = ['title'];
    protected $translatable = ['title'];
}
