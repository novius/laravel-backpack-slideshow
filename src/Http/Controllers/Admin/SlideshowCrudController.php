<?php

namespace Novius\Backpack\Slideshow\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Novius\Backpack\Slideshow\Http\Requests\Admin\SlideshowRequest as StoreRequest;
use Novius\Backpack\Slideshow\Http\Requests\Admin\SlideshowRequest as UpdateRequest;
use Novius\Backpack\Slideshow\Models\Slideshow;

class SlideshowCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Slideshow::class);
        $this->crud->setRoute(config('backpack.base.route_prefix').'/slideshow');
        $this->crud->setEntityNameStrings(trans('backpack::slideshow.slideshow'), trans('backpack::slideshow.slideshows'));
        $this->crud->addButtonFromView('line', 'show_slides', 'slideshow-show-slides', 'beginning');

        $this->crud->addfield([
            'name' => 'title',
            'label' => trans('backpack::slideshow.title'),
        ]);

        $this->crud->addColumn([
            'name' => 'title',
            'label' => trans('backpack::slideshow.title'),
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
}
