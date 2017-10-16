<?php

return [
    'formats' => [
        /*
        |--------------------------------------------------------------------------
        | Slideshow format list
        |--------------------------------------------------------------------------
        |
        | Adds new formats as you like. The corresponding translation is needed.
        | Use the media_key as index in the translation file.
        |
        | The main formats are listed when editing a slideshow.
        | If you edit a slide, the related main and sub formats will be created on saving.
        |
        */
        'default' => [
            'media_key' => 'main',
            'width' => 1060,
            'height' => 500,
            'sub_formats' => [
                [
                    /*
                    | This format is intended for the thumbnail in the list of slides in the Back-office
                    | This format is mandatory, otherwise it will be added by default.
                    */
                    'media_key' => 'thumb',
                    'width' => 145,
                    'height' => 95,
                ],
                [
                    /*
                    | This format is intended for instance for the slide when using a mobile version.
                    */
                    'media_key' => 'resize',
                    'width' => 600,
                    'height' => 200,
                ],
            ],
        ],
    ],
];
