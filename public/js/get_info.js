$(window).on('load', function() {
    $('.j-get-info').click(function () {
        var button = $(this);
        var popup = $('#' + $(this).attr('data-popup'));

        var index = button.attr('data-index');
        var signature = button.attr('data-signature');

        popup.find('.j-info-index').html('<b>' + index + '</b>');
        popup.find('.j-info-signature').html('<b>' + signature + '</b>');
    });
});