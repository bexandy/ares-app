/**
 * Created by brodriguez on 23/02/17.
 */
$(document).ready(function(){

    $("button#boton-detalles").on('click', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var currentCount = $('form  fieldset > fieldset').length;

        var template = $('form  fieldset > span').data('template');
        template = template.replace(/__placeholder__/g, currentCount);

        $('form  fieldset:first-child').append(template);

        return false;
    });

});