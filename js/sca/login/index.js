$(function() {
    var tab = $("#myTab");
    var tipoCliente = $("#tipoCliente");

    $('a[data-toggle="tab"]', tab).on('show', function(e) {
        $(":input", e.target.hash).removeAttr("disabled") // activated tab
        $(":input", e.relatedTarget.hash).attr("disabled", "disabled") // previous tab
    })
    
    
})