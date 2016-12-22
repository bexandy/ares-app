/**
 * Created by brodriguez on 22/11/16.
 */
$(document).ready(function() {

    $( "#vencimiento" ).datepicker();
    $( "#ganancia" ).spinner();
    $( "#impuesto" ).spinner();

    if ($('#tieneimpuesto').is(':checked')){
        $('input:hidden[name="producto[tieneimpuesto]"]').val(1);
    } else {
        $('input:hidden[name="producto[tieneimpuesto]"]').val(0);
    }

    $("#tieneimpuesto").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        if ($('#tieneimpuesto').is(':checked')){
            $( "#impuesto" ).attr('disabled',null);
            $( "#impuesto" ).attr('readonly',null);
            $('input:hidden[name="producto[tieneimpuesto]"]').val(1);
        } else {
            $( "#impuesto" ).attr('disabled','disabled');
            $( "#impuesto" ).attr('readonly','readonly');
            $('input:hidden[name="producto[tieneimpuesto]"]').val(0);
            $('#impuesto').val(0);
        }
        calcularMontoVenta();
    });

    $("#categoria").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var categoria = $select.val();
        $("#idcategoria").val(categoria);
    });

    $("#marca").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var marca = $select.val();
        $("#idmarca").val(marca);
    });

    $("input[type=radio][name=mayor]").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var mayor = $select.val();
        $("#unidadmedidaalmacen").val(mayor);
    });

    $("input[name='detal']:radio").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var detal = $select.val();
        $("#unidadmedidaventas").val(detal);
    });

    $("#fileupload").on('change', function(event){
        if (this.files && this.files[0]) {
            console.log("entre al  if");
            var filerdr = new FileReader();
            filerdr.onload = function(e) {
                $('#imageupload').attr('src', e.target.result);
            }
            filerdr.readAsDataURL(this.files[0]);
        } else {
            console.log("No entre al if");
            console.log(this);
        }
    });

    $("#preciocosto").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        calcularMontoVenta();
    });

    $("#ganancia").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        calcularMontoVenta();
    });

    $("#impuesto").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        calcularMontoVenta();
    });


    function calcularMontoVenta() {
        var preciocosto = $('#preciocosto').val();
        var ganancia = $('#ganancia').val();
        var impuesto = $('#impuesto').val();
        var tieneimpuesto = $('#tieneimpuesto').val();
        var monto = preciocosto*(1+ganancia/100);
        if (tieneimpuesto = 1) {
            var montoventa = monto*(1+impuesto/100);
        } else {
            var montoventa = monto;
        }
        $('#preciounidad').val(montoventa);
    }
});
