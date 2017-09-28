<?php

namespace Novius\Backpack\Slideshow\Models;

use Backpack\CRUD\CrudTrait;
use Backpack\CRUD\ModelTraits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 *
 * Class Slideshow
 * @package Novius\Backpack\Slideshow\Models
 */
class Slideshow extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $table = 'slideshows';
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'format'];
    protected $translatable = ['title'];

    public function ratio() : int
    {
        $ratio = 1;
        $format = $this->format();
        if (!empty($format)) {
            $width = (int) array_get($format, 'width');
            $height = (int) array_get($format, 'height');
            if ($width > 1 && $height > 1) {
                $ratio = ceil($width / $height);
            }
        }

        return $ratio;
    }

    public function format() : array
    {
        return array_get(config('backpack.slideshow.formats', []), $this->format);
    }

    public function mediaCollection() : string
    {
        return $this->format;
    }
}
