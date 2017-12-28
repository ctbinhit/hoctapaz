<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bcore\Services\UserServiceV3;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;
use App\Bcore\SystemComponents\User\UserType;
use Input,
    PhotoModel,
    View,
    Session;

class UserController extends AdminController {

    public $storage_folder = 'users/';
    public $ControllerName = 'User';

    use \App\Functions\AdminFunction;

    public function __construct() {
        parent::__construct();
        $this->sendDataToView(array(
            'route_ajax' => 'admin_user_ajax'
        ));
        // -------------------------------------------------------------------------------------------------------------
        View::share('_ControllerName', $this->ControllerName);
    }

    public function get_index($pType, Request $request) {
        $this->DVController = $this->registerDVC($this->ControllerName);
        $UserModels = DB::table('users')
                ->leftJoin('users_vip', 'users.id_vip', '=', 'users_vip.id')
                ->where([
                    ['users.type', $pType]
                ])
                ->select([
            'users.id', 'users.fullname', 'users.email', 'users.phone', 'users.username', 'users.created_at', 'users.coin',
            'users.tbl', 'users.lock_by',
            'users_vip.id as vip_id', 'users_vip.name as vip_name'
        ]);
        $UserModels->orderBy('id', 'desc');

        $Models = UserServiceV3::find_photoURLByModels($UserModels->paginate(10));

        return view($this->_RV . 'user/index', [
            'type' => $pType,
            'items' => $Models
        ]);
    }

    public function get_add($pType, Request $request) {
        // Đăng ký data view controller --------------------------------------------------------------------------------
        $this->DVController = $this->registerDVC($this->ControllerName);
        // -------------------------------------------------------------------------------------------------------------

        return view($this->_RV . 'user/add', [
            'type' => $pType
        ]);
    }

    public function get_edit($pType, $pId, Request $request) {
        $UserModel = UserModel::find($pId);
        if ($UserModel == null) {
            session::flash('message_type', 'error');
            session::flash('message', 'Không thể cập nhật, vui lòng thử lại sau!');
            return redirect()->route('admin_user_partner');
        }
        return view($this->_RV . 'user/add', [
            'type' => $pType,
            'item' => $UserModel,
            'lst_per_groups' => @$UserPerrmissionGroups
        ]);
    }

    public function post_save($pType, Request $request) {
        if ($request->has('id')) {
            $UserModel = UserModel::find($request->input('id'));
            if ($UserModel == null) {
                session::flash('message_type', 'error');
                session::flash('message', 'Có lỗi xảy ra, dữ liệu không có thực.');
                return redirect()->route('admin_user_partner');
            }
        } else {
            $UserModel = new UserModel();
        }
        $UserModel->fullname = $request->input('fullname');
        $UserModel->email = $request->input('email');
        $UserModel->username = $request->input('username');
        $UserModel->phone = $request->input('phone');
        $UserModel->id_card = $request->input('cmnd');
        $UserModel->id_permission_group = $request->input('ipg');
        $r = $UserModel->save();
        if ($r) {
            session::flash('message', 'Cập nhật thành công!');
        } else {
            session::flash('message_type', 'error');
            session::flash('message', 'Cập nhật thất bại, viu lòng thử lại sau!');
        }
        return redirect()->route('admin_user_index', $pType);
    }

    public function get_lock($pType, $pId, Request $request) {


        $UserModel = UserModel::find($pId);
        if ($UserModel == null) {
            session::flash('message_type', 'error');
            session::flash('message', 'Dữ liệu không có thực!');
            return redirect()->route('admin_user_partner');
        }
        $Now = Carbon::now();
        $UserModel->created_date = $Now->diffForHumans($UserModel->created_at);
        return view($this->_RV . 'user/lock', [
            'type' => $pType,
            'item' => $UserModel
        ]);
    }

    public function post_lock($pType, Request $request) {
        if (!$request->has('id')) {
            session::flash('message_type', 'error');
            session::flash('message', 'Có lỗi xảy ra!');
            goto redirectArea;
        }
        $UserModel = UserModel::find($request->input('id'));
        if ($UserModel == null) {
            session::flash('message_type', 'error');
            session::flash('message', 'Dữ liệu không có thực!');
            goto redirectArea;
        }
        if ($UserModel->lock_by == null) {
            $UserModel->lock_date = Carbon::now();
            $UserModel->lock_by = \App\Bcore\Services\UserServiceV2::current_userId(\App\Bcore\System\UserType::admin());
            $UserModel->lock_message = $request->input('message');
        } else {
            $UserModel->lock_date = null;
            $UserModel->lock_by = null;
            $UserModel->lock_message = null;
        }

        $r = $UserModel->save();
        if ($r) {
            session::flash('message', 'Cập nhật thành công!');
            goto redirectArea;
        } else {
            session::flash('message_type', 'error');
            session::flash('message', 'Cập nhật không thành công!');
            goto redirectArea;
        }
        redirectArea:
        return redirect()->route('admin_user_index', $pType);
    }

