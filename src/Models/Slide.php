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
    use HasTranslations;
    use UploadableImage;
    use HasMediaTrait;

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

    public function uploadableImages()
    {
        return [
            ['name' => 'image', 'slug' => 'title'],
        ];
    }

    public function thumbnailAdmin()
    {
        $thumbnail = '';
        if (!empty($this->image)) {
            $thumbnail = '<img src="'.url('storage/'.$this->image).'?v='.uniqid().'" alt="" width="50" />';
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
        return true;
    }

    public function registerMediaConversions()
    {
        $format = $this->slideshow->format();
        $width = (int) array_get($format, 'width', 50);
        $height = (int) array_get($format, 'height', 50);

        $this->addMediaConversion('thumb')
            ->width($width)
            ->height($height)
            ->optimize();
    }
}
