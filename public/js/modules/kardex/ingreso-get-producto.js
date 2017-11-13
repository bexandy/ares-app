/**
 * Created by brodriguez on 03/06/17.
 */

$(document).ready(function(){
    $("#marca").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var marca = $select.val();
        var categoria = $("#categoria").val();
        getProductos(marca,categoria);
    });

    $("#categoria").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var categoria = $select.val();
        var marca = $("#marca").val();
        getProductos(marca,categoria);
    });

    function getProductos(marca,categoria){
        $.ajax({
            url: '/kardex/ingreso/get-producto',
            type: 'POST',
            dataType: 'html',
            data: {marca:marca, categoria:categoria},
            success: function(data, status){
                $('#getProductos').html(data);
            }
        });
    }

    $("div#productos").on('click', 'a.list-group-item', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var producto = $(this).attr('value');
        var lote = $('input:hidden[name="MovimientoIngreso[detalles]['+item+'][lote]"]').attr('value');
        var almacen = $('select#almacen[name="MovimientoIngreso[movimiento][almacen]"]').val();
        //alert("item: "+item+" lote: "+lote+" producto: "+producto+" almacen: "+almacen);

        $.post(
            '/kardex/ingreso/validar-producto',
            {'lote': lote, 'producto': producto, 'almacen': almacen },
            function(itemJson){
                console.log("Respuesta de validarProducto");
                if (! itemJson.error){
                    console.log("Error = False");
                    if (itemJson.existeDetalle){
                        console.log("Existe Detalle");
                        $('input[name="MovimientoIngreso[detalles]['+item+'][producto]"]').val(itemJson.detalle[0].producto);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][nombproducto]"]').val(itemJson.detalle[0].nombproducto);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').val(itemJson.detalle[0].costo);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').val(itemJson.detalle[0].vencimiento);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('disabled','disabled');
                        $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('readonly', 'readonly');
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('disabled','disabled');
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('readonly','readonly');
                    } else {
                        console.log("No Existe Detalle");
                        $('input[name="MovimientoIngreso[detalles]['+item+'][producto]"]').val(itemJson.producto[0].id);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][nombproducto]"]').val(itemJson.producto[0].nombre);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').val(null);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').val(null);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('disabled',null);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('readonly', null);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('disabled',null);
                       }

                    if (itemJson.almacen == 'Detal') {
                        console.log(itemJson.almacen);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').val(null);
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('disabled','disabled');
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('readonly','readonly');
                        $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('placeholder','No Aplica');
                    }
                } else {
                    alert(itemJson.mensaje);
                }
            }, 'json'
        );

        $("#winpopup").dialog('close');
    });

});