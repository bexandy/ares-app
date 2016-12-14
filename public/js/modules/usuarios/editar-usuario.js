/**
 * Created by brodriguez on 06/12/16.
 */

$(document).ready(function() {

    $("#select_roles").on('change', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var $select = $(this);
        var rolId = $select.val();
        $("#rolId").val(rolId);
    });

});
