@extends('admin.layouts.master')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-edit"></i> Thông tin chi tiết <small> {{$item->name}}</small></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form action="" method="POST">
                        <a href="{{route('admin_examman_approver')}}" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$item->id}}" />
                        <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-check"></i> Xác thực</button>
                        <a href="{{route('admin_examman_approver_reject',$item->id)}}" class="btn btn-lg btn-warning"><i class="fa fa-envelope"></i> Từ chối</a>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-edit"></i> Thông tin chung <small>{{$item->created_at}}</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tên: </td>
                                <td><b class="text-info">{{$item->user_fullname or 'Undefined'}}</b> <i class="fa fa-eye"></i></td>
                            </tr>
                            <tr>
                                <td>Đề thi: </td>
                                <td>{{$item->name}}</td>
                            </tr>
                            <tr>
                                <td>Danh mục: </td>
                                <td>{{$item->cate_name}}</td>
                            </tr>
                            <tr>
                                <td>Mô tả:</td>
                                <td>{{$item->description}}</td>
                            </tr>
                            <tr>
                                <td>Thời gian:</td>
                                <td>{{$item->time/60}} phút</td>
                            </tr>
                            <tr>
                                <td>Phí thi:</td>
                                <td>{{number_format($item->price,0)}} VNĐ/Lượt</td>
                            </tr>
                            <tr>
                                <td>Phí thi lại:</td>
                                <td>{{number_format($item->price2,0)}} VNĐ/Lượt</td>
                            </tr>
                            <tr>
                                <td>Seo title:</td>
                                <td>{{$item->seo_title}}</td>
                            </tr>
                            <tr>
                                <td>Seo description:</td>
                                <td>{{$item->seo_description}}</td>
                            </tr>
                            <tr>
                                <td>Seo keywords:</td>
                                <td><i class="label label-info">{{$item->seo_keywords}}</i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-file-pdf-o"></i> FILE PDF</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <iframe style="width: 100%;height:350px;border:none;overflow-x:hidden;" src="{{$item->file_pdf_url}}"></iframe>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


