<?php

return [
    'general' => [
    ],
    'languages' => [
        [
            'type' => 'input',
            'name' => 'detail.name',
            'parent_class' => 'col-md-6',
            'label' => [
                'text' => [
                    'tr' => 'Sayfa Yapısı Adı',
                    'en' => 'Container Name',
                ],
            ],
            'input' => [
                'attributes' => [
                    'class' => 'form-control'
                ],
            ],
        ],
        [
            'type' => 'input',
            'name' => 'detail.slug',
            'parent_class' => 'col-md-6',
            'label' => [
                'text' => [
                    'tr' => 'Sayfa Yapısı Slug',
                    'en' => 'Container Slug',
                ],
            ],
            'input' => [
                'attributes' => [
                    'class' => 'form-control'
                ],
            ],
        ],
        [
            'type' => 'ckeditor',
            'name' => 'detail.detail',
            'parent_class' => 'col-md-12',
            'label' => [
                'text' => [
                    'tr' => 'Sayfa Yapısı Detayı',
                    'en' => 'Container Detail',
                ],
            ],
        ],
    ],
];
