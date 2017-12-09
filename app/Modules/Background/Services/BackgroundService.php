<?php

namespace App\Modules\Background\Services;

use App\Modules\Background\Models\BackgroundModel;
use Storage;

class BackgroundService {

    private $_BM = null;

    function __construct($pModel = null) {

        $this->_BM = $pModel;
    }

    public function get_background() {

        if ($this->_BM == null) {
            return false;
        }
    }

    public function get_url($pPrefix = 'bg_') {

        if ($this->_BM == null) {
            return false;
        }

        $path = 'background/' . $this->_BM->type . '/' . $this->_BM->url;
        $key = \Illuminate\Support\Facades\Crypt::encryptString($path);
        return route('background_url', $key);
    }

    public function convertCss() {

        if ($this->_BM == null) {
            return false;
        }
        $options = json_decode($this->_BM->options);

        $string = "background: url(" . $this->get_url() . ');';
        $string .= "background-position-x: " . $options->{'background-position-x'} . 'px;';
        $string .= "background-position-y: " . $options->{'background-position-y'} . 'px;';
        if (isset($options->{'background-size'})) {
            $string .= "background-size: " . $options->{'background-size'} . ';';
        }
        if (isset($options->{'background-repeat'})) {
            $string .= "background-repeat: " . $options->{'background-repeat'} . ';';
        }

        return $string;
    }

    public static function convertCssByType($type_background) {
        $BgModel = BackgroundModel::where([
            ['type', '=', $type_background], ['deleted_at', '=', null]
        ])->first();
        if ($BgModel == null) {
            return '';
        }
        $options = json_decode($BgModel->options);
        $string = "background: url(" . Storage::disk('localhost')->url("background/$type_background/".$BgModel->url) . ');';
        $string .= "background-position-x: " . $options->{'background-position-x'} . 'px;';
        $string .= "background-position-y: " . $options->{'background-position-y'} . 'px;';
        if (isset($options->{'background-size'})) {
            $string .= "background-size: " . $options->{'background-size'} . ';';
        }
        if (isset($options->{'background-repeat'})) {
            $string .= "background-repeat: " . $options->{'background-repeat'} . ';';
        }
        return $string;
    }

}
