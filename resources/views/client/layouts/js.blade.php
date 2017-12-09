<!--facebook-->
<!--<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>-->
<!--Facebook-->

<!--fixed thanh menu-->
<script type="text/javascript">
    $(document).ready(function () {
        $(window).scroll(function () {
            var cach_top = $(window).scrollTop();
            var heaigt_header = $('.header-top').height();
            if (cach_top >= heaigt_header) {
                $('#banner').css({position: 'fixed', top: '0px', zIndex: 999});
            } else {
                $('#banner').css({position: 'relative'});
            }
        });
    });
</script>
<!--End fixed thanh menu-->

<script type="text/javascript">
$(document).ready(function(){
    $(".menu i").click(function(){
        $(".menu ul").toggle(500);
    });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".search i").click(function(){
        $(".conten_search").toggle(500);
    });
});
</script>
<!--End jQuery toggle-->

<!--tab slide -->
<script type="text/javascript">
    $(document).ready(function () {
        $('ul.tabs li').click(function () {
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        });

    });
</script>
<!--tab slide -->