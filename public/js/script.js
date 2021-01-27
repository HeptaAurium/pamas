$(document).ready(function () {
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
            text: 'Do you want to delete this? This action is irreversible',
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
});
