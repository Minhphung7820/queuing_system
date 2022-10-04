$(document).on("click", ".option-status-users", function(e) {
    e.preventDefault();
    var status_acc = $('input[class="radio radio-filter-status-users"]:checked').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/users/filter",
        type: "post",
        data: {
            stt: status_acc
        },
        success: function(data) {
            if (data.status == 200) {
                $("#result-users").html(data.msg);
                $(".pagination-all-users").remove();
            }
        }
    })
})

function viewMoreUsersFilter(el) {
    var idM = $(el).data("id");
    var statusCurrent = $('input[class="radio radio-filter-status-users"]:checked').val();
    $(".btn-view-more-account-filter").prop("disabled", true);
    $(".btn-view-more-account-filter").html("Đang tải...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/users/view-more",
        type: "post",
        data: {
            id: idM,
            stt: statusCurrent
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-box-btn-view-more-account").remove();
                $("#result-users").append(data.msg);
            }
        }
    })
}

function keyupUsers(el) {
    var keySearch = $(el).val();
    $(".radio-filter-status-users").each(function(index, value) {
        if ($(value).val() == 3) {
            $(value).prop("checked", true);
        }
    })
    $(".result-select").html("Tất cả");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/users/keyup",
        type: "post",
        data: {
            key: keySearch
        },
        success: function(data) {
            if (data.status == 200) {
                $(".pagination-all-users").remove();
                $("#result-users").html(data.msg);
            }
        }
    })
}

function viewMoreKeyupUsers(el) {
    var keyCurrent = $(".input-search-users").val();
    var idMaxS = $(el).data("id");
    $(".btn-view-more-keyup-users-filter").prop("disabled", true);
    $(".btn-view-more-keyup-users-filter").html("Đang tải...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/users/view-more-keyup",
        type: "post",
        data: {
            id: idMaxS,
            key: keyCurrent
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-view-more-users").remove();
                $("#result-users").append(data.msg);
            }
        }
    })
}