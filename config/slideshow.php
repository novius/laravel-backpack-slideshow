<?php

return [
    'formats' => [
        'default' => [
            'media_key' => 'default',
            'width' => 1200,
            'height' => 400,
            'sub_formats' => [
                [
                    'media_key' => 'thumb',
                    'width' => 50,
                    'height' => 50,
                ],
                [
                    'media_key' => 'resize',
                    'width' => 600,
                    'height' => 200,
                ],
            ],
        ],
    ],
];
