<div class="l-panel">
    <div class="l-title"><i class="fa fa-search"></i> Tìm kiếm</div>
    <div class="l-content">
        <form class="form form-horizontal" 
              method="get" action="{{in_array(Route::currentRouteName(),['mdle_client_qa_index','mdle_client_qa_category'])?url()->full():route('mdle_client_qa_index')}}">
            <div class="form-group">
                <div class="col-lg-12 col-md-12 col-sm-9 col-xs-12 input-group" style="padding: 0px 15px;">
                    <input type="text" name="k" id="txt_search" 
                           class="form-control" placeholder="Tìm kiếm..." value="{!! Request::has('k')?Request::get('k'):'' !!}" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        @if(Request::has('k'))
                        <a href="{{url()->current()}}" class="btn btn-danger"><i class="fa fa-remove"></i></a>
                        @endif
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="l-panel">
    <div class="l-title"><i class="fa fa-question-circle"></i> Tạo câu hỏi nhanh</div>
    <div class="l-content">

            @if(UserService::isLoggedIn())
            <form class="form" action="{{route('mdle_client_qa_add')}}">
                <div class="form-group input-group">
                    <select class="form-control">
                        <option>-- Chọn danh mục --</option>
                        @foreach($categories as $k=>$v)
                        <option>{!! $v->name !!}</option>
                        @endforeach     
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
            </form>
            @else
            <p class="text-info">Để có thể tạo câu hỏi bạn vui lòng <b>Đăng nhập</b> hoặc nếu chưa có tài khoản bạn click 
                vào <b>đăng ký</b> theo link bên dưới</p>
            <a href="{{route('client_login_index')}}?cwr={{url()->full()}}" class="btn btn-default"><i class="fa fa-sign-in"></i> Đăng nhập</a>
            <a href="{{route('client_login_signup')}}" class="btn btn-default"><i class="fa fa-edit"></i> Đăng ký</a>
            @endif
     
    </div>
</div>

<div class="l-panel">
    <div class="l-title"><i class="fa fa-list-ul"></i> Danh mục chính</div>
    <div class="l-content">
        <ul class="list-simple">
            @if(count($base_categories)!=0)
            @foreach($base_categories as $k => $v)
            <li><a href="javascript:;"><i class="fa fa-book"></i> {!! $v->name !!}</a>
                @php
                $sub_cate = CategoryService::get_childCateByIdParent($v->id);
                @endphp
                @if(count($sub_cate)>0)
                <ul class="list-simple-sub">
                    @foreach($sub_cate as $k1 => $v1)
                    <li><a href="{{route('mdle_client_qa_category' , $v1->name_meta)}}"><i class="fa fa-book"></i> {{$v1->name}}</a></li>
                    @endforeach
                </ul>
                @endif

            </li>
            @endforeach     
            @else
            <p>Chưa có danh mục nào.</p>
            @endif
        </ul>
         <script>
            $(document).ready(function () {
                $('.list-simple').children('li').children('a').on('click', function () {
                    $(this).parents('li').find('i:first').toggleClass('fa-minus', 'fa-plus');
                    $(this).parents('li').find('.list-simple-sub').slideToggle();
                });
            });
        </script>
    </div>
</div>

<div class="l-panel">
    <div class="l-title"><i class="fa fa-star"></i> Quảng cáo</div>
    <div class="l-content">
        <p>Liên hệ quảng cáo.</p>
    </div>
</div>