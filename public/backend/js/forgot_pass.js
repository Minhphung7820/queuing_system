$(document).on("submit", "#form_forgot_password_user", function(e) {
    e.preventDefault();
    $(".btn-continute-verifi").prop("disabled", true);
    $(".btn-continute-verifi").html("Vui lòng chờ...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/quen-mat-khau",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 200) {
                $(".btn-continute-verifi").prop("disabled", true);
                $(".btn-continute-verifi").html("Chờ xác thực");
                $(".btn-continute-verifi").addClass("btn-success");
                $("#ip_email_verifi").removeClass("is-invalid");
                $("#ip_email_verifi").addClass("is-valid");
            } else if (data.status == 202) {
                $(".btn-continute-verifi").prop("disabled", false);
                $(".btn-continute-verifi").html("Tiếp tục");
                $("#ip_email_verifi").addClass("is-invalid");
            }
        }
    })
})