/**
 * Created by brodriguez on 08/06/17.
 */
$(document).ready(function(){
    $("a.lote").on('click',function(event){

        event.preventDefault();
        event.stopImmediatePropagation();

        if (is_xmlhttprequest == 0)
            return true;

        var idlote = $(this).attr("id");
        var numlote = $(this).text();

        $('input[name="MovimientoIngreso[opciones][idLoteDefault]"]').val(idlote);
        $('input[name="MovimientoIngreso[opciones][loteDefault]"]').val(numlote);

        var currentCount = $('#detalles > fieldset > fieldset').length;

        for (var i = 0; i < currentCount; i++){
            $('input[name="MovimientoIngreso[detalles]['+i+'][numlote]"]').val(numlote);
            $('input[name="MovimientoIngreso[detalles]['+i+'][lote]"]').val(idlote);
            $('input[name="MovimientoIngreso[detalles]['+i+'][numlote]"]').attr('disabled','disabled');
            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').val(null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('disabled',null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('readonly',null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').val(null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('placeholder','FVenc');
            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('disabled',null);
        }

        $("#winpopup").dialog('close');

        return false;
    });

});