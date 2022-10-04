function fiterServices() {
    var begin = $("#date-time-begin").val();
    var end = $("#date-time-end").val();
    var stt_current = $('input[type="radio"][name="status_activity_services"]:checked').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/get-services-by-date",
        type: "post",
        data: {
            begin: begin,
            end: end,
            stt: stt_current,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".pagination-all-services").html("");
                $("#result-services").html(data.msg);
                // console.log(data.msg);
            }
        }
    })
}


$(document).on("change", ".choose-fiter-date-serivces", function(e) {
    e.preventDefault();
    fiterServices();
})


$(document).on("click", ".option-status-services", function(e) {
    e.preventDefault();
    fiterServices();
})
$(document).on("click", ".btn-view-more-services-filter", function(e) {
    e.preventDefault();
    $(this).prop("disabled", true);
    $(this).html("Đang tải...");
    var begin_v = $("#date-time-begin").val();
    var end_v = $("#date-time-end").val();
    var stt_current_v = $('input[type="radio"][name="status_activity_services"]:checked').val();
    var id = $(this).data("id");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/view-more-services",
        type: "post",
        data: {
            begin: begin_v,
            end: end_v,
            stt: stt_current_v,
            id: id
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-view-more-services").remove();
                $("#result-services").append(data.msg);
            }
        }
    })

})

function keyupSer(el) {
    var vl = $(el).val();
    var begin_s = $("#date-time-begin").val();
    var end_s = $("#date-time-end").val();
    var stt_current_s = $('input[type="radio"][name="status_activity_services"]:checked').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/keyup-search-services",
        type: "post",
        data: {
            key: vl,
            stt: stt_current_s,
            begin: begin_s,
            end: end_s,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".pagination-all-services").html("");
                $("#result-services").html(data.msg);
            }
        }
    })
}

function viewMoreKeyup(el) {
    var id_vm = $(el).data("id");
    var begin_Vs = $("#date-time-begin").val();
    var end_Vs = $("#date-time-end").val();
    var stt_current_Vs = $('input[type="radio"][name="status_activity_services"]:checked').val();
    var key_current = $(".input-keyup-search-services").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/view-more-keyup-services",
        type: "post",
        data: {
            id: id_vm,
            begin: begin_Vs,
            end: end_Vs,
            stt: stt_current_Vs,
            key: key_current,
        },
        success: function(data) {
            $(".tr-view-more-services").remove();
            $("#result-services").append(data.msg);
        }
    })
}
$(document).on("click", ".btn-sidebar-create-services", function(e) {
    e.preventDefault();
    window.location.href = '/admin/services/create';
})