    public function get_info() {
//        $ip = '42.119.1.201';
//        $user_location = json_decode(file_get_contents("http://www.geoplugin.net/php.gp?ip={$ip}"));
//        $geoPlugin_array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));
        $UserModel = UserModel::find(session('user')['id']);

        $StorageService = new \App\Bcore\StorageService();

        $PhotoModel = new PhotoModel();
        $PhotoOptions = array(
            'table' => 'users',
            'id' => session('user')['id']
        );
        $Lst_photo = $PhotoModel->db_getAllDataByIdObject($PhotoOptions);
        $Lst_photo = $PhotoModel->GroupByType($Lst_photo);
        return $this->render_view('me.info', array(
                    'item' => $UserModel,
                    'data_photos' => $Lst_photo
                        ), false);
    }

    public function updatePassword(Request $request) {
        if (Input::has('password_old') && Input::has('password_new') && Input::has('password_new2')) {
            $Model = UserModel::find(session('user')['id']);
            if ($Model != null) {
                if ($Model->password == $request->input('password_old')) {
                    if ($request->input('password_new') == $request->input('password_new2')) {
                        $Model->password = $request->input('password_new');
                        $r = $Model->save();
                        if ($r) {
                            $request->session()->flash('message', 'Cập nhật thành công!');
                        } else {
                            $request->session()->flash('message_type', 'error');
                            $request->session()->flash('message', 'Không thể cập nhật, vui lòng thử lại sau!');
                        }
                        goto resultArea;
                    } else {
                        $request->session()->flash('message_type', 'error');
                        $request->session()->flash('message', '2 Mật khẩu không khớp!');
                        goto resultArea;
                    }
                } else {
                    $request->session()->flash('message_type', 'error');
                    $request->session()->flash('message', 'Mật khẩu sai!');
                    goto resultArea;
                }
            } else {
                goto Err;
            }
        } else {
            Err:
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', 'Lỗi không xác định!');
            goto resultArea;
        }

        resultArea:

        redirectArea:
        return redirect()->route('admin_me_info');
    }

    public function post_info(Request $request) {
        if (!Input::hasFile('photo')) {
            return;
        }
        // Lấy thông tin file upload từ form
        $file = $request->file('photo');
        // Nếu file không có => out
        if ($file == null) {
            
        } else {
            goto StorageAccessArea;
        }

        StorageAccessArea:

        $StorageService = new \App\Bcore\StorageService();

        // Sử dụng Storage Service để kiểm tra thư mục có tồn tại trên 1 server
        // C1 ----------------------------------------------------------------------------------------------------------
        //        $StorageService->setOptions(array(
        //            'storageName' => 'google',
        //            'dir_name' => $this->storage_folder,
        //            'dir_autocreate' => true
        //        ));
        //        $FolderPath = $StorageService->checkFolderExists();
        // -------------------------------------------------------------------------------------------------------------
        // C2 (Nên dùng bởi vì ngắn gọn --------------------------------------------------------------------------------
        // @Param: disk name (Server muốn kiểm tra, vd: google, public (host), dropbox, s3...)
        // @Param: folder name (Tên thư mục muốn kiểm tra )
        // @Param: autocreate (Tự động tạo mới nếu không tồn tại )
        // 
        // Syntax: $FolderPath = $StorageService->checkFolderExists('google', $this->storage_folder, true);
        // Return: Mảng thông tin của folder đó
        // -------------------------------------------------------------------------------------------------------------
        // Kiểm tra thư mục có tồn tại trên google
        // Chỉ cần kiểm tra trên google, vì local trong quá trình upload nếu không có thư mục sẽ tự động tạo mới
        $FolderPath = $StorageService->checkFolderExists('google', $this->storage_folder, true);

        if ($FolderPath == null) {
            // Write log, ...
            return;
        }

        // Result look like:
        //  {#275 ▼
        //      +"type": "dir"
        //      +"path": "0B76IYXdgtJXfNUUwd05vdXd3ajg"
        //      +"filename": "users"
        //      +"extension": ""
        //      +"timestamp": 1504462874
        //      +"size": 0
        //      +"dirname": ""
        //      +"basename": "0B76IYXdgtJXfNUUwd05vdXd3ajg"
        //  }
        // Khởi tạo tên file (* Google, Dropbox,... đều lưu theo tên này)
        $filename = 'photo_' . md5(Carbon::now() . $file->getClientOriginalName()) . '.' . $file->extension();

        $local_path = $StorageService->upload_file('public', $filename, $file);


        // Put file lên server thành công
        if ($local_path != null) {
            // Put file lên google drive
            // Lưu ý khi put file lên google thì $file->path()
            $tmp_gg_folder_name = $StorageService->createFolderIfNotExitst('google', 'users');
            $google_path = $StorageService->upload_file('google', $tmp_gg_folder_name . '/' . $filename, file_get_contents($file->path()));
        }
        $PhotoModel = new PhotoModel();
        $PhotoModel->obj_id = session('user')['id'];
        $PhotoModel->obj_table = 'users';
        $PhotoModel->obj_type = 'photo';
        $PhotoModel->url = $filename;
        $PhotoModel->sync_google = @$google_path;
        $PhotoModel->name = $file->getClientOriginalName();
        $PhotoModel->id_user = session('user')['id'];
        $r = $PhotoModel->save();

        if ($r) {
            $request->session()->flash('message', 'Cập nhật thành công!');
        } else {
            $request->session()->flash('message_type', 'error');
            $request->session()->flash('message', 'Cập nhật không thành công!');
        }
        return redirect()->route('admin_me_info');
    }

