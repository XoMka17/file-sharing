$(window).on('load', function() {
    $('.j-check-signature').click(function () {
        var index = $(this).attr('data-index');
        var user_id = $(this).attr('data-userID');
        var signature = $(this).attr('data-signature');


        $.ajax({
            url: '../api/index.php',
            data: {
                get: 'publicKey',
                id: user_id,
            },
            type: 'GET',
            success: function (data) {
                console.log(data);
                user_file = "1231231231231231231231231";

                public_key = JSON.parse(data);

                verify(public_key, signature, user_file).then(function (value) {
                    console.log("Result: " + value);
                });
            }
        });


    });
});