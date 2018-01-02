<?php

namespace App\Bcore\Services;

use App\Models\CategoryLangModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CategoryService {

    private $_type = null;
    private $_lang = null;
    private $_data = null;

    public static function data_cache($obj_table, $obj_type) {
        Cache::forget('CACHE_CATEGORY_' . $obj_type . '_' . $obj_table);
        return Cache::remember('CACHE_CATEGORY_' . $obj_type . '_' . $obj_table, 1000 * 30, function() use ($obj_table, $obj_type) {
                    $Models = DB::table('categories')
                            ->where('categories.obj_table', '=', $obj_table)
                            ->where('categories.type', '=', $obj_type)
                            ->where('categories_lang.id_lang', 1)
                            ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                            ->select([
                        'categories.*', 'categories_lang.name', 'categories_lang.name_meta',
                        'categories_lang.seo_title', 'categories_lang.seo_description', 'categories_lang.seo_keywords'
                    ]);
                    return $Models->get();
                });
    }

    public static function get_levelCate($id, $models, $lv = 0) {
        $this_model = $models->where('id', $id)->first();

        if ($this_model->id_category == null) {
            return $lv;
        } else {
            return CategoryService::get_levelCate($this_model->id_category, $models, $lv + 1);
        }
    }

    public static function html_getSubCate($Models, $id_parent, $level = 1) {
        $r = [];
        $Models_TMP = $Models->where('id_category', $id_parent);
        if (count($Models_TMP) == 0) {
            return [];
        }

        foreach ($Models_TMP as $k => $v) {
            $tmp_check = $Models->where('id_category', $v->id);

            $sub_name = '';
            for ($i = 0; $i < $level; $i++) {
                if (count($tmp_check) != 0) {
                    $sub_name .= '&HorizontalLine;';
                } else {
                    $sub_name .= '&HorizontalLine;';
                }
            }

            $v->name = $sub_name . $v->name;
            if (count($tmp_check) != 0) {
                $v->can_select = 0;
            } else {
                $v->can_select = 1;
            }
            $r[] = $v;


            if (count($tmp_check) != 0) {
                $r = array_merge($r, CategoryService::html_getSubCate($Models, $v->id, $level += 1));
            } else {
                
            }
        }
        return $r;
    }

    public static function html_selectCategories($obj_type, $obj_table = 'categories') {
        $Models = CategoryService::data_cache($obj_table, $obj_type);
        $CategoriesParent = $Models->where('id_category', null);
        $LIST_CATES = [];
        foreach ($CategoriesParent as $k => $v) {
            $v->name = $v->name;
            $tmp_check = $Models->where('id_category', $v->id);
            if (count($tmp_check) != 0) {
                $v->can_select = 0;
            } else {
                $v->can_select = 1;
            }
            $LIST_CATES[] = $v;
            if (count($tmp_check) != 0) {
                $LIST_CATES = array_merge($LIST_CATES, CategoryService::html_getSubCate($Models, $v->id));
            }
        }
        return $LIST_CATES;
    }

    public function set_type($type) {
        $this->_type = $type;
        return $this;
    }

    public function set_lang($id_lang) {
        $this->_lang = $id_lang;
        return $this;
    }

    public static function getNameById($id_category) {
        try {
            return \App\Models\CategoryLangModel::
                    where([
                        ['id_lang', 1],
                        ['id_category', $id_category]
                    ])->first()->name;
        } catch (\Exception $ex) {
            return 'Null';
        }
    }

    public function data() {
        if (method_exists($this->_data, 'get')) {
            return $this->_data->get();
        }
        return null;
    }

    public static function get_baseCategories($obj_type, $obj_table) {
        $Models = DB::table('categories')
                ->where('categories_lang.id_lang', '=', 1)
                ->where('categories.id_category', '=', null)
                ->where('categories.type', '=', $obj_type)
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->select([
            'categories.*',
            'categories_lang.name', 'categories_lang.name_meta',
            'categories_lang.seo_title', 'categories_lang.seo_description', 'categories_lang.seo_keywords'
        ]);
        return $Models->get();
    }

    public static function get_arrayIdFromIdParent($id) {
        $CategoriesModel = DB::table('categories')
                        ->where('categories_lang.id_lang', '=', 1)
                        ->where('categories.id_category', $id)
                        ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                        ->select([
                            'categories.*', 'categories_lang.name', 'categories_lang.name_meta',
                            'categories_lang.seo_title', 'categories_lang.seo_description', 'categories_lang.seo_keywords'
                        ])->get();

        if (count($CategoriesModel) == 0) {
            return [];
        }
        $r = [];
        foreach ($CategoriesModel as $k => $v) {
            $r[] = $v->id;
        }
        return $r;
    }

    public static function get_childCateByIdParent($id) {
        $Models = DB::table('categories')
                ->where('categories_lang.id_lang', '=', 1)
                ->where('categories.id_category', '=', $id)
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->select([
            'categories.*', 'categories_lang.name', 'categories_lang.name_meta'
        ]);
        return $Models->get();
    }

    public static function find_byNameMeta($name_meta) {
        $Models = DB::table('categories')
                ->where('categories_lang.id_lang', '=', 1)
                ->where('categories_lang.name_meta', '=', $name_meta)
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->select([
            'categories.*', 'categories_lang.name', 'categories_lang.name_meta',
            'categories_lang.seo_title', 'categories_lang.seo_description', 'categories_lang.seo_keywords'
        ]);
        return $Models->first();
    }

    public function get_categoriesByParentId($id) {
        $Models = DB::table('categories')
                ->where('categories.id_category', '=', $id)
                ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                ->select([
            'categories.*', 'categories_lang.name'
        ]);

        if ($this->_type != null) {
            $Models->where('type', '=', $this->_type);
        }

        if ($this->_lang != null) {
            $Models->where('id_lang', '=', $this->_lang);
        }

        return $Models->get();
    }

    public function get_categoriesByLv($level = 0, $flag_count = 0, $array_id = null) {
        if ($flag_count == 0) {
            $Models = DB::table('categories')
                    ->where('categories.id_category', '=', null)
                    ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                    ->select([
                'categories.id', 'categories_lang.name'
            ]);
            ;
        } else {

            if ($array_id == null || count($array_id) == 0) {
                return null;
            }

            $Models = DB::table('categories')
                    ->whereIn('categories.id_category', $array_id)
                    ->join('categories_lang', 'categories_lang.id_category', '=', 'categories.id')
                    ->select([
                'categories.id', 'categories_lang.name'
            ]);
        }


        if ($this->_type != null) {
            $Models->where('type', '=', $this->_type);
        }

        if ($this->_lang != null) {
            $Models->where('id_lang', '=', $this->_lang);
        }

        if ($level == $flag_count) {

            if ($flag_count == 0) {
                $this->_data = $Models;
            } else {
                return $Models;
            }
        } else {
            $this->_data = $this->get_categoriesByLv($level, $flag_count += 1, $this->convert_modelsToArrayId($Models->get()));
        }

        return $this;
    }

    public function convert_modelsToArrayId($models) {
        $r = [];
        foreach ($models as $k => $v) {
            $r[] = $v->id;
        }
        return $r;
    }

}
