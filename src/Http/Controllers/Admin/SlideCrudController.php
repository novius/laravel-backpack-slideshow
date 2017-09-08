<?php

namespace Novius\Backpack\Slideshow\Http\Controllers\Admin;

use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Novius\Backpack\Slideshow\Http\Requests\Admin\SlideRequest as StoreRequest;
use Novius\Backpack\Slideshow\Http\Requests\Admin\SlideRequest as UpdateRequest;
use Novius\Backpack\Slideshow\Models\Slide;
use Novius\Backpack\Slideshow\Models\Slideshow;

class SlideCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Slide::class);
        $this->crud->setRoute(config('backpack.base.route_prefix').'/slide');
        $this->crud->setEntityNameStrings(trans('backpack::slideshow.slide'), trans('backpack::slideshow.slides'));

        $this->crud->addColumn([
            'name' => 'title',
            'label' => trans('backpack::slideshow.title'),
        ]);

        $this->crud->addfield([
            'name' => 'slideshow_id',
            'type' => 'hidden',
            'default' => (int) request('slideshow'),
        ]);

        $this->crud->addfield([
            'name' => 'image',
            'label' => trans('backpack::slideshow.image'),
            'type' => 'image',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
            'prefix' => 'storage/' // in case you only store the filename in the database, this text will be prepended to the database value
        ]);

        $this->crud->addfield([
            'name' => 'title',
            'label' => trans('backpack::slideshow.title'),
        ]);

        $this->crud->addfield([
            'name' => 'subtitle',
            'label' => trans('backpack::slideshow.subtitle'),
        ]);

        $this->crud->addfield([
            'name' => 'text',
            'label' => trans('backpack::slideshow.text'),
            'type' => 'ckeditor',
        ]);

        $this->crud->addfield([
            'name' => 'link',
            'label' => trans('backpack::slideshow.link'),
            'type' => 'page_or_link',
            'page_model' => Page::class,
        ]);

    }

    /**
     * List the slides of selected slideshow
     *
     * @return \Backpack\CRUD\app\Http\Controllers\Response
     */
    public function index()
    {
        $idSlideshow = \Request::get('slideshow');
        Slideshow::findOrFail($idSlideshow);

        $this->crud->addClause('where', 'slideshow_id', $idSlideshow);

        $this->crud->removeButton('create'); // Recreate bellow with slideshow GET parameter
        $this->crud->addButtonFromView('top', 'add_slide', 'slideshow-create-slide', 'beginning');

        return parent::index();
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create()
    {
        $idSlideshow = \Request::get('slideshow');
        Slideshow::findOrFail($idSlideshow);

        return parent::create();
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
