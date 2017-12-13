<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request,
    ArticleOModel,
    ProductModel,
    PhotoModel;
use App\Bcore\Services\CategoryService;
use SeoService;
use Cache;
use Session;
use DB;
use App\Bcore\Services\PeopleService;

class IndexController extends ClientController {

    public function __construct() {
        parent::__construct();
    }

    private function load_qa() {
        $QAModel = DB::table('qa')
                ->join('categories_lang', 'categories_lang.id_category', '=', 'qa.id_category')
                ->join('users', 'users.id', '=', 'qa.id_user')
                ->leftJoin('qa_cmt', 'qa_cmt.id_qa', '=', 'qa.id');

        $QAModel = $QAModel->where([
            ['qa.obj_type', 'hoi-dap'],
            ['qa.deleted_at', null],
            ['categories_lang.id_lang', 1]
        ]);

        $QAModel = $QAModel->groupBy('qa.id');

        $QAModel = $QAModel->select([
            'qa.id', 'qa.title', 'qa.id_user', 'qa.created_at', 'qa.content', 'qa.tbl',
            'categories_lang.name as category_name', 'users.fullname as user_name',
            'categories_lang.name_meta as cate_name_meta',
            'categories_lang.id_category',
            DB::raw('COUNT(tbl_qa_cmt.id) as answer_count')
        ]);

        $QAModel = $QAModel->orderBy('qa.id', 'DESC');
        $db_danhsachcauhoi = $QAModel->take(3)->get();

        foreach ($db_danhsachcauhoi as $k => $v) {
            $v->user_photo = PeopleService::get_userPhotoURLById($v->id_user);
        }
        return $db_danhsachcauhoi;
    }

    public function index() {

        $newest_qa = $this->load_qa();
        $qa_categories = CategoryService::get_baseCategories('hoctap', 'exam');

        $SeoService = new SeoService();
        $SeoService->seo();

        $SliderModel = DB::table('photos')
                ->where([
                    ['obj_type', 'slider_top'],
                    ['deleted_at', null]
                ])->orderBy('ordinal_number', 'ASC')
                ->get();


        $ProductModel = new ProductModel();
        $Models = $ProductModel
                ->set_orderBy(['ordinal_number', 'ASC'])->set_lang(1)->set_type('sanpham')
                ->set_perPage(8)
                ->set_highlight(1)
                ->execute();
        $PAI = PhotoModel::findByModels(['photo'], $Models->data());
        //$LoadCategory = CategoryModel::findByModelsWithLang($PAI);

        $ProductModel = new ProductModel();
        $Models = $ProductModel
                ->set_orderBy(['id', 'DESC'])->set_lang(1)->set_type('sanpham')
                ->set_perPage(8)
                ->execute();
        $spm = PhotoModel::findByModels(['photo'], $Models->data());

        $ArticleModels = new \App\Models\ArticleModel();
        $tintucmoinhat = $ArticleModels->set_type('tintuc')
                ->set_orderBy(['id', 'desc'])
                ->set_deleted(1)
                ->set_perPage(5)
                ->set_lang(1)
                ->execute();
        $tintucmoinhat = \App\Models\PhotoModel::findByModels(['photo'], $tintucmoinhat->data());

        return view('client/index/index', [
            'sanphamnoibat' => $PAI,
            'sanphammoi' => $spm,
            'db_tintucmoinhat' => $tintucmoinhat,
            'slide_top' => $SliderModel,
            'db_newest_qa' => $newest_qa,
            'db_qa_categories' => $qa_categories
        ]);
    }

    public function get_partner() {


        return view('client/index/trothanhdoitac');
    }

    public function post_partner(Request $request) {
        $NewsletterModel = (new \App\Models\NewsletterModel());
        $NewsletterModel->type = 'tro-thanh-doi-tac';
        $NewsletterModel->phone = $request->input('phone');
        $NewsletterModel->email = $request->input('email');
        $NewsletterModel->name = $request->input('fullname');
        if ($NewsletterModel->save()) {
            session::flash('state', true);
        } else {
            session::flash('state', false);
        }
        return redirect()->route('client_partner_index');
    }

    public function get_articleo($pType) {


        $ArticleOModel = Cache::remember('CACHE_ARTICLEO_' . $pType, 3600, function() use ($pType) {
                    return ArticleOModel::where([
                                ['type', '=', $pType],
                                ['id_lang', '=', 1]
                            ])->first();
                });
        if ($ArticleOModel == null) {
            return '404';
        }

        $SeoService = new SeoService();
        $SeoService->seo_model($ArticleOModel);

        return view('client/index/articleo', [
            'item' => $ArticleOModel
        ]);
    }

    public function get_qtk_vcb() {
        return view('client/index/qtk_vcb', [
        ]);
    }

    public function post_qtk_vcb(Request $request) {
        $res = (object) [
                    'state' => null,
                    'data' => null,
                    'act' => null,
                    'id' => null
        ];
        $id = $request->input('id');
        try {

            $count_id = strlen($id);

            $prefix = '';

            if ($count_id == 12) {
                $prefix .= '0';
            } elseif ($count_id == 11) {
                $prefix .= '00';
            }


            $r = \App\Bcore\Services\VCBService::bank_accounts($prefix . $id);

            if ($r->state == 'error') {
                $res->act = 'change';
                $res->id = ($id) - 1;
            } elseif ($r->state == 'pending') {
                $res->act = 'resend';
                $res->id = $id;
                sleep(2);
            } elseif ($r->state == 'fetched') {
                $res->id = ($id) - 1;
                $Model = \App\Models\BankAccountModel::where([
                            ['account_id', '=', trim($request->input('id'))]
                        ])->first();
                if ($Model == null) {
                    $Model = new \App\Models\BankAccountModel();
                    $Model->account_id = $r->account_id;
                    $Model->account_name = $r->account_name;
                    $Model->bank_name = $r->bank_name;
                    $Model->state = 1;
                    $Model->save();
                }

                $res->act = 'next';
            } else {
                $res->id = ($id) - 1;
                $res->act = 'next';
            }

            $res->state = $r->state;
            $res->data = $r;
        } catch (\Exception $ex) {
            $res->act = 'error';
            $res->id = ($id) - 1;
        }

        return response()->json($res);
    }

}
