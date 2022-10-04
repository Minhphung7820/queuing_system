$(document).on("click", ".btn-sidebar-create-new-number", function(e) {
    e.preventDefault();
    window.location.href = '/admin/number/create';
})

function keyupNumbers(el) {
    var keyNum = $(el).val();
    $('.radio-filter-by-numerical').each(function(index, value) {
        if ($(value).val() == 4) {
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
        url: "/admin/number/keyup",
        type: "post",
        data: {
            key: keyNum,
        },
        success: function(data) {
            if (data.status == 200) {
                $("#date-time-begin-give-number").val(data.limitD);
                $("#result-numbers").html(data.msg);
                $(".pagination-all-numbers").html("");
            }
        }
    })

}

function viewMoreKeyupNumbers(el) {
    var idView = $(el).data("id");
    var textInput = $(".input-keyup-search-numerical").val();
    $(".btn-view-more-keyup-numbers-filter").prop("disabled", true);
    $(".btn-view-more-keyup-numbers-filter").html("Đang tải...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/number/view-more-keyup",
        type: "post",
        data: {
            id: idView,
            text: textInput
        },
        success: function(data) {
            $(".tr-view-more-numbers").remove();
            $("#result-numbers").append(data.msg);
        }
    })
}

function filterNumber() {
    $(".input-keyup-search-numerical").val("");
    var nameServices = $('input[name="name_services"]:checked').val();
    var statusNumerical = $('input[name="status-give-number"]:checked').val();
    var nameDevices = $('input[name="name_devices_in_give_number"]:checked').val();
    var dateStarted = $('input[id="date-time-begin-give-number"]').val();
    var dateEnd = $('input[id="date-time-end-give-number"]').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/number/filter",
        type: "post",
        data: {
            services: nameServices,
            devices: nameDevices,
            status: statusNumerical,
            begin: dateStarted,
            end: dateEnd,
        },
        success: function(data) {
            if (data.status == 200) {
                $("#result-numbers").html(data.msg);
                $(".pagination-all-numbers").html("");
            } else if (data.status == 500) {
                swal({
                    title: "Can not do it !",
                    text: data.msg,
                    icon: "warning",
                    button: "OK",
                });
                return false;
            }
        }
    })
}

function viewMoreNumbers(el) {
    $(".btn-view-more-numbers-filter").prop("disabled", true);
    $(".btn-view-more-numbers-filter").html("Đang tải...");
    var idNumbers = $(el).data("id");
    var nameServicesV = $('input[name="name_services"]:checked').val();
    var statusNumericalV = $('input[name="status-give-number"]:checked').val();
    var nameDevicesV = $('input[name="name_devices_in_give_number"]:checked').val();
    var dateStartedV = $('input[id="date-time-begin-give-number"]').val();
    var dateEndV = $('input[id="date-time-end-give-number"]').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/number/view-more",
        type: "post",
        data: {
            id: idNumbers,
            services: nameServicesV,
            devices: nameDevicesV,
            status: statusNumericalV,
            begin: dateStartedV,
            end: dateEndV,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-view-more-numbers").remove();
                $("#result-numbers").append(data.msg);
            }
        }
    })
}
$(document).on("click", ".option-name-services", function(e) {
    e.preventDefault();
    filterNumber();
})
$(document).on("click", ".option-status-give-number", function(e) {
    e.preventDefault();
    filterNumber();
})
$(document).on("click", ".option-name-devices-give-number", function(e) {
    e.preventDefault();
    filterNumber();
})
$(document).on("change", "#date-time-begin-give-number", function(e) {
    e.preventDefault();
    filterNumber();
})
$(document).on("change", "#date-time-end-give-number", function(e) {
    e.preventDefault();
    filterNumber();
})