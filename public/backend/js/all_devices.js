// $(document).ready(function() {
//     $(".content-services").each(function(index, value) {
//         if ($(value).text().length >= 20) {
//             var text = $(value).text();
//             $(value).text(text.charAt(20).concat("..."))
//         }
//     })
// })
$(document).on("click", ".btn-sidebar-create-devices", function(e) {
    e.preventDefault();
    window.location.href = '/admin/devices/create';
})

function filterDevices() {
    var valueActive = $('input[name="status_activity"]:checked').val();
    var valueConnect = $('input[name="connection"]:checked').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/devices/get-devices-by-status",
        type: "post",
        data: {
            valueActive: valueActive,
            valueConnect: valueConnect
        },
        success: function(data) {
            console.log(data.msg);
            if (data.status == 200) {
                $(".input-keyup-search-devices").val("");
                $("#result-devices").html(data.msg);
                $(".pagination-all-devices").html("");
            }
        }
    })
}
$(document).on("click", ".option-status-active-devices", function(e) {
    e.preventDefault();
    filterDevices();
})
$(document).on("click", ".option-status-connect-devices", function(e) {
    e.preventDefault();
    filterDevices();
})


$(document).on("click", ".btn-view-more-devices-filter", function(e) {
    e.preventDefault();
    $(this).prop("disabled", true);
    $(this).html("Đang tải...");
    var id = $(this).data('id');
    var active = $(this).data("active");
    var connect = $(this).data("connect");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/devices/load-view-more-devices-filter",
        type: "post",
        data: {
            id: id,
            active: active,
            connect: connect,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-view-more-devices-filter").remove();
                $("#result-devices").append(data.msg);

            }

        }
    })

})
$(document).on("keyup", ".input-keyup-search-devices", function(e) {
    e.preventDefault();
    var key = $(this).val();

    $('.radio-status-devices').each(function(index, value) {
        if ($(value).val() == 3) {
            $(value).prop("checked", true);
            $(".result-select").html("Tất cả")
        }
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/devices/keyup-search-devices",
        type: "post",
        data: {
            key: key
        },
        success: function(data) {
            if (data.status == 200) {
                $("#result-devices").html(data.msg);
                $(".pagination-all-devices").html("");
            }
        }
    })

})