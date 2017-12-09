<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model {

    public $items_inserted = 0;
    protected $table = 'menu';
    public $timestamp = true;

    public function get_items() {
        return MenuModel::all();
    }

    public function insert_items($pData) {
        return MenuModel::insert($pData);
        $this->items_inserted++;
    }

    public function check_item_exists($pIdItem) {
        $item = MenuModel::where('id', '=', trim($pIdItem))->first();
        if ($item != null)
            return true;
        return false;
    }

    public function finish_all() {
        if ($this->items_inserted === 0) {
            // OK
        } else {
            // Reload and apply new menu
            redirect()->route('admin_index');
        }
    }

}
