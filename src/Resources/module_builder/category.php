<?php

return [
    [
        'translation' => true,
        'name' => 'name',
        'element' => 'input',
        'type' => 'text',
        'parent_class' => 'col-lg-6',
        'labels' => [
            '164' => 'Sayfa Adı',
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
    ]
];
