<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\ClientController;
use ArticleModel,
    PhotoModel,
    ProductModel;
use App\Bcore\Services\SeoService;

class ProductController extends ClientController {

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        $ProductModel = new \App\Models\ProductModel();

        SeoService::seo_title('Sản phẩm');
        
        $Models = $ProductModel
                ->set_orderBy(['id', 'DESC'])->set_lang(1)->set_type('sanpham')
                ->set_perPage(10)
                ->execute();
        $sp_moi = PhotoModel::findByModels(['photo'], $Models->data());



        return view('client/product/product', [
            'items' => $sp_moi
        ]);
    }

    public function get_spnb() {
        $ProductModel = new \App\Models\ProductModel();
        $Models = $ProductModel
                ->set_orderBy(['id', 'DESC'])->set_lang(1)->set_type('sanpham')
                ->set_perPage(10)
                ->set_highlight(1)
                ->execute();
        $spnb = PhotoModel::findByModels(['photo'], $Models->data());

        return view('client/product/product', [
            'items' => $spnb
        ]);
    }

    public function get_detail($name_meta) {
        $ProductModel = new \App\Models\ProductModel();
        $Models = $ProductModel
                ->set_orderBy(['ordinal_number', 'ASC'])->set_lang(1)->set_type('sanpham')
                ->execute();

        $PAI = PhotoModel::findByModels(['photo', 'photos'], $Models->data()->where('name_meta', $name_meta));
    
        return view('client/product/product_detail', [
            'item' => $PAI->first()
        ]);
    }

}
