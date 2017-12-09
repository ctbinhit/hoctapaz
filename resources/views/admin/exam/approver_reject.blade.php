@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Gửi thông báo từ chối <small> {{$item->name}}</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông tin chung</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p>Đề thi: {{$item->name}}</p>
                    <p>Thời gian: {{$item->time/60}} phút</p>
                    <p>Giá tiền: {{$item->price}} VNĐ/Lượt</p>
                    <p>Seo title: {{$item->seo_title}}</p>
                    <p>Seo description: {{$item->seo_description}}</p>
                    <p>Seo keywords: {{$item->seo_keywords}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>File PDF</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    Loading...
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-envelope"></i></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form form-horizontal" action="" method="post">

                        <div class="form-group">
                            <label class="control-label col-md-2">Quản trị viên:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề"
                                       value="{{Session::get('user')['fullname']}}" disabled=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Tiêu đề:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề"
                                       value="{{$item->name}} đã bị từ chối bởi quản trị viên"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Lý do gợi ý:</label>
                            <div class="col-md-10">
                                <select class="form-control">
                                    <option>Thời gian thi không hợp lý.</option>
                                    <option>Vi phạm về nội dung chứa những từ ngữ không phù hợp.</option>
                                    <option>Vi phạm về văn hóa, chính sách, tôn giáo.</option>
                                    <option>Chứa nội dung nhạy cảm.</option>
                                    <option>Số câu hỏi trắc nghiệm & file PDF không khớp nhau.</option>
                                    <option>Giá bài thi quá mắc so với quy định của website</option>
                                    <option>Giá bài thi quá rẻ so với quy định của website</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Nội dung:</label>
                            <div class="col-md-10">
                                <textarea name="content" rows="5" placeholder="Nội dung" class="form-control">Bài thi {{$item->name}} đã bị từ chối bởi quản trị viên hoctapaz.com.vn vì những lý do sau đây:</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Hành động:</label>
                            <div class="col-md-10">
                                <p><input type="radio" name="action"/> Vi phạm nghiêm trọng về chính sách & điều khoản (Xóa ngay & không cần báo trước)
                                    <br><small class="text-danger">Lưu ý: Chắc rằng những điều bạn chọn đúng với sự thật, việc này đồng nghĩa bài thi này sẽ được gửi cho quản trị cấp cao để xác nhận 1 lần nữa, nếu những gì bạn xác nhận không đúng sự thật sẽ vi phạm về điều khoản của website.</small>
                                </p>
                                <p><input checked type="radio" name="action"/> Gửi yêu cầu chỉnh sửa (GV có thể khôi phục và gửi yêu cầu xác nhận lại)</p>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="{{route('admin_examman_approver')}}" class="btn btn-default">Quay lại</a>
                                <button class="btn btn-primary" type="submit" >Gửi & hủy bài thi</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


