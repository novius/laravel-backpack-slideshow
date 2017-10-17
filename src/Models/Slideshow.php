<?php

namespace Novius\Backpack\Slideshow\Models;

use Backpack\CRUD\CrudTrait;
use Backpack\CRUD\ModelTraits\SpatieTranslatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\View\View;

/**
 * @property string $title
 * @property mixed slug
 *
 * Class Slideshow
 * @package Novius\Backpack\Slideshow\Models
 */
class Slideshow extends Model
{
    use CrudTrait;
    use HasTranslations;
    use Sluggable;

    protected $table = 'slideshows';
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'format'];
    protected $translatable = ['title'];

    /**
     * Mandatory sub-formats which are added in runtime if they are missing in the config file.
     *
     * @var array
     */
    protected static $mandatorySubformats = [
        'thumb' => [
            'media_key' => 'thumb',
            'width' => 50,
            'height' => 50,
        ],
        'resize' => [
            'media_key' => 'resize',
            'width' => 600,
            'height' => 200,
        ],
    ];

    public function ratio(): int
    {
        $ratio = 1;
        $format = $this->format();
        if (!empty($format)) {
            $width = (int) array_get($format, 'width');
            $height = (int) array_get($format, 'height');
            if ($width > 1 && $height > 1) {
                $ratio = $width / $height;
            }
        }

        return $ratio;
    }

    /**
     * Retrieves main slideshow format from config file
     * @return array
     */
    public function format(): array
    {
        return array_get(config('backpack.slideshow.formats', []), $this->format);
    }

    /**
     * Retrieves sub-formats of a main format. Adds missing mandatory formats.
     *
     * @param $format
     * @param $isMainFormat
     * @return array
     */
    public function subFormat($format, $isMainFormat): array
    {
        $subFormats = array_get($format, 'sub_formats', []);

        $subFormats = $isMainFormat ? $this->addMandatorySubformats($subFormats) : $subFormats;

        return $subFormats;
    }

    public function mediaCollection(): string
    {
        return $this->format;
    }

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class, 'slideshow_id');
    }

    public static function display($slug): View
    {
        $slider = static::where('slug', $slug)
            ->first();
        $slides = !empty($slider) ? $slider->slides : collect();

        return view('laravel-backpack-slideshow::slider', ['slides' => $slides]);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    public function getSlugOrTitleAttribute(): string
    {
        return $this->slug != '' ? $this->slug : $this->title;
    }

    protected function addMandatorySubformats(array $subFormats): array
    {
        foreach (array_keys(static::$mandatorySubformats) as $mandatorySubformat) {
            $mandatorySubformatExist = false;
            foreach ($subFormats as $subFormat) {
                if ($subFormat['media_key'] == $mandatorySubformat) {
                    $mandatorySubformatExist = true;
                }
            }
            if (!$mandatorySubformatExist) {
                array_push($subFormats, static::$mandatorySubformats[$mandatorySubformat]);
            }
        }

        return $subFormats;
    }
}
