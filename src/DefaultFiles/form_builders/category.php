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
            'type' => 'media',
            'name' => 'image',
            'parent_class' => 'col-md-12',
            'label' => [
                'text' => [
                    'tr' => 'Görsel',
                    'en' => 'Image',
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
                    'tr' => 'Kategori Adı',
                    'en' => 'Category Name',
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
                    'tr' => 'Kategori Slug',
                    'en' => 'Category Slug',
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
                    'tr' => 'Kategori Detay',
                    'en' => 'Category Detail',
                ],
            ],
        ],
    ],
    'metas' => [
        [
            'type' => 'title',
        ],
        [
            'type' => 'description',
        ],
    ],
];
