$(document).on("submit", "#form-add-user", function(e) {
    e.preventDefault();
    var html = '';
    $('input').removeClass("is-invalid");
    $(".select-box-10").removeClass("select-invalid")
    $(".select-box-11").removeClass("select-invalid")
    $(".alert-success").fadeOut(500);
    $(".alert-danger").fadeOut(500);
    $(".btn-add-user").prop("disabled", true);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/users/create",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 200) {
                $(".alert-success").fadeIn(500);
                $(".alert-success").html(data.msg);
                $(".btn-add-user").prop("disabled", false);
                setInterval(() => {
                    window.location.reload();
                }, 1500);
            } else if (data.status == 202) {
                // $(".alert-danger").fadeIn(500);
                $(".btn-add-user").prop("disabled", false);
                $.each(data.msg, function(index, value) {
                    if (index == 'role') {
                        $(".select-box-10").addClass("select-invalid")
                    } else if (index == 'status') {
                        $(".select-box-11").addClass("select-invalid")
                    }
                    $('input[name="' + index + '"]').addClass("is-invalid");
                    $("#" + index).html(value);
                })
            } else if (data.status == 204) {
                $(".btn-add-user").prop("disabled", false);
                $('input[name="email"]').addClass("is-invalid");
                $('#email').html(data.msg);
            } else if (data.status == 206) {
                $(".btn-add-user").prop("disabled", false);
                $('input[name="name"]').addClass("is-invalid");
                $('#name').html(data.msg);
            }
        }
    })
})