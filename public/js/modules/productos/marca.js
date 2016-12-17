/**
 * Created by brodriguez on 22/11/16.
 */
$(document).ready(function() {

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
});
