$(document).ready(function () {
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    // $('div.flash').not('.alert-important').delay(3000).fadeOut(350);
    function clearForm(form) {

    }

    $('#staff_tbl').DataTable({
        "ordering": true,
        'lengthChange':false,
    });
});
