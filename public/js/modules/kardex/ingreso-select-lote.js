/**
 * Created by brodriguez on 01/06/17.
 */

$(document).ready(function(){
    $("a.lote").on('click',function(event){

        event.preventDefault();
        event.stopImmediatePropagation();


        //if not call by ajax
        //submit to showformAction

        if (is_xmlhttprequest == 0)
            return true;

        var idlote = $(this).attr("id");
        var numlote = $(this).text();

        $('input[name="MovimientoIngreso[detalles]['+item+'][lote]"]').val(idlote);
        $('input[name="MovimientoIngreso[detalles]['+item+'][numlote]"]').val(numlote);

        var almacen = $('select#almacen[name="MovimientoIngreso[movimiento][almacen]"]').val();
        var producto = $('input:hidden[name="MovimientoIngreso[detalles]['+item+'][producto]"]').val();

        $.ajax({
            url: '/kardex/ingreso/validar-lote',
            type: 'POST',
            dataType: 'json',
            data: {lote:idlote, producto:producto, almacen: almacen},
            success: function(data, status){
                var error = data.error;
                if (!error){
                    if (data.hayProducto){
                        if (data.existeDetalle){
                            console.log("Existe Detalle");
                            $('input[name="MovimientoIngreso[detalles]['+item+'][producto]"]').val(data.detalle[0].producto);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][nombproducto]"]').val(data.detalle[0].nombproducto);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').val(data.detalle[0].costo);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').val(data.detalle[0].vencimiento);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('disabled','disabled');
                            $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('readonly', 'readonly');
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('disabled','disabled');
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('readonly','readonly');
                        } else {
                            console.log("No Existe Detalle");
                            $('input[name="MovimientoIngreso[detalles]['+item+'][producto]"]').val(data.producto[0].id);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][nombproducto]"]').val(data.producto[0].nombre);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').val(null);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').val(null);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('disabled',null);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][costo]"]').attr('readonly', null);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('disabled',null);
                        }

                        if (data.almacen == 'Detal') {
                            console.log(data.almacen);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').val(null);
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('disabled','disabled');
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('readonly','readonly');
                            $('input[name="MovimientoIngreso[detalles]['+item+'][vencimiento]"]').attr('placeholder','No Aplica');
                        }
                    }
                } else {
                    alert(data.mensaje);
                }
            }
        });


        var error = false;

        if (!error){
            $("#winpopup").dialog('close');
        }

        return false;
    });

    $("a#nuevo").on('click',function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var almacen = $('select#almacen[name="MovimientoIngreso[movimiento][almacen]"]').val();
        var error = false;

        $.ajax({
            url:'/kardex/ingreso/nuevo-lote',
            type:'POST',
            dataType: 'json',
            data: {almacen:almacen},
            success: function(data){
                error = data.error;
                if (!error){
                    $('input[name="MovimientoIngreso[detalles]['+item+'][lote]"]').val(null);
                    $('input[name="MovimientoIngreso[detalles]['+item+'][numlote]"]').val(data.numlote);
                } else {
                    alert(data.mensaje);
                }
            }
        });

        if (!error){
            $("#winpopup").dialog('close');
        }

        return false;
    });
});
