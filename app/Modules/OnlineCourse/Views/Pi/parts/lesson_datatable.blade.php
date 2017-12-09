@include('OnlineCourse::Pi/jsc/datatable')

<table class="table table-striped" id="table_controller">
    <thead>
        <tr>
            <th style="width: 5%;">
                <input class="jquery-icheck-all" data-items="item-select" type="checkbox">
            </th>
            <th class="hidden-xs" style="width: 7% !important"><i class="fa fa-sort-numeric-asc"></i></th>
            <th style="width: 30%;">Tên bài học</th>
            <th class="hidden-xs"><i class="fa fa-eye"></i></th>
            <th class="hidden-xs">Ngày tạo</th>
            <th class="hidden-xs">Cập nhật</th>
            <th class="hidden-xs" style="width: 5%;">Nổi bật</th>
            <th class="hidden-xs" style="width: 5%;">Hiển thị</th>
            <th style="width: 10%;">#</th>
        </tr>
    </thead>
    <tbody>
        @if(count($items)!=0)
        @foreach($items as $k =>$v)
        <tr class="item-select" id="item-select-{{$v->id}}" data-id="{{$v->id}}" data-tbl="{{$v->tbl}}">
            <td style="text-align: center;"><input class="jquery-icheck" data-id="{{$v->id}}" type="checkbox"></td>
            <td class="hidden-xs">
                <input style="width: 100%;" class="jquery-bcore-textbox" name="ordinal_number" 
                       data-action="uf" type="number" value="{{$v->ordinal_number}}">
            </td>
            <td>
                <a href="{{route('mdle_oc_edit',$v->id)}}">
                    {{$v->name}} <i class="fa fa-pencil"></i>
                </a>
            </td>
            <td class="hidden-xs">{{$v->views}} <i class="fa fa-user"></i></td>
            <td class="hidden-xs">{{$v->created_at}} <br> ({{@$v->created_at_human}})</td>
            <td class="hidden-xs">{{@$v->updated_at_human}}</td>
            <td class="hidden-xs">
                @php
                $highlight_checked = $v->highlight?'checked':''
                @endphp
                <input type="checkbox" class="js-switch" name="display" data-act="uh" {{$highlight_checked}} />
            </td>
            <td class="hidden-xs">
                @php
                $display_checked = $v->display?'checked':''
                @endphp
                <input type="checkbox" class="js-switch" name="display" data-act="ud" {{$display_checked}} />
            </td>

            <td>
                                <a href="#" class="btn btn-primary">
                                    <i class="fa fa-sign-in"></i> Gửi</a>
                                    <a href="{{route('mdle_oc_lesson_edit',[$course_info->id,$chapter_info->id,$v->id])}}" class="btn btn-default">
                                    <i class="fa fa-edit"></i></a>
                                @if($v->url_redirect!=null)
                                <a href="{{$v->url_redirect}}" target="_blank" class="btn btn-primary" titl="Di chuyển tới link">
                                    <i class="fa fa-link"></i></a>
                                @endif
                                <a href="javascript:void(0)" class="btn btn-danger jquery-button-remove">
                                    <i class="fa fa-remove"></i></a>

               
             
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="100">
                <div class="row">
                    <div class="col-md-2">
                        <form action="" method="POST" name="frm_changeDisplayCount">
                            {{ csrf_field() }}
                            <input type="hidden" value="" name="type"/>
                            <select class="form-control jquery-bcore-viewcount" name="display_count">
                                <option>--Hiển thị--</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="-1">Tất cả</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-2">
                        @if(count($items)!=0)
                        <button type="button" data-tbl="{{@$items[0]->tbl}}" data-action="rs" 
                                class="btn btn-default jquery-bcore-btn" data-items="item-select">
                            <i class="fa fa-trash"></i> {{__('label.xoadachon')}}
                        </button>
                        @endif
                    </div>
                    <div class="col-md-4">
                        {{$items->links()}}
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>

