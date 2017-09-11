<a class="btn btn-default btn-xs" href="{{ route('crud.slide.index', ['slideshow' => $entry->getKey()]) }}">
    <i class="fa fa-pencil"></i>
    {{ trans('backpack_slideshow::slideshow.manage_slides') }}
</a>
