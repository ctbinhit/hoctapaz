<li><a><i class="fa fa-puzzle-piece"></i> {{__('label.hoctapaz')}} (Beta)<span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="{{route('admin_category_index',['exam','hoctap'])}}">Quản lý danh mục</a></li>
        <li><a href="{{route('admin_examman_approver')}}">Kiểm duyệt khóa học & bài thi</a></li>
        <li><a href="{{route('mdle_admin_doc_index','tai-lieu-hoc')}}">Tài liệu học chờ duyệt</a></li>
        <li><a href="{{route('mdle_admin_doc_index','de-thi-thu')}}">Đề thi thử chờ duyệt</a></li>
        <li><a href="{{route('mdle_oc_pi_exam_chart_index','de-thi')}}">Kết quả thi</a></li>
        
        <li><a href="{{route('admin_newsleeter_index','tro-thanh-doi-tac')}}">Danh sách đối tác đăng ký</a></li>
    </ul>
</li>