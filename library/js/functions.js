// No conflict just in case
var $j = jQuery;
jQuery(document).ready(function() {
    jQuery('#license_expiration').datepicker({
        dateFormat : 'dd-mm-yy'
    });
});
function license_distribution_generate_license(){
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 32; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    jQuery("#product_license").val(text);
}