$(document).ready(function () {
    $('#recherche').keyup(function () {
        var recherche = $(this).val() ;
        var data = 'motcle' + recherche ;
        if (recherche.length>3){
            $.ajax({
                type : "GET",
                url : "result.php",
                data : data ,
                success: function (server_response) {
                    $("recherche").html(server_response).show() ;
                }
            });
        }
    });
});