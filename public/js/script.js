$(document).ready(function () {
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    // $('div.flash').not('.alert-important').delay(3000).fadeOut(350);
    function clearForm(form) {

    }

    $('#staff_tbl').DataTable({
        "ordering": true,
        'lengthChange': false,
    });


    // Allowances and deductions
    // var  deduction = [], allowance = new Array;
    // $('input.allowance').on('change', function () {
    //     var amount = $(this).val();
    //     var id = $(this).data('id');
    //     var index = $(this).data('index');
    //     var input = new Array;
    //     input[0] = id;
    //     input[1] = amount;

    //     input = Array.from(input);
       
    //     allowance[index] = input;
    
    //     $('input#allowanceArray').val(allowance.join('*'));
    

    // });

    // $('input.deduction').on('change', function () {
    //     var amount = $(this).val();
    //     var id = $(this).data('id');
    //     var index = $(this).data('index');
    //     var input = [];
    //     input[0] = id;
    //     input[1] = amount;

    //     deduction[index] = input;

    //     $('input#deductionArray').val(deduction.join("*"));
    // });
});
