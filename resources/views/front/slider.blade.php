@if($slides.isNotEmpty())
<div class="slider-container">
    <ul class="slides">
        @foreach($slides as $slide)
            <li data-thumb="<?php echo $slide->thumbnailUrl() ?>">
                @if($slide->href())
                    <a href="<?php echo $slide->href() ?>"><img src="<?php echo $slide->defaultUrl() ?>" alt="<?php echo $slide->title ?>"/></a>
                @else
                    <img src="<?php echo $slide->defaultUrl() ?>" alt="<?php echo $slide->title ?>"/>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endif