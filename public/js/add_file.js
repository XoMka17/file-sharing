$(window).on('load', function() {

    // $('.j-add-form').attr('action','');

    $('.j-add-form').submit(function(e){
        e.preventDefault();

        if($('.j-user-file').val() && $('.j-user-key').val()) {
            sendFile();
        }
    });

    $('.j-save-keys').click(function (){
        saveKeys();
    });

    function saveKeys() {
        var keys = generateKey();

        keys.then(function(value) {
            var privateKey = value.privateKey;
            var publicKey = value.publicKey;

            download(JSON.stringify(privateKey), 'key_private', 'text/plain');
            download(JSON.stringify(publicKey), 'key_public', 'text/plain');
        });
    }



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

    function sendFile() {
        var file_name = '';
        var file_data = '';

        getFile(function (file_private_key,name) {
            var private_key = JSON.parse(file_private_key);

            getFile(function (file_data,name) {

                file_name = name;
                // file_data = bin2hex(file_data);
                // file_data = toUnicode(file_data);
                // file_data = btoa(file_data);
                // file_data = strEncodeUTF16(file_data);



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
                        }
                    });
                });
            },'user-file',"readAsDataURL");

        },'user-key');
    }

    function getFile(callback, inputID, readType, encoding = "UTF-8") {
        var file = document.getElementById(inputID).files[0];

        if (file) {
            var reader = new FileReader();

            if(readType == "readAsDataURL") {
                reader.readAsDataURL(file);
            }
            else {
                reader.readAsText(file, encoding);
            }

            reader.onload = function (evt) {
                callback(evt.target.result,file.name);
            }

            reader.onerror = function (evt) {
                callback(false);
            }
        }
    }

    function download(content, fileName, contentType) {
        var a = document.createElement("a");
        var file = new Blob([content], {type: contentType});
        a.href = URL.createObjectURL(file);
        a.download = fileName;
        a.click();
    }
});