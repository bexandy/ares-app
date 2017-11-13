/**
 * Created by brodriguez on 09/05/17.
 */
$(document).ready(function() {

    $("#agregar").on('click', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();

        var currentCount = $('#detalles > fieldset > fieldset').length;
        var template = $('#detalles > fieldset > span').data('template');
        template = template.replace(/__placeholder__/g, currentCount);

        var b = $('<button><i class="fa fa-remove" style="font-size: 16px; "></i></button>');
        b.appendTo(template);

        $('#detalles > fieldset').append(template);

        var  opcion = $('input:radio[name="MovimientoIngreso[opciones][opcLote]"]:checked').val();

        if (opcion != 'individual'){


            var iddefault = $('input[name="MovimientoIngreso[opciones][idLoteDefault]"]').val();
            var lotdefault = $('input[name="MovimientoIngreso[opciones][loteDefault]"]').val();

            $('input[name="MovimientoIngreso[detalles]['+currentCount+'][lote]"]').val(iddefault);
            $('input[name="MovimientoIngreso[detalles]['+currentCount+'][numlote]"]').val(lotdefault);
            $('input[name="MovimientoIngreso[detalles]['+currentCount+'][numlote]"]').attr('disabled','disabled');
        }

        return false;

    });

    $("div#detalles").on('click','input[placeholder=Lote]',function(){
        var almacen = $('select#almacen[name="MovimientoIngreso[movimiento][almacen]"]').val();
        if (almacen == ""){
            alert("Debe seleccionar el Almacén de destino del movimiento antes de realizar esta acción");
            return true;
        }

        var item = $(this).attr('name');
        item = item.replace("MovimientoIngreso[detalles][","");
        item = item.replace("][numlote]","");
        $("#winpopup").dialog({
            draggable:true,
            modal: true,
            autoOpen: false,
            height:400,
            width:650,
            resizable: false,
            title:'Seleccione el Lote para el Item: '+item
        });
        $("#winpopup").load("/kardex/ingreso/select-lote",{iditem: item, almacen: almacen});
        $("#winpopup").dialog("open");

        return false;
    });

    $("div#detalles").on('click','input[placeholder=Producto]',function(){
        var almacen = $('select#almacen[name="MovimientoIngreso[movimiento][almacen]"]').val();
        if (almacen == ""){
            alert("Debe seleccionar el Almacén de destino del movimiento antes de realizar esta acción");
            return true;
        }
        var item = $(this).attr('name');
        item = item.replace("MovimientoIngreso[detalles][","");
        item = item.replace("][nombproducto]","");
        $("#winpopup").dialog({
            draggable:true,
            modal: true,
            autoOpen: false,
            height:400,
            width:650,
            resizable: false,
            title:'Seleccione el Producto para el Item: '+item
        });
        $("#winpopup").load("/kardex/ingreso/select-producto",{iditem: item, marca:0, categoria:0});
        $("#winpopup").dialog("open");

        return false;
    });

    $('select#almacen').on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();

        var currentCount = $('#detalles > fieldset > fieldset').length;
        $('input[name="MovimientoIngreso[opciones][loteDefault]"]').val(null);
        $('input[name="MovimientoIngreso[opciones][idLoteDefault]"]').val(null);
        $('input:radio[name="MovimientoIngreso[opciones][opcLote]"][value="individual"]').prop('checked',true);
        for (var i = 0; i < currentCount; i++){
            $('input[name="MovimientoIngreso[detalles]['+i+'][lote]"]').val(null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][numlote]"]').val(null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][numlote]"]').attr('disabled',null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').val(null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('disabled',null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('readonly',null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').val(null);
            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('placeholder','FVenc');
            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('disabled',null);
        }
        return false;
    });

    $("div#detalles").on('click','input[placeholder=UM]',function(){
        var almacen = $('select#almacen[name="MovimientoIngreso[movimiento][almacen]"]').val();
        if (almacen == ""){
            alert("Debe seleccionar el Almacén de destino del movimiento antes de realizar esta acción");
            return true;
        }
        var item = $(this).attr('name');
        item = item.replace("MovimientoIngreso[detalles][","");
        item = item.replace("][unidadmedida]","");
        $("#winpopup").dialog({
            draggable:true,
            modal: true,
            autoOpen: false,
            width:250,
            resizable: false,
            title:'Seleccione la Unidad de Medida para el Item: '+item
        });
        $("#winpopup").load("/kardex/ingreso/select-u-m",{iditem: item, marca:0, categoria:0});
        $("#winpopup").dialog("open");

        return false;
    });


    $(document).on('focus click', '.datepicker', function() {
        $(this).datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function (date) {
                $(this).val(date);
            },
        });
    });


    $('input:radio[name="MovimientoIngreso[opciones][opcLote]"]').on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();

        var almacen = $('select#almacen[name="MovimientoIngreso[movimiento][almacen]"]').val();
        if (almacen == ""){
            alert("Debe seleccionar el Almacén de destino del movimiento antes de realizar esta acción");
            return true;
        }

        var opcion = $(this).val();
        var currentCount = $('#detalles > fieldset > fieldset').length;

        if (opcion == 'individual') {
            $('input[name="MovimientoIngreso[opciones][loteDefault]"]').val(null);
            $('input[name="MovimientoIngreso[opciones][idLoteDefault]"]').val(null);
            for (var i = 0; i < currentCount; i++){
                $('input[name="MovimientoIngreso[detalles]['+i+'][numlote]"]').attr('disabled',null);
                $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').val(null);
                $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('disabled',null);
                $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('readonly',null);
                $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').val(null);
                $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('placeholder','FVenc');
                $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('disabled',null);
            }
        }

        if (opcion == 'nuevo') {
            $.ajax({
                url: '/kardex/ingreso/nuevo-lote',
                type: 'POST',
                dataType: 'json',
                data: {almacen: almacen},
                success: function(data){
                    var error = data.error;
                    if (!error){
                        var numlote = data.numlote;
                        $('input[name="MovimientoIngreso[opciones][loteDefault]"]').val(numlote);
                        $('input[name="MovimientoIngreso[opciones][idLoteDefault]"]').val(null);
                        for (var i = 0; i < currentCount; i++){
                            $('input[name="MovimientoIngreso[detalles]['+i+'][numlote]"]').val(numlote);
                            $('input[name="MovimientoIngreso[detalles]['+i+'][lote]"]').val(null);
                            $('input[name="MovimientoIngreso[detalles]['+i+'][numlote]"]').attr('disabled','disabled');
                            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').val(null);
                            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('disabled',null);
                            $('input[name="MovimientoIngreso[detalles]['+i+'][costo]"]').attr('readonly',null);
                            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').val(null);
                            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('placeholder','FVenc');
                            $('input[name="MovimientoIngreso[detalles]['+i+'][vencimiento]"]').attr('disabled',null);
                        }
                    } else {
                        alert(data.mensaje);
                    }
                }
            });
        }

        if (opcion == 'unico') {
            $("#winpopup").dialog({
                draggable:true,
                modal: true,
                autoOpen: false,
                height:400,
                width:650,
                resizable: false,
                title:'Seleccione el Lote por Defecto'
            });
            $("#winpopup").load("/kardex/ingreso/select-default-lote",{almacen: almacen});
            $("#winpopup").dialog("open");
        }
        return false;
    });
});




