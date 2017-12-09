<?php

/* =============================== TOANNANG Co., Ltd ===================================================================
  | Author: Bình Cao | Phone: (+84) 964 247 742 | Email: ctbinhit@gmail.com or binhcao.toannang@gmail.com
  | Version: 1.0 | 28/08/2017 01:00:00 AM
  | --------------------------------------------------------------------------------------------------------------------
  | visible: Boolean (true | false)
  | title: String (Name, Description, Display...)
  | width: String (2%,10%...)
  | className: String (center, td-body-center...)
  | note: String (suggestions for this input...)
  | ====================================================================================================================
 */

return [
    'title' => 'label.danhmuc',
    'sort' => [],
    'lenght' => [
        // -1: Tất cả
        10, 20, 50, 100, 500, -1
    ],
    'CategoryLevel' => 1,
    'buttons' => array(
        'pdf' => array(
        )
    ),
    'columns' => array(
        'ordinal_number' => array(
            'visible' => true,
            'title' => 'STT',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'views' => array(
            'visible' => true,
            'title' => 'label.luotxem',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'category' => array(
            'visible' => true,
            'title' => 'label.danhmuc',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'name' => array(
            'visible' => true,
            'title' => 'label.ten',
            'width' => '20%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'description' => array(
            'visible' => true,
            'ckeditor' => false,
            'title' => 'label.mota',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'description2' => array(
            'visible' => false,
            'title' => 'label.mota',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'content' => array(
            'visible' => true,
            'ckeditor' => true,
            'title' => 'label.noidung',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'created_at' => array(
            'visible' => true,
            'title' => 'label.ngaytao',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'photo' => array(
            'visible' => true,
            'title' => 'label.thaotac',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        // SEO
        'seo_title' => array(
            'visible' => true,
            'title' => 'label.tieude',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'seo_description' => array(
            'visible' => true,
            'title' => 'label.mota',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => 'tooltip.deseoduoctotnhatnengioihanduoi166kytu'
        ),
        'seo_keywords' => array(
            'visible' => true,
            'title' => 'label.tukhoa',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => 'tooltip.nendungnhungtukhoanang'
        ),
        'highlight' => array(
            'visible' => true,
            'title' => 'label.noibat',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'display' => array(
            'visible' => true,
            'title' => 'label.noibat',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
        'action' => array(
            'visible' => true,
            'title' => 'label.thaotac',
            'width' => '2%',
            'className' => 'dt-body-center',
            'note' => ''
        ),
    )
];

