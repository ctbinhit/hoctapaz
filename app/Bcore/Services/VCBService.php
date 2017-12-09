<?php

namespace App\Bcore\Services;

class VCBService {

    public static function bank_accounts($bank_id) {
        return json_decode(file_get_contents('https://santienao.com//api/v1/bank_accounts/' . $bank_id));
    }

}
