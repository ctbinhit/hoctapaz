<?php

namespace App\Bcore\Services;

use DB;
use App\Modules\Document\Components\DocumentState;
use Illuminate\Support\Facades\Storage;

class FileServiceV3 {

    private $_object = null;
    private $_data = null;
    private $_options = [
        'lang' => null,
        'select' => null,
        'where' => [],
        'orderBy' => [],
        'pagination' => null
    ];
    private $_log = null;
    private $_logs = null;

    function __construct() {
        $this->_options = (object) json_decode(json_encode($this->_options));
        $this->init();
    }

    public function init() {
        $this->_options->select = [
            'files.*', 'users.fullname',
            'categories_lang.name as name_category'
        ];
        $this->_options->lang = 1;
    }

    public function filter_byMimes($mimes) {
        switch ($mimes) {
            case 'pdf':
                $this->_options->where[] = ['mimetype', 'application/pdf'];
                break;
            case 'word':
                $this->_options->where[] = ['mimetype', 'application/word'];
                break;
            default:
                break;
        }
    }

    public function set_option($option_name, $value) {
        switch ($option_name) {
            case 'select':
                $this->_options->select = $value;
                break;
        }
        return $this;
    }

    public function set_where($field, $value, $op = '=') {
        $this->_options->where[] = [$field, $op, $value];
        return $this;
    }

    public function set_lang($id_lang) {
        $this->_options->lang = $id_lang;
        return $this;
    }

    public function set_pagination($count) {
        $this->_options->pagination = is_numeric($count) ? $count : 5;
        return $this;
    }

    public function set_orderBy($field, $type = 'ASC') {
        $this->_options->orderBy[] = [$field, $type];
        return $this;
    }

    public function get_model() {
        $this->parseOptions();
        return $this->_object->first();
    }

    public function get_models() {
        $this->parseOptions();
        if ($this->_options->pagination) {
            return $this->_object->paginate($this->_options->pagination);
        }
        return $this->_object->get();
    }

    public function search($keywords) {
        if ($keywords != null)
            $this->_options->where[] = ['files.name', 'LIKE', "%$keywords%"];
        return $this;
    }

    public static function findFileByModels($models) {
        foreach ($models as $v) {
            $FileModel = \App\Models\FileModel::orderBy('id', 'desc');
            $FileModel->where('obj_id', $v->id);
            $FileModel->where('id_user', $v->id_user);
            $FileModel->where('tbl', $v->tbl);
            $FileModel->where('obj_type', $v->type);
            $file = $FileModel->first();
            if ($file == null) {
                $v->demo_url = null;
            } else {
                $v->demo_url = Storage::disk('localhost')->url($file->url);
            }
        }
        return $models;
    }

    private function parseOptions() {
        $this->parseDefaultOptions();
        $object = DB::table('files')
                ->join('users', 'users.id', '=', 'files.id_user')
                ->leftJoin('categories_lang', 'categories_lang.id_category', '=', 'files.id_category');
        $object->where($this->_options->where);
        $object->select($this->_options->select);
        $object->where('categories_lang.id_lang', $this->_options->lang);
        foreach ($this->_options->orderBy as $ob) {
            $object->orderBy($ob[0], $ob[1]);
        }

        $this->_object = $object;
    }

    private function parseDefaultOptions() {
        $this->_options->where[] = ['files.id', '>', -1];
    }

}
