<?php

namespace Novius\Backpack\Slideshow\Http\Controllers\Admin;

use Novius\Backpack\CRUD\Http\Controllers\CrudController;
use Novius\Backpack\Slideshow\Http\Requests\Admin\SlideshowRequest as StoreRequest;
use Novius\Backpack\Slideshow\Http\Requests\Admin\SlideshowRequest as UpdateRequest;
use Novius\Backpack\Slideshow\Models\Slide;
use Novius\Backpack\Slideshow\Models\Slideshow;

class SlideshowCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Slideshow::class);
        $this->crud->setRoute(config('backpack.base.route_prefix').'/slideshow');
        $this->crud->setEntityNameStrings(trans('backpack_slideshow::slideshow.slideshow'), trans('backpack_slideshow::slideshow.slideshows'));
        $this->crud->addButtonFromView('line', 'show_slides', 'slideshow-show-slides', 'beginning');

        $this->crud->addfield([
            'name' => 'title',
            'label' => trans('backpack_slideshow::slideshow.title'),
            'box' => trans('backpack_slideshow::slideshow.details'),
        ]);

        $formats = collect(config('backpack.slideshow.formats', []))->map(function ($format, $key) {
            return trans('backpack_slideshow::slideshow.format.'.$key);
        })->toArray();

        $this->crud->addfield([
            'name' => 'format',
            'label' => trans('backpack_slideshow::slideshow.format.label'),
            'type' => 'select_from_array',
            'options' => $formats,
            'allows_null' => false,
            'box' => trans('backpack_slideshow::slideshow.options'),
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => trans('backpack_slideshow::slideshow.slug.label'),
            'type' => 'text',
            'attributes' => [
                'disabled' => 'disabled',
                'title' => trans('backpack_slideshow::slideshow.slug.title'),
            ],
        ]);

        $this->crud->setBoxOptions(trans('backpack_slideshow::slideshow.options'), [
            'side' => true,
            'class' => 'box-info',
        ]);

        $this->crud->addColumn([
            'name' => 'title',
            'label' => trans('backpack_slideshow::slideshow.title'),
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        return parent::storeCrud($request);
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud($request);
    }

    /**
     * We manually delete related images.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $slides = Slide::where('slideshow_id', $id)->get();

        foreach ($slides as $slide) {
            $slide->clearMediaCollection();
            $slide->delete();
        }

        return parent::destroy($id);
    }
}
