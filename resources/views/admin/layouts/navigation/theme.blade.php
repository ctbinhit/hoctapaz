<div class="menu_section">
    <h3>Giao diện</h3>
    <ul class="nav side-menu">
        @if(Route::has('mdle_pmn_index'))
        <li><a href="{{route('mdle_pmn_index','header')}}"><i class="fa fa-bell"></i> Thông báo trang</a></li>
        @endif

        @if(Route::has('mdle_slider_index'))
        <li><a href="{{route('mdle_slider_index','slider_top')}}"><i class="fa fa-clone"></i> Slider top</a></li>
        <li><a href="{{route('mdle_slider_index','slider_content')}}"><i class="fa fa-clone"></i> Slider content</a></li>
        @endif
        @if(Route::has('mdle_background_index'))
        <li><a href="{{route('mdle_background_index','footer')}}"><i class="fa fa-photo"></i> Background footer</a></li>
        @endif
    </ul>
</div>