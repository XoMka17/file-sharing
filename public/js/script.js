$(window).on('load', function() {
    $('.j-check-info').click(function () {
        var button = $(this);

        var index = button.attr('data-index');
        var signature = button.attr('data-signature');
    });
});