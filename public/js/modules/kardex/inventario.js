/**
 * Created by brodriguez on 13/02/17.
 */
$(document).ready(function() {

    $('.pagination a').unbind('click');
    $('.pagination a').click(function(event){

        event.preventDefault();
        var url = $(this).attr('href');
        if(url == '#') return false;

        getInventarioList(url);

    });

    $('a.sort').unbind('click');
    $('a.sort').click(function(event){
        event.preventDefault();

        var url = $(this).attr('href');
        if(url == '#') return false;
        getInventarioList(url);
    });

    $("#categoria").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var categoria = $select.val();
        var marca = $("#marca").val();


        $.post("kardex/inventario/get-inventario-list", {
                categoria: categoria,
                marca: marca
            },
            function(data){
                if(data.response == true) {
                    $('#getInventarioList').html(data);
                }
                else{
                    alert("Error en JSON");
                    console.log('could not remove ');
                }
            }, 'json');

        return false;
    });

    $("#marca").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var marca = $select.val();
        var categoria = $("#categoria").val();
        $.post("kardex/inventario/get-inventario-list", {
                categoria: categoria,
                marca: marca
            },
            function(data){
                if(data.response == true) {
                    $('#getInventarioList').html(data);
                }
                else{
                    alert("Error en JSON");
                    console.log('could not remove ');
                }
            }, 'json');

        return false;
    });

    function getInventarioList(url){
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            data: {},
            success: function(data, status){
                $('#getInventarioList').html(data);
            }
        });
    }

});