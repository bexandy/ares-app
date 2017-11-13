/**
 * Created by brodriguez on 03/06/17.
 */

$(document).ready(function(){

    var url = '/kardex/ingreso/get-producto';
    //return false;
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'html',
        data: {marca:0, categoria:0},
        success: function(data, status){
            $('#getProductos').html(data);
        }
    });

});