<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;
use App\Models\ArticleModel,
    App\Models\ArticleLangModel,
    PhotoModel;
use App\Bcore\Services\SeoService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ArticleController extends ClientController {

    use \App\Functions\AdminFunction;

    public function get_index(Request $request) {

        $type = $request->page_type;

        $Model = new ArticleModel();
        //    $Model->order_by = ['ordinalnumber','ASC'];
        $items = $Model->db_get_items($type);

        $Data_ArticlePhoto = array(
            'table' => 'articles',
            'type' => 'photo',
        );


        $PhotoModel = new PhotoModel();
        $data_photo = null;
        $Data_ArticlePhoto = $this
                ->bcore_ListPhotoGroupByType(
                $PhotoModel->db_getListPhotoByObjType((object) $Data_ArticlePhoto));


        return view("client/$type/index", [
            'items' => $items,
            'items_photo' => $Data_ArticlePhoto
        ]);
    }

    public static function get_highlightArticles($type = 'tintuc', $perPage = 5) {
        $ArticleModels = new \App\Models\ArticleModel();
        $ArticleModels_ = $ArticleModels->set_type($type)
                ->set_orderBy(['id', 'desc'])
                ->set_highlight(1)
                ->set_deleted(1)
                ->set_perPage($perPage)
                ->set_lang(1)
                ->execute();
        return \App\Models\PhotoModel::findByModels(['photo'], $ArticleModels_->data());
    }

    public static function get_newestArticles($type = 'tintuc', $perPage = 5) {
        $ArticleModels = new \App\Models\ArticleModel();
        $ArticleModels_ = $ArticleModels->set_type($type)
                ->set_orderBy(['id', 'desc'])
                ->set_deleted(1)
                ->set_perPage($perPage)
                ->set_lang(1)
                ->execute();
        return \App\Models\PhotoModel::findByModels(['photo'], $ArticleModels_->data());
    }

    public function get_news() {
        SeoService::seo_title('Tin tức mới');
        // TIN TỨC - MỚI
        $NewsestArticles = $this->get_newestArticles('tintuc', 8);
        // TIN NỔI BẬT
        $HighlighArticles = $this->get_highlightArticles('tintuc', 5);

        return view('client/news/index', [
            'db_items' => $NewsestArticles,
            'db_tinnoibat' => $HighlighArticles
        ]);
    }

    public function get_news_highlight() {
        SeoService::seo_title('Tin tức nổi bật');
        // TIN TỨC - MỚI
        $items = $this->get_highlightArticles('tintuc', 8);
        // TIN NỔI BẬT
        $HighlighArticles = $this->get_highlightArticles('tintuc', 5);

        return view('client/news/index', [
            'db_items' => $items,
            'db_tinnoibat' => $HighlighArticles
        ]);
    }

    public function get_news_detail($name_meta) {

        $ArticleLangModel = ArticleLangModel::where([
                    ['name_meta', $name_meta]
                ])->first();

        SeoService::seo_title($ArticleLangModel->seo_title);
        SeoService::seo_description($ArticleLangModel->seo_description);
        SeoService::seo_keywords($ArticleLangModel->seo_keywords);

        $ArticlePhoto = \Illuminate\Support\Facades\DB::table('photos')
                        ->where([
                            ['obj_table', 'articles'],
                            ['obj_id', $ArticleLangModel->id_article],
                            ['obj_type', 'photo']
                        ])->first();
        SeoService::seo_image(Storage::disk('localhost')->url($ArticlePhoto->url));
    
        $ArticleModel = ArticleModel::find($ArticleLangModel->id_article);

        // TIN LIÊN QUAN
        $ArticleModels = new \App\Models\ArticleModel();
        $ArticleModels_ = $ArticleModels->set_type('tintuc')
                ->set_orderBy(['id', 'desc'])
                ->set_where([
                    ['articles.id', '<>', $ArticleModel->id]
                ])
                ->set_deleted(1)
                ->set_perPage(5)
                ->set_lang(1)
                ->execute();
        $RelatedArticles = \App\Models\PhotoModel::findByModels(['photo'], $ArticleModels_->data());

        // TIN NỔI BẬT
        $HighlighArticles = $this->get_highlightArticles('tintuc', 5);

        return view('client/news/detail', [
            'art' => $ArticleModel,
            'art_lang' => $ArticleLangModel,
            'db_tinlienquan' => $RelatedArticles,
            'db_tinnoibat' => $HighlighArticles
        ]);
    }

}
