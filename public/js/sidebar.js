$(document).ready(function () {
    $('.navbar .sidebar-collapse').on('click', function () {
        $('.sidebar').toggleClass('active');
        $('.sidebar').toggleClass('closed');
        $('.wrapper .content').toggleClass('active');
        $('.navbar .sidebar-logo').toggleClass('active');
    });

    $(".accordion-dropdown").click(function () {
        $(this).find('.arrow').toggleClass("bi-chevron-down bi-chevron-right");
    });

    $('.sidebar').hover(
        function () {
            if ($(this).hasClass('closed')) {
                $(this).removeClass('active');
            }
        },
        function () {
            if($(this).hasClass('closed')) {
                $(this).addClass('active');
            }
        }
    );
});