$(document).ready(function() {
    $(".btn-export-report-to-excel").click(function() {
        var workbook = XLSX.utils.book_new();

        //var worksheet_data  =  [['hello','world']];
        //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);

        var worksheet_data = document.querySelector("#table-all-report > tbody");
        var worksheet = XLSX.utils.table_to_sheet(worksheet_data);

        workbook.SheetNames.push("Test");
        workbook.Sheets["Test"] = worksheet;

        exportExcelFile(workbook);


    });
})

function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "Bao_cao.xlsx");
}


function ChangeInputDateReport() {
    var beginTime = $('input[id="date-time-begin-report"]').val();
    var endTime = $('input[id="date-time-end-report"]').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/report/filter",
        type: "post",
        data: {
            begin: beginTime,
            end: endTime,
        },
        success: function(data) {
            if (data.status == 200) {
                $("#result-report").html(data.msg);
                $(".pagination-all-report").remove();
            }
        }
    })
}

function viewMoreFilterReport(el) {

    var idMax = $(el).data("id");
    var beginTimeV = $('input[id="date-time-begin-report"]').val();
    var endTimeV = $('input[id="date-time-end-report"]').val();
    $(".btn-view-more-report-filter").prop("disabled", true);
    $(".btn-view-more-report-filter").html("Đang tải...");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/report/view-more",
        type: "post",
        data: {
            id: idMax,
            begin: beginTimeV,
            end: endTimeV,
        },
        success: function(data) {
            if (data.status == 200) {
                $(".tr-btn-view-more-report").remove();
                $("#result-report").append(data.msg);
            }
        }
    })
}


$(document).on("click", ".btn-filter-report", function(e) {
        e.preventDefault();
        $(this).next().toggle()
    })
    // Filter 1
const optionSttFilterReport = document.querySelectorAll(".option_filter_report_stt")
optionSttFilterReport.forEach(o => {
    o.addEventListener("click", () => {
        o.querySelector('input').checked = true;
        document.querySelector(".box-input-filter-report-1").style.display = 'none';
        filterReportDetail();
    });
});
// $(document).on("click", ".option_filter_report_stt", function(e) {
//     e.preventDefault();
//     $(this).children('input[type="radio"]').prop("checked", true);
//     $(".box-input-filter-report-1").hide();

// })
// $(document).on("click", ".option_filter_report_stt", function(e) {
//         e.preventDefault();
//         filterReportDetail()

//     })
// filter 2
$(document).on("click", ".option-filter-report-by-time-give-number", function(e) {
        e.preventDefault();
        $(this).children('input').prop("checked", true);
        $(".box-input-filter-report-3").hide();
        filterReportDetail()
    })
    // $(document).on("click", ".option-filter-report-by-time-give-number", function(e) {
    //         e.preventDefault();
    //         filterReportDetail()
    //     })
    // filter 3

$(document).on("change", "#input-check-array-services-filter-report-all", function(e) {
    e.preventDefault();
    $(".input_checked_name_services_filter_report").prop("checked", $(this).prop("checked"));
    filterReportDetail()
})
$(document).on("change", ".input_checked_name_services_filter_report", function(e) {
        e.preventDefault();
        if ($('input[class="input_checked_name_services_filter_report"]:checked').length < $('input[class="input_checked_name_services_filter_report"]').length) {
            $("#input-check-array-services-filter-report-all").prop("checked", false);
        }
        filterReportDetail()
    })
    // filter 4
$(document).on("click", ".option-filter-report-by-status-give-number", function(e) {
        e.preventDefault();
        $(this).children('input').prop("checked", true);
        $(".box-input-filter-report-4").hide();
        filterReportDetail()
    })
    // $(document).on("click", ".option-filter-report-by-status-give-number", function(e) {
    //         e.preventDefault();
    //         filterReportDetail()
    //     })
    // filter 5

$(document).on("click", ".option-filter-report-by-namedevices", function(e) {
    e.preventDefault();
    $(this).children('input').prop("checked", true);
    $(".box-input-filter-report-5").hide();
    filterReportDetail()
})

// $(document).on("click", ".option-filter-report-by-namedevices", function(e) {
//     e.preventDefault();
//     filterReportDetail()
// })
function filterReportDetail() {
    var arrServices = [];
    var eleSers = $('input[class="input_checked_name_services_filter_report"]:checked');
    var valueStt = $('input[class="radio_filter_report_stt"]:checked').val();
    var valueTime = $('input[class="radio_filter_report_time"]:checked').val();
    var valueStatus = $('input[class="radio_filter_report_status"]:checked').val();
    var valuedevices = $('input[class="radio_filter_report_by_devices"]:checked').val();

    for (let index = 0; index < eleSers.length; index++) {
        arrServices.push(eleSers[index].value);
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/report/filter-input",
        type: "post",
        data: {
            arrS: arrServices,
            number: valueStt,
            time: valueTime,
            stt: valueStatus,
            dev: valuedevices,
        },
        success: function(data) {
            if (data.status == 200) {
                $("#date-time-begin-report").val(data.dataLimit);
                $(".pagination-all-report").remove();
                $("#result-report").html(data.msg);
            }
        }
    })


}