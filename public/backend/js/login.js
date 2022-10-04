$(document).on("submit", "#form-login-user", function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/dang-nhap",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 200) {
                $("#name_login").removeClass("is-invalid");
                $("#password_login").removeClass("is-invalid");
                window.location.href = '/admin/';
            } else if (data.status == 202) {
                $("#name_login").addClass("is-invalid");
                $("#password_login").addClass("is-invalid");
            }
        }
    })
})
$(document).on("click", ".btn-cancel-forgot", function(e) {
    e.preventDefault();
    window.location.href = '/dang-nhap';
})