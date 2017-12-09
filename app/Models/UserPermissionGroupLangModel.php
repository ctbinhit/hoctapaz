<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermissionGroupLangModel extends Model {

    protected $table = 'users_permission_groups_lang';
    // Tắt chế độ cập nhật ngày giờ
    public $timestamps = false;
    // [Bảo mật] không cho user cập nhật những field này
    protected $guarded = ['id', 'id_lang', 'id_permission_group', 'tbl'];

    public function db_rela_group() {
        return $this->belongsTo('App\Models\UserPermissionGroupModel', 'id', 'id_permission_group');
    }

   

}
