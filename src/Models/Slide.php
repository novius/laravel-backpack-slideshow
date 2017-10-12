<?php

namespace Novius\Backpack\Slideshow\Models;

use Backpack\CRUD\CrudTrait;
use Backpack\CRUD\ModelTraits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Novius\Backpack\CRUD\ModelTraits\UploadableImage;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Slide extends Model implements HasMediaConversions
{
    use CrudTrait;
    use HasMediaTrait;
    use HasTranslations;
    use UploadableImage;

    public $registerMediaConversionsUsingModelInstance = true;

    protected $table = 'slideshow_slides';
    protected $primaryKey = 'id';

    protected $fillable = [
        'slideshow_id',
        'image',
        'title',
        'subtitle',
        'text',
        'link',
        'page_id',
        'parent_id',
        'lft',
        'rgt',
        'depth',
    ];

    protected $translatable = ['title', 'subtitle', 'text', 'link', 'page_id'];

    public function uploadableImages() : array
    {
        return [
            ['name' => 'image', 'slug' => 'title'],
        ];
    }

    public function thumbnailAdmin() : string
    {
        $thumbnail = '';
        $medias = $this->getMedia($this->slideshow->mediaCollection());
        if (!empty($medias)) {
            $url = $this->getFirstMediaUrl($this->slideshow->mediaCollection(), 'thumb');
            $thumbnail = '<img src="'.$url.'?v='.uniqid().'" />';
        }

        return $thumbnail;
    }

    public function slideshow()
    {
        return $this->belongsTo(Slideshow::class, 'slideshow_id');
    }

    /**
     * Overrides UploadableImage Trait
     *
     * @param string $imageAttributeName
     * @param string $imagePath
     * @param string $diskName
     * @return bool
     */
    public function imagePathSaved(string $imagePath, string $imageAttributeName = null, string $diskName = null) : bool
    {
        $this->addMedia($imagePath)
            ->preservingOriginal()
            ->toMediaCollection();

        return true;
    }

    /**
     * Overrides UploadableImage Trait
     *
     * @param string $imagePath
     * @param string|null $imageAttributeName
     * @param string|null $diskName
     * @return bool
     */
    public function imagePathDeleted(string $imagePath, string $imageAttributeName = null, string $diskName = null) : bool
    {
        $this->clearMediaCollection();

        return true;
    }

    public function registerMediaConversions()
    {
        $this->createMediaConversion($this->slideshow->format(), $this->slideshow->mediaCollection());
    }

    /**
     * @param $format
     * @param $collection
     * @param bool $isMainFormat We add mandatory sub-formats only in main-formats.
     * @return bool
     */
    protected function createMediaConversion($format, $collection, $isMainFormat = true) : bool
    {
        if ($format) {
            $mediaKey = (string) array_get($format, 'media_key');
            $width = (int) array_get($format, 'width');
            $height = (int) array_get($format, 'height');
            $subFormats = $this->slideshow->subFormat($format, $isMainFormat);

            $this->addMediaConversion($mediaKey)
                ->width($width)
                ->height($height)
                ->optimize()
                ->performOnCollections($collection);

            foreach ($subFormats as $subFormat) {
                $this->createMediaConversion($subFormat, $collection, false);
            }
        }

        return true;
    }
}
