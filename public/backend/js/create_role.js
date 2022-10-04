$(document).on("submit", "#form-create-role", function(e) {
        e.preventDefault();
        $('input').removeClass("is-invalid");
        if ($('input[name="function[]"]:checked').length == 0) {
            alert('Vui lòng chọn chức năng !');
            return false;
        } else {
            $(".alert-success").fadeOut(500);
            $(".btn-add-role").prop("disabled", true);
            $(".btn-add-role").html("Đang xử lý...");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/admin/system/role/create",
                type: "post",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status == 200) {
                        $('input').val("");
                        $('textarea').val("");
                        $('input[type="checkbox"]').prop("checked", false);
                        $(".btn-add-role").prop("disabled", false);
                        $(".btn-add-role").html("Thêm");
                        $(".alert-success").fadeIn(500);
                        $(".alert-success").html(data.msg);
                    } else if (data.status == 202) {
                        $(".btn-add-role").prop("disabled", false);
                        $(".btn-add-role").html("Thêm");
                        $.each(data.msg, function(index, value) {
                            $('input[name="' + index + '"]').addClass("is-invalid");
                            $("#" + index).html(value);
                        })
                    } else if (data.status == 204) {
                        $(".btn-add-role").prop("disabled", false);
                        $(".btn-add-role").html("Thêm");
                        $('input[name="' + data.field + '"]').addClass("is-invalid");
                        $("#" + data.field).html(data.msg);
                    }
                }
            })
        }

    })
    // thiết bị
$(document).on("change", ".input-check-all-func-devices", function(e) {
    e.preventDefault();
    $(".input-each-func-devices").prop("checked", $(this).prop("checked"));
})
$(document).on("change", ".input-each-func-devices", function(e) {
        e.preventDefault();
        if ($('input[class="custom-control-input input-each-func-devices"]:checked').length < 3) {
            $(".input-check-all-func-devices").prop("checked", false);
        }
    })
    // dịch vụ
$(document).on("change", ".input-check-all-func-services", function(e) {
    e.preventDefault();
    $(".input-each-func-services").prop("checked", $(this).prop("checked"));
})
$(document).on("change", ".input-each-func-services", function(e) {
        e.preventDefault();
        if ($('input[class="custom-control-input input-each-func-services"]:checked').length < 3) {
            $(".input-check-all-func-services").prop("checked", false);
        }
    })
    // cấp số
$(document).on("change", ".input-check-all-func-numbers", function(e) {
    e.preventDefault();
    $(".input-each-func-numbers").prop("checked", $(this).prop("checked"));
})
$(document).on("change", ".input-each-func-numbers", function(e) {
        e.preventDefault();
        if ($('input[class="custom-control-input input-each-func-numbers"]:checked').length < 3) {
            $(".input-check-all-func-numbers").prop("checked", false);
        }
    })
    // user

$(document).on("change", ".input-check-all-func-users", function(e) {
    e.preventDefault();
    $(".input-each-func-users").prop("checked", $(this).prop("checked"));
})
$(document).on("change", ".input-each-func-users", function(e) {
        e.preventDefault();
        if ($('input[class="custom-control-input input-each-func-users"]:checked').length < 2) {
            $(".input-check-all-func-users").prop("checked", false);
        }
    })
    // vai trò
$(document).on("change", ".input-check-all-func-role", function(e) {
    e.preventDefault();
    $(".input-each-func-role").prop("checked", $(this).prop("checked"));
})
$(document).on("change", ".input-each-func-role", function(e) {
    e.preventDefault();
    if ($('input[class="custom-control-input input-each-func-role"]:checked').length < 2) {
        $(".input-check-all-func-role").prop("checked", false);
    }
})