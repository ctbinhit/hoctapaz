<?php

namespace App\Bcore;

class RandomService Extends Bcore {

    public $name = [
        'vi' => [
            'an', 'ân',
            'bảo', 'bình',
            'cường',
            'danh', 'đinh',
            'thịnh', 'tín', 'tùng',
            'hoàng', 'hùng',
        ],
        'en' => [
            'join', 'jimmy', 'tony', 'alex'
        ]
    ];

    function __construct() {
        
    }

    public function get_name($pLang) {
        
    }

    public function get_filename($pPrefix = 'file_') {
        
    }

}
