@if ($crud->hasAccess('create'))
    <a href="{{ route('crud.slide.create', ['slideshow' => request('slideshow')]) }}" class="btn btn-primary ladda-button" data-style="zoom-in">
        <span class="ladda-label">
            <i class="fa fa-plus"></i>
            {{ trans('backpack::crud.add') }} {{ $crud->entity_name }}
        </span>
    </a>
@endif
