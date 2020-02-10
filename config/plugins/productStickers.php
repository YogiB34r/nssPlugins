<?php
return [
    'settingPage' => [
        'pageTitle' => 'Product stickers',
        'menuTitle' => 'Product stickers',
        'capability' => 'manage_options',
        'menuSlug' => 'gf_product_sticker_options',
        'template' => 'productStickers'
    ],
    'registerSettings' => [
        'optionGroup' => 'gf_product_sticker_options',
        'options' => [
            'gf_product_sticker_options' =>[]
        ]
    ],
    'shortCode' => [
        'name' => 'productStickers',
        'template' => ''
    ],
];
