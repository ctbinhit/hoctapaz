<?php

// ========== TOAN NANG Co., Ltd =======================================================================================
// Hotline: 0964 247 742 (Bình Cao)
// Email: info.toannang@gmail.com | binhcao.toannang@gmail.com
// 2th Floor, SBI Town ,Quang Trung Software City , Tan Chanh Hiep Ward ,District 12, Ho Chi Minh City.                
// =====================================================================================================================

return [
    'Author' => 'TOANNANGCO',
    'DefaultLanguage' => 'VN',
    'Debug' => true,
    'PageExtension' => '.html',
    'Route' => [
        'Admin' => 'administrator',
        'Collaborator' => 'doi-tac',
        'Client' => ''
    ],
    'Module' => [
        'prefix' => 'mdle_'
    ],
    // ----- Sync ------------------------------------------------------------------------------------------------------
    'Sync' => [
        'Google' => [
            'Active' => true,
            'AutoSync' => true
        ],
        'Dropbox' => [
            'Active' => false,
            'AutoSync' => true
        ],
        'S3' => [
            'Active' => false,
            'AutoSync' => true
        ],
    ],
    'Limit' => [
        'Filesize' => [
            '#' => 10000,
            'doc|xls|ppt|pdf|rar|zip|docx|pptx|xlsx|DOC|XLS|PPT|PDF|RAR|WIN|ZIP|DOCX|PPTX|XLSX' => 25000,
            'jpg|png|jpeg|gif|swf|JPG|PNG|JPEG|GIF' => 10000,
            'mp3,mp4,3gp,avi' => 50000
        ]
    ],
    // -----------------------------------------------------------------------------------------------------------------
    'ClientSecret' => [
        '24ed56e776fd6865f9c6ec9f1fb019b9', // Toannang.com.vn
        '51a451791c265db80e576419b578e3c5', // 127.0.0.1
        'c85119e9e9ed8c0f61ce95bf72d6f680', // ThietKeWebTN.com
        'd8e7852877badd03ebf274f08fc78534', // IP HOME
        '6094b9e3474a62fa543d046a2ea105e0', // 192.168.1.223
        'd8da1c1d50826e77c03536b2634bd372', // http://116.193.72.10
        '8176a1bbe53afa1bd0f4a87590690273' // 192.168.31.77
    ],
        // -----------------------------------------------------------------------------------------------------------------
];