    public function get_user_vip($pType, $id, Request $request) {

        $Model = UserModel::find($id);
        if ($Model == null) {
            \App\Bcore\Services\NotificationService::alertRight('Dữ liệu không có thực!', 'danger');
            return redirect()->route('admin_user_index', $pType);
        }

        if (class_exists('\App\Modules\UserVIP\Models\UserVIPModel')) {
            $VIP_MODELS = \App\Modules\UserVIP\Models\UserVIPModel::get();
        }


        return view($this->_RV . 'user/user_vip', [
            'item' => UserModel::find_userVIPByModel($Model),
            'type' => $pType,
            'vip_models' => $VIP_MODELS
        ]);
    }

    public function post_user_vip_save($type, $id, Request $request) {
        $ID_USER = $request->input('id');
        $ID_VIP = $request->input('id_vip');

        if ($ID_USER != $id) {
            \App\Bcore\Services\NotificationService::alertRight('Phát hiện nghi vấn hack!', 'danger', 'Cảnh báo bảo mật.');
            goto redirectArea;
        }
        $UserModel = UserModel::find($ID_USER);
        if ($UserModel == null) {
            \App\Bcore\Services\NotificationService::alertRight('Dữ liệu không có thực!', 'danger');
            goto redirectArea;
        }
        $UserModel->id_vip = $ID_VIP;
        $saved = $UserModel->save();
        if ($saved) {
            \App\Bcore\Services\NotificationService::
            alertRight("Cập nhật VIP cho $UserModel->fullname thành công!", 'success');
        } else {
            \App\Bcore\Services\NotificationService::
            alertRight("Cập nhật VIP cho $UserModel->fullname thất bại, vui lòng thử lại sau!", 'warning');
        }
        redirectArea:
        return redirect()->route('admin_user_index', $type);
    }

    public static function register_strict() {
        return (object) [
                    'type' => [
                        'user' => (object) [
                            'name' => 'Tài khoản người dùng',
                            'default' => true,
                        ],
                        'professor' => (object) [
                            'name' => 'Tài khoản giáo viên',
                            'default' => false,
                        ],
                        'admin' => (object) [
                            'name' => 'Tài khoản quản trị',
                            'default' => false,
                        ],
                    ]
        ];
    }

    public static function register_permissions() {
        return (object) [
                    'admin' => (object) [
                        'per_require' => (object) [
                            'per_view' => (object) [
                                'name' => 'Xem danh sách user',
                                'default' => true
                            ],
                            'per_add' => (object) [
                                'name' => 'Tạo user',
                                'default' => false
                            ],
                            'per_edit' => (object) [
                                'name' => 'Sửa thông tin user',
                                'default' => false
                            ],
                            'per_edit_status' => (object) [
                                'name' => 'Thay đổi trạng thái user',
                                'default' => false
                            ],
                            'per_delete_soft' => (object) [
                                'name' => 'Xóa user',
                                'default' => false
                            ],
                            'per_delete_hard' => (object) [
                                'name' => 'Xóa vĩnh viễn user',
                                'default' => false
                            ],
                            'per_sync' => (object) [
                                'name' => 'Đồng bộ dữ liệu user',
                                'default' => false
                            ],
                            'per_send_mail' => (object) [
                                'name' => 'Gửi mail cho user',
                                'default' => false
                            ],
                            'per_add_coin' => (object) [
                                'name' => 'Nạp tiền cho user',
                                'default' => false
                            ],
                        ],
                        'signin_require' => true,
                        'classes_require' => (object) [
                            'Illuminate\Support\Facades\Config',
                            'Illuminate\Support\Facades\Lang',
                            'Illuminate\Support\Facades\Storage',
                            'Carbon\Carbon',
                            'App\Models\ArticleModel',
                            'App\Models\ArticleLangModel'
                        ]
                    ],
                    'client' => (object) [
                        'signin_require' => false,
                    ]
        ];
    }

}
