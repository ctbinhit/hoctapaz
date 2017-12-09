@extends('client.layouts.master')

@section('content')
<div class="learn">
    <div class="learn-left">
        @include('client.layouts.left_online')
    </div>
    <div class="learn-right">
        <div class="top-learn">
            <h4>Có chí thì nên- Không thì thôi</h4>
            <p><span>Biên soạn:</span><a href="#">Khổng Tử</a></p>
            <p><span>Môn học:</span><a href="#">Môn Toán</a></p>
            <p><span>Lớp:</span><a href="#">Lớp 12</a></p>
            <p><a href="#">Xem các học liệu khác</a></p>
            <div class="dangkyhoc btn-group pull-right">
                <button class="btn btn-success btnregister" data-userid="0" data-pageid="8"><i class="fa fa-sign-in"></i> Đăng ký học</button>
                <button class="btn btn-default" data-toggle="tooltip" data-original-title="Số người đã theo học">429</button>
            </div>
        </div>
        <div class="clear"></div>
        <div class="content-learn">
            <div class="box-body">
                <div id="tabs">   
                    <ul id="ultabs">				 
                        <li data-vitri="0">Trang chủ</li>
                        <li data-vitri="1">Thảo luận</li>
                        <li data-vitri="2">Danh sách</li>
                        <li data-vitri="3">Giới thiệu</li>
                    </ul>
                    <div style="clear:both"></div>
                    <div id="content_tabs">               
                        <div class="tab">
                            <ul>
                                <li><i class="fa fa-folder-open"></i><a href="#">Ứng dụng đạo hàm để khảo sát và vẽ đồ thị của hàm số</a>
                                    <ul>
                                        <li><i class="fa fa-file"></i><a href="#">I. Sự đồng biến, nghịch biến của hàm số</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">I. Sự đồng biến, nghịch biến của hàm số</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">III. Giá trị lớn nhất, giá trị nhỏ nhất của hàm số</a></li>
                                    </ul>
                                </li>
                                <li><i class="fa fa-folder-open"></i><a href="#">Hàm số lũy thừa, hàm số mũ và hàm số lôgarit</a>
                                    <ul>
                                        <li><i class="fa fa-file"></i><a href="#">Chủ đề 2: Hàm số lũy thừa, hàm số mũ và Hàm số lôgarit</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">Ứng dụng đạo hàm để khảo sát và vẽ đồ thị của hàm số</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">Ứng dụng đạo hàm để khảo sát và vẽ đồ thị của hàm số</a></li>
                                    </ul>
                                </li>
                                <li><i class="fa fa-folder-open"></i><a href="#">Hàm số lũy thừa, hàm số mũ và hàm số lôgarit</a>
                                    <ul>
                                        <li><i class="fa fa-file"></i><a href="#">Chủ đề 2: Hàm số lũy thừa, hàm số mũ và Hàm số lôgarit</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">Ứng dụng đạo hàm để khảo sát và vẽ đồ thị của hàm số</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">Ứng dụng đạo hàm để khảo sát và vẽ đồ thị của hàm số</a></li>
                                    </ul>
                                </li>
                                <li><i class="fa fa-folder-open"></i><a href="#">Hàm số lũy thừa, hàm số mũ và hàm số lôgarit</a>
                                    <ul>
                                        <li><i class="fa fa-file"></i><a href="#">Chủ đề 2: Hàm số lũy thừa, hàm số mũ và Hàm số lôgarit</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">Ứng dụng đạo hàm để khảo sát và vẽ đồ thị của hàm số</a></li>
                                        <li><i class="fa fa-file"></i><a href="#">Ứng dụng đạo hàm để khảo sát và vẽ đồ thị của hàm số</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div> 
                        <div class="tab">
                            Thảo luận:
                            <div class="fb-comments" data-href="http://toannang.dev/hoc-online.html" data-numposts="5" data-width="100%"></div>
                        </div>  
                        <div class="tab">
                            Danh sách thành viên
                            <div class="bs-example">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ảnh đại diện</th>
                                            <th>Họ tên</th>
                                            <th>Ngày đăng ký</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><img data-src="holder.js/50x50" class="img-rounded" alt="50x50" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 50px; height: 50px;"></td>
                                            <td>Nguyễn Khải Ngân</td>
                                            <td>15/09/2017 3:50</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><img data-src="holder.js/50x50" class="img-rounded" alt="50x50" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 50px; height: 50px;"></td>
                                            <td>Nguyễn Khải Ngân</td>
                                            <td>15/09/2017 3:50</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><img data-src="holder.js/50x50" class="img-rounded" alt="50x50" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 50px; height: 50px;"></td>
                                            <td>Nguyễn Khải Ngân</td>
                                            <td>15/09/2017 3:50</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><img data-src="holder.js/50x50" class="img-rounded" alt="50x50" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+" style="width: 50px; height: 50px;"></td>
                                            <td>Nguyễn Khải Ngân</td>
                                            <td>15/09/2017 3:50</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                        <div class="tab">
                            <p>Một đầu tư rất lớn về thời gian và tiền bạc như vậy mà mục đích lại không rõ ràng thì thật là kỳ lạ. Tất cả đều quay cuồng dạy và học, đua nhau nhồi nhét kiến thức, mà rất ít khi dừng lại tự hỏi: Học để làm gì? Xét rộng hơn cho cả hệ thống thì kết luận cũng tương tự. Khi câu hỏi “Học để làm gì?”.</p>
                        </div>  
                    </div><!---END #content_tabs-->
                </div><!---END #tabs-->	
            </div>
        </div>
    </div>
</div>

@endsection

