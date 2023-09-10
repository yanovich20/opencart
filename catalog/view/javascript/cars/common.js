$(document).ready(function() {
    var content = $('#hiddenContent');

    $("#showHideContent").click(function (e) {
        e.preventDefault();
        if (content.is(":hidden")) {
            content.slideDown('fast');
            $(this).html('Компактный поиск');
        } else {
            content.slideUp('fast');
            $(this).html('Расширенный поиск');
        }
    });

    var overlay = $('.overlay');
    var modal = $('.modal');

    $('.call-button').click(function(e) {
        e.preventDefault();
        overlay.fadeIn(200);
        modal.fadeIn(200);
    });

    $('.modal__close').click(function (e) {
        e.preventDefault();
        $('.overlay, .modal').hide();
    });

    overlay.click(function () {
        $(this).hide();
        modal.hide();
    });

    $('.catalog__sort a').click(function(e) {
        e.preventDefault();
        if($(this).hasClass('active')) {
            if($(this).find('.catalog__icon').hasClass('catalog__icon_type_down')) {
                $(this).find('.catalog__icon').removeClass('catalog__icon_type_down');
                $(this).find('.catalog__icon').addClass('catalog__icon_type_up');
            }
            else {
                $(this).find('.catalog__icon').removeClass('catalog__icon_type_up');
                $(this).find('.catalog__icon').addClass('catalog__icon_type_down');
            }
        }
        else {
            $('.catalog__sort a').removeClass('active');
            $(this).addClass('active');
            $(this).find('.catalog__icon').show();
        }
    });
});