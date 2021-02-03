$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    // $('div.flash').not('.alert-important').delay(3000).fadeOut(350);
    function clearForm(form) {

    }

    $('#staff_tbl').DataTable({
        "ordering": true,
        'lengthChange': false,
    });


    $('.sidebar-toggler').click(function (e) {
        e.preventDefault();

        $('.sidebar-main').toggleClass('toggle');
    });

    $('.btnDeleteUser').click(function (e) {
        e.preventDefault();
        var id = $(this).data('form_id');
        Swal.fire({
            icon: 'warning',
            text: 'Do you want to delete this?',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#e3342f',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(id).submit();
            }
        });
    });
    $('.btnDeletePerm').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var id = $(this).data('user');
        Swal.fire({
            icon: 'warning',
            text: 'Do you want to delete this user? This action is irreversible',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#e3342f',
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "post",
                    url: "/user-management/permanent",
                    data: {
                        id: id

                    },

                    success: function (response) {
                        var resp = JSON.parse(response);
                        if (resp.status == "success") {
                            toastr.success("User permanently deleted!");
                            window.setTimeout(function () { location.reload() }, 1000);
                        } else {
                            toastr.error("We ran into an error handling you request! Kindly Try again later!");
                        }
                    }
                });
            }
        });
    });

    $('#tbl_payroll').DataTable({
        "ordering": true,
        'lengthChange': false,
        'paging': true,
    });
    $('.dedall').DataTable({
        "ordering": true,
        'lengthChange': false,
        'paging': true,
    });
    $('#payroll_processed').DataTable({
        "ordering": true,
        'lengthChange': false,
        'paging': true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });

    $('#btnProcessPayroll').click(function (e) {
        e.preventDefault();
        var records = $(this).data('records');

        if (records != 0) {

            Swal.fire({
                icon: 'warning',
                text: 'This action will delete all previously processed records from this month! Proceed?',
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                confirmButtonColor: '#4BB543',
                // showConfirmButton: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    processPayroll();
                }
            });
        } else {
            processPayroll();
        }


    });

    function processPayroll() {
        $('div.processing').removeClass('show');
        $.ajax({
            type: "post",
            url: "/payroll/process",
            data: {
                process: 1,
            },

            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.status == "success") {
                    window.setTimeout(function () {
                        $('div.processing').removeClass('show');
                        Swal.fire({
                            icon: 'success',
                            text: 'Payroll Processed successfully!',
                            showCancelButton: false,
                            // showConfirmButton: false,
                        }).then((result) => {
                            window.setTimeout(function () { location.href = "/payroll/show"; }, 1000);
                        });
                    }, 1200);
                } else {
                    window.setTimeout(function () {
                        $('div.processing').removeClass('show');
                        Swal.fire({
                            icon: 'error',
                            text: 'Payroll Processing failed! Check data and try again!',
                            showCancelButton: false,

                        });
                    }, 1200);
                }
            }
        });
    }

    $('.btnDepartDel').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var id = $(this).data('form_id');
        Swal.fire({
            icon: 'warning',
            text: 'Are you sure you want to delete the selected item? This action is irreversible',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#e3342f',
        }).then((result) => {
            if (result.isConfirmed) {

                $('#' + id).submit();
            }
        });
    });

    $('a.target-link').on('click', function (e) {
        e.preventDefault();

        var targetDiv = $(this).data('target');
        // alert(targetDiv);
        $('.business_settings .panel').removeClass('active');
        $('.target-link').removeClass('active');
        $(this).addClass('active');
        $(targetDiv).addClass('active').fadeIn();
    });

});


