$(window).on('load', function() {

    $('.j-user-file').change(function () {
        if( $(this).val().length > 0 ) {
            $('.j-user-key-container').addClass('is-active');
        }
        else {
            $('.j-user-key-container').removeClass('is-active');
            $('.j-submit-add').removeClass('is-active');
        }
    });

    $('.j-user-key').change(function () {
        if( $(this).val().length > 0 ) {
            $('.j-submit-add').addClass('is-active');
        }
        else {
            $('.j-submit-add').removeClass('is-active');
        }
    });

    $('.j-add-form').submit(function(e){
        e.preventDefault();

        if($('.j-user-file').val() && $('.j-user-key').val()) {
            sendFile();
        }
    });

    function sendFile() {
        var file_name = '';
        var file_data = '';

        getFile(function (file_private_key,name) {
            var private_key = JSON.parse(file_private_key);

            getFile(function (file_data,file_name) {

                sign(private_key,file_data).then(function (signature) {

                    $.ajax({
                        url: '../add.php',
                        data: {
                            file_name: file_name,
                            file_data: file_data,
                            signature: signature,
                        },
                        type: 'POST',
                        success: function (data) {
                            console.log(file_data);
                            console.log(signature);
                            console.log(data);

                            if(data == "1") {
                                console.log("reload");
                                document.location.reload();
                            }
                            else {
                                alert("Error: file haven't been upload");
                            }
                        }
                    });
                });
            },'user-file',"readAsDataURL");
        },'user-key');
    }

    function getFile(callback, inputID, readType) {
        var file = document.getElementById(inputID).files[0];

        if (file) {
            var reader = new FileReader();

            if(readType == "readAsDataURL") {
                reader.readAsDataURL(file);
            }
            else {
                reader.readAsText(file,"UTF-8");
            }

            reader.onload = function (evt) {
                callback(evt.target.result,file.name);
            }

            reader.onerror = function (evt) {
                callback(false);
            }
        }
    }
});