$(function () {
    $(document).pjax('a', '#jquery-pjax-content');

});
// does current browser support PJAX
$(document).ready(function () {
    $.pjax.defaults.timeout = 100;

    $('a').on('click', function () {
        $('body').append('huahuhdsauhdaushduashduashuh');
    });
});

