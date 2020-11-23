$(window).on('load', function() {

    // $('.j-add-form').attr('action','');

    $('.j-add-form').submit(function(e){
        e.preventDefault();

        var file_name = '';
        var file_path = '';


        $('.j-user-file').val();
        $('.j-user-file').val();

        console.log(file_name);
        console.log(file_path);



        // $.ajax({
        //     url: '../add.php',
        //     data: {
        //         file_name: file_name,
        //         file_path: file_path,
        //     },
        //     processData: false,
        //     contentType: false,
        //     type: 'POST',
        //     success: function (data) {
        //         console.log(data);
        //     }
        // });
    });


    // $('.j-add1').click(function (){
    //     $.ajax({
    //         url: '../add.php',
    //         type: 'post',
    //         data: {file_name:'file.docx'},
    //         success: function(response){
    //             console.log(response)
    //
    //         }
    //     });
    // });


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
        }
    });

    $('.j-user-key').change(function () {
        if( $(this).val().length > 0 ) {
            sendFile();
        }
        else {

        }
    });

    function sendFile() {
        var file_name = '';
        var file_data = '';

        getFile(function (file_private_key,name) {
            var private_key = JSON.parse(file_private_key);

            getFile(function (user_file,name) {

                file_name = name;
                file_data = user_file;

                sign(private_key,user_file).then(function (signature) {

                    console.log(file_name);
                    console.log(signature);

                    $.ajax({
                        url: '../add.php',
                        data: {
                            file_name: file_name,
                            file_data: file_data,
                            signature: signature,
                        },
                        type: 'POST',
                        success: function (data) {
                            console.log(data);
                        }
                    });
                });
            },'user-file');

        },'user-key');
    }

    function getFile(callback, inputID) {
        var file = document.getElementById(inputID).files[0];

        if (file) {
            var reader = new FileReader();
            reader.readAsText(file, "UTF-8");

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