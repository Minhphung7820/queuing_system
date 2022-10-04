$(document).on("submit", "#form-update-services", function(e) {
    e.preventDefault();
    $('.btn-update-service').prop("disabled", true);
    $('input[name="nameServices"]').removeClass("is-invalid");
    $(".alert-success").fadeOut(500);
    $('input').removeClass('is-invalid');
    if ($('input[name="rule[]"]:checked').length == 0) {
        alert("Vui lòng chọn quy tắc cấp số !");
        return false;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/update",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 202) {
                $('.btn-update-service').prop("disabled", false);
                $.each(data.msg, function(index, value) {
                    $('input[name="' + index + '"]').addClass("is-invalid");
                    $('#' + index).html(value);
                })
            } else if (data.status == 200) {
                $('.btn-update-service').prop("disabled", false);
                $(".alert-success").fadeIn(500);
                $(".alert-success").html(data.msg);
                setInterval(() => {
                    window.location.reload();
                }, 1500);
            } else if (data.status == 208) {
                $('input[name="nameServices"]').addClass("is-invalid");
                $("#nameServices").html(data.msg);
            }
        }
    })
})