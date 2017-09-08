<?php

namespace Novius\Backpack\Slideshow\Models;

use Backpack\CRUD\CrudTrait;
use Backpack\CRUD\ModelTraits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $table = 'slideshow_slides';
    protected $primaryKey = 'id';

    protected $fillable = ['slideshow_id', 'image', 'title', 'subtitle', 'text', 'link', 'page_id'];
    protected $translatable = ['image', 'title', 'subtitle', 'text', 'link'];
}
