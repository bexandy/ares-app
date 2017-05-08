/**
 * Created by brodriguez on 13/02/17.
 */
jQuery(document).ready(function() {

    jQuery('.pagination a').unbind('click');
    jQuery('.pagination a').click(function(event){

        event.preventDefault();
        var url = jQuery(this).attr('href');
        if(url == '#') return false;
        var categoria = $("#categoria").val();
        var almacen = $("#almacen").val();
        var marca = $("#marca").val();
        var urlmarca = '';
        if (marca !== ''){
            urlmarca = '/marca/'+marca;
        }
        var urlcategoria = '';
        if (categoria !== ''){
            urlcategoria = '/categoria/'+categoria;
        }
        var urlalmacen = '';
        if (almacen !== ''){
            urlalmacen = '/almacen/'+almacen;
        }

        getInventarioList(url+urlmarca+urlcategoria+urlalmacen);

    });


    jQuery("#marca").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var marca = $select.val();
        var categoria = $("#categoria").val();
        var almacen = $("#almacen").val();
        var urlbase = $("#urlbase").val();
        var page = '/page/' + $("#pageNo").val();
        var urlmarca = '';
        if (marca !== ''){
            urlmarca = '/marca/'+marca;
        }
        var urlcategoria = '';
        if (categoria !== ''){
            urlcategoria = '/categoria/'+categoria;
        }
        var urlalmacen = '';
        if (almacen !== ''){
            urlalmacen = '/almacen/'+almacen;
        }

        var url = urlbase+page+urlmarca+urlcategoria+urlalmacen;
        getInventarioList(url);
    });

    jQuery("#categoria").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var categoria = $select.val();
        var marca = $("#marca").val();
        var almacen = $("#almacen").val();
        var urlbase = $("#urlbase").val();
        var page = '/page/' + $("#pageNo").val();
        var urlmarca = '';
        if (marca !== ''){
            urlmarca = '/marca/'+marca;
        }
        var urlcategoria = '';
        if (categoria !== ''){
            urlcategoria = '/categoria/'+categoria;
        }
        var urlalmacen = '';
        if (almacen !== ''){
            urlalmacen = '/almacen/'+almacen;
        }

        var url = urlbase+page+urlmarca+urlcategoria+urlalmacen;
        getInventarioList(url);
    });

    jQuery("#almacen").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var almacen = $select.val();
        var categoria = $("#categoria").val();
        var marca = $("#marca").val();
        var urlbase = $("#urlbase").val();
        var page = '/page/' + $("#pageNo").val();
        var urlmarca = '';
        if (marca !== ''){
            urlmarca = '/marca/'+marca;
        }
        var urlcategoria = '';
        if (categoria !== ''){
            urlcategoria = '/categoria/'+categoria;
        }
        var urlalmacen = '';
        if (almacen !== ''){
            urlalmacen = '/almacen/'+almacen;
        }

        var url = urlbase+page+urlmarca+urlcategoria+urlalmacen;
        getInventarioList(url);
    });
});

function getInventarioList(url){
    jQuery.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        data: {},
        success: function(data, status){
            jQuery('#getInventarioList').html(data);
            jQuery('#pageNo').val('<?php echo $this->page; ?>');
        }
    });
}