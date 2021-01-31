<?php

return [
    'general' => [
        [
            'type' => 'radio',
            'name' => 'status',
            'parent_class' => 'col-md-6',
            'label' => [
                'text' => [
                    'tr' => 'Durum',
                    'en' => 'Status',
                ],
            ],
            'input' => [
                'attributes' => [
                    'class' => 'custom-control-input'
                ],
            ],
            'options' => [
                [
                    'value' => 1,
                    'text' => [
                        'tr' => 'Aktif',
                        'en' => 'Active',
                    ],
                    'color' => 'success',
                ],
                [
                    'value' => 2,
                    'text' => [
                        'tr' => 'Taslak',
                        'en' => 'Draft',
                    ],
                    'color' => 'light',
                ],
                [
                    'value' => 3,
                    'text' => [
                        'tr' => 'Pasif',
                        'en' => 'Passive',
                    ],
                    'color' => 'danger',
                ]
            ]
        ],
        [
            'type' => 'input',
            'name' => 'order',
            'parent_class' => 'col-md-6',
            'label' => [
                'text' => [
                    'tr' => 'Sıralama',
                    'en' => 'Order',
                ],
            ],
            'input' => [
                'attributes' => [
                    'class' => 'form-control',
                    'type' => 'number',
                ],
            ],
        ],
        [
            'type' => 'media',
            'name' => 'image',
            'parent_class' => 'col-md-12 mt-3',
            'label' => [
                'text' => [
                    'tr' => 'Sayfa Görseli',
                    'en' => 'Page Image',
                ],
            ],
            'max_media_count' => 1,
            'media_type' => 'image'
        ],
    ],
    'languages' => [
        [
            'type' => 'radio',
            'name' => 'detail.status',
            'parent_class' => 'col-md-12',
            'label' => [
                'text' => [
                    'tr' => 'Durum',
                    'en' => 'Status',
                ],
            ],
            'input' => [
                'attributes' => [
                    'class' => 'custom-control-input'
                ],
            ],
            'options' => [
                [
                    'value' => 1,
                    'text' => [
                        'tr' => 'Aktif',
                        'en' => 'Active',
                    ],
                    'color' => 'success',
                ],
                [
                    'value' => 3,
                    'text' => [
                        'tr' => 'Pasif',
                        'en' => 'Passive',
                    ],
                    'color' => 'danger',
                ]
            ]
        ],
        [
            'type' => 'input',
            'name' => 'detail.name',
            'parent_class' => 'col-md-6',
            'label' => [
                'text' => [
                    'tr' => 'Sayfa Adı',
                    'en' => 'Page Name',
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
                    'tr' => 'Sayfa Slug',
                    'en' => 'Page Slug',
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
                    'tr' => 'Sayfa Detayı',
                    'en' => 'Page Detail',
                ],
            ],
        ],
    ],
];
