$(document).on("submit", "#form-create-devices", function(e) {
    e.preventDefault();
    var html = '';
    $(".alert-success").fadeOut(500);
    $(".alert-danger").fadeOut(500);
    $("input").removeClass("is-invalid");
    $(".select-box-2").removeClass("select-invalid");
    $(".btn-add-device").prop("disabled", true);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/devices/create",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 202) {
                $(".alert-success").fadeOut(500);
                $(".btn-add-device").prop("disabled", false);
                $.each(data.msg, function(index, value) {
                    $('input[name=' + index + ']').addClass("is-invalid");
                    $("#" + index).html(value)
                    if (index == 'type') {
                        $(".select-box-2").addClass("select-invalid");
                    }

                })
            } else if (data.status == 200) {

                $(".alert-danger").fadeOut(500);
                $(".btn-add-device").prop("disabled", false);
                $(".alert-success").fadeIn(500);
                $(".alert-success").html(data.msg);
                $("input").removeClass("is-invalid");
                $(".select-box-2").removeClass("select-invalid");
                $("input").val("");
                setInterval(() => {
                    window.location.reload();
                }, 1500);
            } else if (data.status == 204) {
                $(".alert-success").fadeOut(500);
                $(".alert-danger").fadeIn(500);
                html += ' <ul>';
                $.each(data.msg, function(index, value) {
                    html += `<li>Dịch vụ <strong>${value}</strong> không tồn tại ! </li>`;
                })
                html += ' </ul>';
                $(".alert-danger").html(html);
                $(".btn-add-device").prop("disabled", false);
            } else if (data.status == 206) {
                $(".alert-success").fadeOut(500);
                $(".btn-add-device").prop("disabled", false);
                $(".alert-danger").fadeIn(500);
                $(".alert-danger").html(data.msg);
            }
        }
    });
})