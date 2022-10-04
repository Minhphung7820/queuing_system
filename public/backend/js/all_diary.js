function filterTimeDiary() {
    var timeBegin = $("#date-time-begin-diary").val();
    var timeEnd = $("#date-time-end-diary").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/diary/filter",
        type: "post",
        data: {
            begin: timeBegin,
            end: timeEnd
        },
        success: function(data) {
            if (data.status == 200) {
                $("#result-diary").html(data.msg);
                $(".pagination-all-diary").remove();
            }
        }
    })
}

function viewMoreDiary(el) {
    var idMaxx = $(el).data("id");
    var timeBeginV = $("#date-time-begin-diary").val();
    var timeEndV = $("#date-time-end-diary").val();
    $(".btn-view-more-diary-filter").prop("disabled", true);
    $(".btn-view-more-diary-filter").html("Đang tải...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/diary/view-more-filter",
        type: "post",
        data: {
            id: idMaxx,
            begin: timeBeginV,
            end: timeEndV
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-view-more-diary").remove();
                $("#result-diary").append(data.msg);
            }
        }
    })
}

function keyupSearchDiary(el) {
    var keyCurrentDiary = $(el).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/diary/keyup",
        type: "post",
        data: {
            key: keyCurrentDiary,
        },
        success: function(data) {
            $("#result-diary").html(data.msg);
            $(".pagination-all-diary").remove();
        }
    })
}

function viewMoreKeyupDiary(el) {
    var idMaxxCurrent = $(el).data("id");
    var keyCurrentViewmore = $("#input-search-history").val();
    $(".btn-view-more-diary-keyup").prop("disabled", true);
    $(".btn-view-more-diary-keyup").html("Đang tải...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/diary/view-more-keyup",
        type: "post",
        data: {
            id: idMaxxCurrent,
            key: keyCurrentViewmore,
        },
        success: function(data) {
            $(".tr-view-more-diary").remove();
            $("#result-diary").append(data.msg);
        }
    })
}