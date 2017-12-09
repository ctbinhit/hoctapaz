<?php

namespace App\Modules\Background\Controllers\Admin;

use Illuminate\Http\Request;
use App\Bcore\PackageServiceAD;
use Session,
    Carbon\Carbon;
use ImageService;
use App\Modules\Background\Models\BackgroundModel;
use App\Modules\Background\Services\BackgroundService;

class BackgroundController extends PackageServiceAD {

    public $module_name = 'Background';
    public $dir = 'Admin';
    private $storage_folder = 'background';

    public function __construct() {
        parent::__construct();
    }

    public function get_index($pType) {
        $background = BackgroundModel::where([
                    ['type', '=', $pType],
                    ['deleted_at', '=', null]
                ])->orderBy('id', 'desc')->first();
        if ($background != null) {
            $BS = new BackgroundService($background);

            $BG_URL = $BS->get_url();
            $BG_CSS = $BS->convertCss();
            $background->css = $BG_CSS;
            $background->background_url = $BG_URL;
            $css = json_decode($background->options);

            $background->background_position_x = trim($css->{'background-position-x'});
            $background->background_position_y = trim($css->{'background-position-y'});
            $background->background_size = trim($css->{'background-size'});
            $background->background_repeat = trim(@$css->{'background-repeat'});
        }

        return view("$this->module_name::$this->dir/index", [
            'type' => $pType,
            'item' => @$background
        ]);
    }

    public function post_index(Request $request) {


        if ($request->input('type') == null) {
            session::flash('html_callback', (object) [
                        'message_title' => 'Thông báo',
                        'message_type' => 'warning',
                        'message' => 'Lưu không thành công, có lỗi xảy ra!'
            ]);
            return redirect()->route('admin_index');
        }
        $options = [];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'bg_' . md5(Carbon::now() . $file->getClientOriginalName()) . '.' . $file->extension();
            $StorageService = new \App\Bcore\StorageService();
            $PARENT_FOLDER = $this->storage_folder . '/' . $request->input('type');
            $LocalPath = $StorageService->upload_file('public', $filename, $file, $PARENT_FOLDER);
            $BM = new BackgroundModel();
            $BM->type = $request->input('type');
            $BM->name = $file->getClientOriginalName();
            $BM->size = $file->getSize();
            $BM->mimetype = $file->getMimetype();
            $BM->url_encode = md5($filename);
            $BM->url = $filename;

            if ($LocalPath != null) {
                goto updateLocalArea;
            } else {
                goto errorArea;
            }
        } else {
            $BM = BackgroundModel::where([
                        ['type', '=', $request->input('type')],
                        ['deleted_at', '=', null]
                    ])->orderBy('id', 'DESC')->first();
            if ($BM != null) {
                goto updateLocalArea;
            } else {
                goto errorArea;
            }
        }

        updateLocalArea:
        $BM->no_repeat = null;
        $BM->background_size = null;
        $BM->background_color = null;
        $BM->updated_by = session('user')['id'];
        $options['background-position-x'] = $request->input('background_position_x') != null ? $request->input('background_position_x') : 0;
        $options['background-position-y'] = $request->input('background_position_y') != null ? $request->input('background_position_y') : 0;
        $options['background-size'] = $request->input('background_size') != null ? $request->input('background_size') : 'unset';
        if ($request->input('background_repeat') == 'on') {
            $options['background-repeat'] = 'unset';
        } else {
            $options['background-repeat'] = 'no-repeat';
        }

        $BM->options = json_encode($options);
        if ($BM->save()) {
            if ($BM->db_deleteOldBg()) {
                session::flash('html_callback', (object) [
                            'message_title' => 'Thông báo',
                            'message_type' => 'success',
                            'message' => 'Lưu thành công!'
                ]);
            } else {
                session::flash('html_callback', (object) [
                            'message_title' => 'Thông báo',
                            'message_type' => 'warning',
                            'message' => 'Không thể xóa hình cũ, lưu thành công'
                ]);
            }
        } else {
            errorArea:
            session::flash('html_callback', (object) [
                        'message_title' => 'Thông báo',
                        'message_type' => 'warning',
                        'message' => 'Lưu không thành công, vui lòng thử lại sau!'
            ]);
        }

        return redirect()->route('mdle_background_index', [
                    'type' => $request->input('type')
        ]);
    }

}
