    $(document).on("submit", "#form-update-role", function(e) {
            e.preventDefault();
            $('input').removeClass("is-invalid");
            if ($('input[name="function[]"]:checked').length == 0) {
                alert('Vui lòng chọn chức năng !');
                return false;
            } else {
                $(".alert-success").fadeOut(500);
                $(".btn-update-role").prop("disabled", true);
                $(".btn-update-role").html("Đang xử lý...");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/admin/system/role/update",
                    type: "post",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.status == 200) {
                            $(".btn-update-role").prop("disabled", false);
                            $(".btn-update-role").html("Cập nhật");
                            $(".alert-success").fadeIn(500);
                            $(".alert-success").html(data.msg);
                            setInterval(() => {
                                window.location.reload();
                            }, 1500);
                        } else if (data.status == 202) {
                            $(".btn-update-role").prop("disabled", false);
                            $(".btn-update-role").html("Cập nhật");
                            $.each(data.msg, function(index, value) {
                                $('input[name="' + index + '"]').addClass("is-invalid");
                                $("#" + index).html(value);
                            })
                        } else if (data.status == 204) {
                            $(".btn-update-role").prop("disabled", false);
                            $(".btn-update-role").html("Cập nhật");
                            $('input[name="' + data.field + '"]').addClass("is-invalid");
                            $("#" + data.field).html(data.msg);
                        }
                    }
                })
            }
        })
        // thiết bị
    $(document).on("change", ".input-update-check-all-func-devices", function(e) {
        e.preventDefault();
        $(".input-update-each-func-devices").prop("checked", $(this).prop("checked"));
    })
    $(document).on("change", ".input-update-each-func-devices", function(e) {
            e.preventDefault();
            if ($('input[class="custom-control-input input-update-each-func-devices"]:checked').length < 3) {
                $(".input-update-check-all-func-devices").prop("checked", false);
            }
        })
        // dịch vụ
    $(document).on("change", ".input-update-check-all-func-services", function(e) {
        e.preventDefault();
        $(".input-update-each-func-services").prop("checked", $(this).prop("checked"));
    })
    $(document).on("change", ".input-update-each-func-services", function(e) {
            e.preventDefault();
            if ($('input[class="custom-control-input input-update-each-func-services"]:checked').length < 3) {
                $(".input-update-check-all-func-services").prop("checked", false);
            }
        })
        // cấp số
    $(document).on("change", ".input-update-check-all-func-numbers", function(e) {
        e.preventDefault();
        $(".input-update-each-func-numbers").prop("checked", $(this).prop("checked"));
    })
    $(document).on("change", ".input-update-each-func-numbers", function(e) {
            e.preventDefault();
            if ($('input[class="custom-control-input input-update-each-func-numbers"]:checked').length < 3) {
                $(".input-update-check-all-func-numbers").prop("checked", false);
            }
        })
        // user

    $(document).on("change", ".input-update-check-all-func-users", function(e) {
        e.preventDefault();
        $(".input-update-each-func-users").prop("checked", $(this).prop("checked"));
    })
    $(document).on("change", ".input-update-each-func-users", function(e) {
            e.preventDefault();
            if ($('input[class="custom-control-input input-update-each-func-users"]:checked').length < 2) {
                $(".input-update-check-all-func-users").prop("checked", false);
            }
        })
        // vai trò
    $(document).on("change", ".input-update-check-all-func-role", function(e) {
        e.preventDefault();
        $(".input-update-each-func-role").prop("checked", $(this).prop("checked"));
    })
    $(document).on("change", ".input-update-each-func-role", function(e) {
        e.preventDefault();
        if ($('input[class="custom-control-input input-update-each-func-role"]:checked').length < 2) {
            $(".input-update-check-all-func-role").prop("checked", false);
        }
    })