$(window).on('load', function() {
    $('.j-check-signature').click(function () {
        var button = $(this);

        var index = button.attr('data-index');
        var user_id = button.attr('data-userID');
        var signature = button.attr('data-signature');

        var public_key = '';
        var user_file = '';

        $.ajax({
            async: false,
            url: '../api/index.php',
            data: {
                get: 'publicKey',
                id: user_id,
            },
            type: 'GET',
            success: function (dataJSON) {
                data = JSON.parse(dataJSON);
                public_key = data.publicKey;
            }
        });

        $.ajax({
            async: false,
            url: '../api/index.php',
            data: {
                get: 'fileData',
                id: index,
            },
            type: 'GET',
            success: function (dataJSON) {
                data = JSON.parse(dataJSON);
                user_file = data.fileData;
            }
        });

        verify(public_key, signature, user_file).then(function (value) {
            console.log("Result: " + value);

            if(value === true) {
                button.html('<svg version="1.1" width="20px" height="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 367.805 367.805" style="enable-background:new 0 0 367.805 367.805;" xml:space="preserve"><g><path style="fill:#3BB54A;" d="M183.903,0.001c101.566,0,183.902,82.336,183.902,183.902s-82.336,183.902-183.902,183.902 S0.001,285.469,0.001,183.903l0,0C-0.288,82.625,81.579,0.29,182.856,0.001C183.205,0,183.554,0,183.903,0.001z"/><polygon style="fill:#fafafa;" points="285.78,133.225 155.168,263.837 82.025,191.217 111.805,161.96 155.168,204.801 256.001,103.968"/></g></svg>');
            }
            else {
                button.html('<svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 0" fill="#f44336"/><path d="m350.273438 320.105469c8.339843 8.34375 8.339843 21.824219 0 30.167969-4.160157 4.160156-9.621094 6.25-15.085938 6.25-5.460938 0-10.921875-2.089844-15.082031-6.25l-64.105469-64.109376-64.105469 64.109376c-4.160156 4.160156-9.621093 6.25-15.082031 6.25-5.464844 0-10.925781-2.089844-15.085938-6.25-8.339843-8.34375-8.339843-21.824219 0-30.167969l64.109376-64.105469-64.109376-64.105469c-8.339843-8.34375-8.339843-21.824219 0-30.167969 8.34375-8.339843 21.824219-8.339843 30.167969 0l64.105469 64.109376 64.105469-64.109376c8.34375-8.339843 21.824219-8.339843 30.167969 0 8.339843 8.34375 8.339843 21.824219 0 30.167969l-64.109376 64.105469zm0 0" fill="#fafafa"/></svg>');
            }
        });
    });
});