$(window).on('load', function() {
    $('.j-save-keys').click(function (){
        saveKeys();
    });

    function saveKeys() {
        var keys = generateKey();

        keys.then(function (value) {
            var privateKey = value.privateKey;
            var publicKey = value.publicKey;

            download(JSON.stringify(privateKey), 'key_private', 'text/plain');
            download(JSON.stringify(publicKey), 'key_public', 'text/plain');
        });
    }

    function download(content, fileName, contentType) {
        var a = document.createElement("a");
        var file = new Blob([content], {type: contentType});
        a.href = URL.createObjectURL(file);
        a.download = fileName;
        a.click();
    }
});