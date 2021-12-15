<?php

return [
    [
        'translation' => false,
        'name' => 'status',
        'element' => 'radio',
        'parent_class' => 'col-lg-6',
        'labels' => [
            '164' => 'Durum',
            '40' => 'Status',
        ],
        'rules' => [
            'required'
        ],
        'options' => [
            [
                'key' => 1,
                'value' => [
                    '164' => 'Aktif',
                    '40' => 'Active',
                ],
            ],
            [
                'key' => 0,
                'value' => [
                    '164' => 'Pasif',
                    '40' => 'Passive',
                ]
            ],
        ]
    ],
    [
        'translation' => true,
        'name' => 'name',
        'element' => 'input',
        'type' => 'text',
        'parent_class' => 'col-lg-6',
        'labels' => [
            '164' => 'Kategori Adı',
            '40' => 'Name',
        ],
        'rules' => [
            'required', 'min:2'
        ]
    ],
    [
        'translation' => true,
        'name' => 'slug',
        'element' => 'slug',
        'parent_class' => 'col-lg-6',
        'labels' => [
            '164' => 'Slug',
            '40' => 'Slug',
        ],
        'rules' => [
            'required_if:languages.*,1'
        ]
    ],
];
