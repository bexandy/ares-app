/**
 * Created by brodriguez on 22/04/17.
 */
$(document).ready(function() {

    $("#marca").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var marca = $select.val();
        var categoria = $("#categoria").val();
        var urlbase = $("#urlbase").val();
        var urlmarca = '';
        if (marca !== ''){
            urlmarca = '/marca/'+marca;
        }
        var urlcategoria = '';
        if (categoria !== ''){
            urlcategoria = '/categoria/'+categoria;
        }
        var url = urlbase+urlmarca+urlcategoria;
        getProductos(url);
    });

    $("#categoria").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var categoria = $select.val();
        var marca = $("#marca").val();
        var urlbase = $("#urlbase").val();
        var urlmarca = '';
        if (marca !== ''){
            urlmarca = '/marca/'+marca;
        }
        var urlcategoria = '';
        if (categoria !== ''){
            urlcategoria = '/categoria/'+categoria;
        }

        var url = urlbase+urlmarca+urlcategoria;
        getProductos(url);
    });
});

function getProductos(url){
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        data: {},
        success: function(data, status){
            $('#getProductos').html(data);
        }
    });
}