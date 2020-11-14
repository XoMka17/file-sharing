$(window).on('load', function() {

    var current_popup = '';
    $('.j-open').click(function (){
        current_popup = $(this).attr('data-popup');

        $('#' + current_popup).addClass('is-opened');
    });

    $('.j-close').click(function (){
        $('#' + current_popup).removeClass('is-opened');
    });
});