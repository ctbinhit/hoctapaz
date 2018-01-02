<?php

/*
 * View Framework - Build 09-2017 - Created by Bình Cao
 */
return [
    'default' => [
        'title' => 'Danh mục',
        'limit' => 2,
        'viewCount' => 5,
        'draggable' => true,
        'fields' => [
            'name' => ['visible' => true, 'text' => 'Tên danh mục', 'suggestion' => null],
            'name_meta' => ['visible' => true, 'text' => 'Tên Slug', 'suggestion' => 'Địa chỉ URL'],
            'ordinal_number' => ['visible' => true, 'text' => 'Số thứ tự', 'suggestion' => null],
            'description' => ['visible' => true, 'text' => 'Mô tả', 'suggestion' => null],
            'description' => ['visible' => false, 'text' => 'Nội dung', 'suggestion' => null, 'ckeditor' => true],
            'highlight' => ['visible' => true, 'text' => 'Nổi bật', 'suggestion' => null, 'defaultValue' => false],
            'display' => ['visible' => true, 'text' => 'Nổi bật', 'suggestion' => null, 'defaultValue' => true],
            'photo' => ['visible' => false, 'text' => 'Photo', 'suggestion' => null, 'mimes' => ['jpg', 'png'], 'sizeLimit' => 50000],
            'seo_title' => ['visible' => true, 'text' => 'Tên Slug', 'suggestion' => 'Tối đa 166 ký tự để được seo tốt nhất.'],
            'seo_keywords' => ['visible' => true, 'text' => 'Tên Slug', 'suggestion' => 'Nên dùng từ khóa phù hợp với nội dung danh mục'],
            'seo_description' => ['visible' => true, 'text' => 'Tên Slug'],
        ],
        'validate' => [
            'name' => 'required|min:6|max:255',
            'name_meta' => 'required|max:255',
            'ordinal_number' => 'numeric'
        ]
    ],
    'types' => [
        'hoctap' => [
            'title' => 'Danh mục AZ',
            'limit' => 3
        ],
        'tin-tuc' => [
            'title' => 'Danh mục tin tức',
            'limit' => 5
        ],
        'san-pham' => [
            'title' => 'Danh mục sản phẩm',
            'limit' => 10
        ]
    ]
];
