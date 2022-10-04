$(document).on("submit", "#form-create-services", function(e) {
    e.preventDefault();
    $(".alert-success").fadeOut(500);
    $('input').removeClass('is-invalid');
    $('input[name="nameServices"]').removeClass("is-invalid");
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
        url: "/admin/services/create",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 202) {
                $.each(data.msg, function(index, value) {
                    $('input[name="' + index + '"]').addClass("is-invalid");
                    $('#' + index).html(value);
                })
            } else if (data.status == 200) {
                $(".alert-success").fadeIn(500);
                $(".alert-success").html(data.msg);
                $('input').val("");
                $('textarea').val("");
                $('input[name="rule[]"]').prop("checked", false);
            } else if (data.status == 204) {
                $('input[name="nameServices"]').addClass("is-invalid");
                $("#nameServices").html(data.msg);
            }
        }
    })
})
$(document).on("click", ".btn-update-services-from-detail", function(e) {
    e.preventDefault();
    var idPage = $(this).data("id");
    window.location.href = '/admin/services/edit/' + idPage;
})