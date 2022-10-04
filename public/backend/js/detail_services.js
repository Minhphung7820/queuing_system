function filterNumberOnDetailServices() {
    $(".input-keyup-search-numbers-in-detail-services").val("");
    var idSercurr = $("#idServiceCurrent").val();
    var statusNumbersD = $('input[name="status_number_detail_services"]:checked').val();
    var beginNumberInDetail = $("#begin-time-numbers-in-detail-services").val();
    var endNumberInDetail = $("#end-time-numbers-in-detail-services").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/filter-number-in-services",
        type: "post",
        data: {
            id: idSercurr,
            stt: statusNumbersD,
            begin: beginNumberInDetail,
            end: endNumberInDetail,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".row-pagination-numbers-service").remove();
                $("#result-number-in-detail-services").html(data.msg);
            }
        }
    })
}

function viewMoreNumberInDeatilService(el) {
    var idNumMax = $(el).data("id");
    var idSercurr_view_more = $("#idServiceCurrent").val();
    var statusNumbersD_view_more = $('input[name="status_number_detail_services"]:checked').val();
    var beginNumberInDetail_view_more = $("#begin-time-numbers-in-detail-services").val();
    var endNumberInDetail_view_more = $("#end-time-numbers-in-detail-services").val();
    $(el).prop("disabled", true);
    $(el).html("Đang tải...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/view-more-numbers-in-detail-service",
        type: "post",
        data: {
            idNumMax: idNumMax,
            id: idSercurr_view_more,
            stt: statusNumbersD_view_more,
            begin: beginNumberInDetail_view_more,
            end: endNumberInDetail_view_more,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-view-more-numbers-in-detail-services").remove();
                $("#result-number-in-detail-services").append(data.msg);
            }
        }
    })
}

function keyupSearchNumbersSerivces(el) {
    var keyS = $(el).val();

    $(".radio-status-numbers-services-detail").each(function(index, value) {
        if ($(value).val() == 4) {
            $(value).prop("checked", true);
        }
    })
    $(".result-select-8").html("Tất cả");
    var idCurr = $("#idServiceCurrent").val();
    var statusNumbersSearch = $('input[name="status_number_detail_services"]:checked').val();
    var beginNumberInDetailSearch = $("#begin-time-numbers-in-detail-services").val();
    var endNumberInDetailSearch = $("#end-time-numbers-in-detail-services").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/keyup-search-numbers-in-detail-services",
        type: "post",
        data: {
            id: idCurr,
            key: keyS,
            stt: statusNumbersSearch,
            begin: beginNumberInDetailSearch,
            end: endNumberInDetailSearch,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".row-pagination-numbers-service").remove();
                $("#result-number-in-detail-services").html(data.msg);
                $(".filter-time-begin-numbers-detail-services").val(data.limitD);
            }
        }
    })
}

function viewMoreResultsNumbersKeyupNumbers(el) {
    $(".btn-view-more-numbers-keyup-in-detail-services").prop("disabled", true);
    $(".btn-view-more-numbers-keyup-in-detail-services").html("Đang tải...");
    var idResultMax = $(el).data("id");
    var keyCurrent = $(".input-keyup-search-numbers-in-detail-services").val();
    var idSerCurr = $("#idServiceCurrent").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/view-more-keyup-result-numbers-in-detail-services",
        type: "post",
        data: {
            id: idSerCurr,
            key: keyCurrent,
            idMax: idResultMax,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-view-more-numbers-in-detail-services").remove();
                $("#result-number-in-detail-services").append(data.msg);
            }
        }
    })
}
$(document).on("click", ".option-status-detail-services", function(e) {
    e.preventDefault();
    filterNumberOnDetailServices();
})