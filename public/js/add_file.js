$(window).on('load', function() {

    $('.j-add').click(function (){
        $.ajax({
            url: 'add.php',
            type: 'post',
            data: {file_name:'file.docx'},
            success: function(response){
                console.log(response)

            }
        });
    });
});