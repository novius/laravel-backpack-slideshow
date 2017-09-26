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
     * Called after image saved on disk
     *
     * @param string $imageAttributeName
     * @param string $imagePath
     * @param string $diskName
     * @return bool
     */
    public function imagePathSaved(string $imageAttributeName, string $imagePath, string $diskName)
    {
        $this->addMedia($imagePath)
        ->preservingOriginal()
        ->toMediaCollection();

        return true;
    }

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50)
            ->optimize();
    }
}
