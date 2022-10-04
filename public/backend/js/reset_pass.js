$(document).on("submit", "#form-reset-password-user", function(e) {
    e.preventDefault();
    var html = '';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/dat-lai-mat-khau",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 202) {
                console.log(data.msg);
                $("#ip_new_pass").addClass("is-invalid");
                $("#ip_confirm_pass").addClass("is-invalid");
                $("#validationResetPassword").show();
                $.each(data.msg, function(index, value) {
                    html += "* " + value + "<br>";
                })
                $("#validationResetPassword").html(html);
            } else if (data.status == 200) {
                $("#ip_new_pass").removeClass("is-invalid");
                $("#ip_confirm_pass").removeClass("is-invalid");
                $("#ip_new_pass").addClass("is-valid");
                $("#ip_confirm_pass").addClass("is-valid");
                $("#valid_reset_pass").html(data.msg)
                setInterval(() => {
                    window.location.href = '/dang-nhap';
                }, 1300);
            }
        }
    })
})