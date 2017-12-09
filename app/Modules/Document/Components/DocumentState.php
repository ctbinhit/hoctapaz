<?php

namespace App\Modules\Document\Components;

use App\Modules\Document\Components\DocumentState;

class DocumentState {

    function __construct() {
        
    }

    public static function get_listState() {
        return [
            DocumentState::approve() => DocumentState::get_stateText(DocumentState::approve()),
            DocumentState::reject() => DocumentState::get_stateText(DocumentState::reject()),
            DocumentState::reject() => DocumentState::get_stateText(DocumentState::reject()),
            DocumentState::pending() => DocumentState::get_stateText(DocumentState::pending()),
            DocumentState::free() => DocumentState::get_stateText(DocumentState::free()),
            DocumentState::need_to_change() => DocumentState::get_stateText(DocumentState::need_to_change()),
        ];
    }

    public static function approve() {
        return 'approve';
    }

    public static function reject() {
        return 'reject';
    }

    public static function pending() {
        return 'pending';
    }

    public static function need_to_change() {
        return 'need_to_change';
    }

    public static function free() {
        return 'free';
    }

    public static function get_stateText($state) {
        switch ($state) {
            case DocumentState::approve(): return 'Đang bán.';
            case DocumentState::reject(): return 'Bị từ chối.';
            case DocumentState::pending():return 'Đang chờ duyệt.';
            case DocumentState::free(): return 'Tự do';
            case DocumentState::need_to_change(): return 'Cần thay đổi để duyệt';
            default: return 'Undefined';
        }
    }

    public static function set_documentStateTextByModels($Models) {
        try {
            if (count($Models) == 0) {
                return $Models;
            }
            foreach ($Models as $k => $v) {
                switch ($v->state) {
                    case DocumentState::approve(): $v->state_text = 'Đang bán.';
                        break;
                    case DocumentState::reject(): $v->state_text = '<b class="text-danger">Bị từ chối.</b>';
                        break;
                    case DocumentState::pending(): $v->state_text = 'Đang chờ duyệt.';
                        break;
                    case DocumentState::free(): $v->state_text = 'Tự do';
                        break;
                    case DocumentState::need_to_change(): $v->state_text = 'Cần thay đổi để duyệt';
                        break;
                    default:
                        $v->state_text = 'Undefined';
                }
            }
            return $Models;
        } catch (\Exception $ex) {
            return $Models;
        }
    }

}
