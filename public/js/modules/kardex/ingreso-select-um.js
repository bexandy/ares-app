/**
 * Created by brodriguez on 05/06/17.
 */
$(document).ready(function(){
    $("a.list-group-item").on('click',function(event){
        event.preventDefault();
        event.stopImmediatePropagation();

        var id = $(this).children('h3').attr('id');
        var valor = $(this).children('p').text();
        valor = valor.replace("(","");
        valor = valor.replace(")","");

        $('input[name="MovimientoIngreso[detalles]['+item+'][um]"]').val(id);
        $('input[name="MovimientoIngreso[detalles]['+item+'][unidadmedida]"]').val(valor);

        $("#winpopup").dialog('close');

        return false;
    });
});