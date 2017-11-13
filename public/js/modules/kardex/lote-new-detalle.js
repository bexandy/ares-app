/**
 * Created by brodriguez on 31/10/16.
 */
$(document).ready(function(){
    $("#showform-lote").click(function(){
        $("#winpopup").dialog({
            draggable:true,
            modal: true,
            autoOpen: false,
            height:400,
            width:650,
            resizable: false,
            title:'Seleccione el Lote'
        });
        $("#winpopup").load($(this).attr('href'));
        $("#winpopup").dialog("open");

        return false;
    });

    $("#showform-producto").click(function(){
        $("#winpopup").dialog({
            draggable:true,
            modal: true,
            autoOpen: false,
            height:400,
            width:650,
            resizable: false,
            title:'Seleccione el Producto'
        });
        $("#winpopup").load($(this).attr('href'));
        $("#winpopup").dialog("open");

        return false;
    });

    var $vencimiento = $('#vencimiento').val();

    $( "#vencimiento" ).datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function (date) {
            $vencimiento = date;
        },
    });


});