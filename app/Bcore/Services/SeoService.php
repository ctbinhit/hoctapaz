<?php

/* =====================================================================================================================
  |                                SEARCH ENGINE OPTIMIZATION SERVICE - VER >=1.3 (09-2017)
  | --------------------------------------------------------------------------------------------------------------------
  | Created by Bình Cao | (+84) 964 247 742 | info@binhcao.com | binhcao.toannang.com
  | --------------------------------------------------------------------------------------------------------------------
  | Note: Easy ways to improve your website's navigation | Search engine
  | --------------------------------------------------------------------------------------------------------------------
  |                                             Developed by ToanNang Co., Ltd
  | ====================================================================================================================
 */

namespace App\Bcore\Services;

use App\Bcore\Bcore;
use LanguageService;
use Config,
    Session,
    Cache,
    View;

class SeoService extends Bcore {

    public function __construct() {
        parent::__construct();
    }

    // Lasted update 1.3.0.0

    public function seo_model($pModel) {

        if (isset($pModel->seo_title)) {
            View::share('seo_title', $pModel->seo_title);
        }
        if (isset($pModel->seo_description)) {
            View::share('seo_description', $pModel->seo_description);
        }
        if (isset($pModel->seo_keywords)) {
            View::share('seo_keywords', $pModel->seo_keywords);
        }
    }

    // Lasted update 1.3.0.2

    public function seo() {
        $SettingLang = $this->group_fieldFromModels('id_lang', Cache::get('CACHE_SETTING_LANG'));
        $Lang = new LanguageService();
        $Lang = $Lang->get_currentLang();

        if (isset($SettingLang[$Lang->id])) {
            $Model = $SettingLang[$Lang->id];
        }
        $this->seo_array([
            'seo_title' => @$Model->seo_title,
            'seo_description' => @$Model->seo_description,
            'seo_keywords' => @$Model->seo_keywords,
        ]);
    }

    // Lasted update 1.3.0.0

    public function seo_array($pArray) {
        if (isset($pArray['seo_title'])) {
            View::share('seo_title', $pArray['seo_title']);
        }
        if (isset($pArray['seo_description'])) {
            View::share('seo_description', $pArray['seo_description']);
        }
        if (isset($pArray['seo_keywords'])) {
            View::share('seo_keywords', $pArray['seo_keywords']);
        }
    }

    public static function seo_title($title) {
        View::share(__FUNCTION__, $title);
    }

    public static function seo_description($description) {
        View::share(__FUNCTION__, $description);
    }

    public static function seo_keywords($keywords) {
        View::share(__FUNCTION__, $keywords);
    }

    public static function seo_image($image_url) {
        View::share(__FUNCTION__, $image_url);
    }

    public static function seo_published_time($value) {
        View::share(__FUNCTION__, $value);
    }

}
