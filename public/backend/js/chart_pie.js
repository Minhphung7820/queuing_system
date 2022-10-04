$(document).ready(function() {
    ChartPieDevices();
    ChartPieServices();
    ChartPieNumbers();
})

function ChartPieDevices() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/devices/load-ratio",
        type: "post",
        success: function(data) {
            $("#ratio-active-devices-dashboard").html(data.ratio + "%");
            var canvas_chart_devices = $("#chart-pie-devices");
            var myPieChart = new Chart(canvas_chart_devices, {
                type: 'doughnut',
                data: {
                    labels: ["Active", "In-Active"],
                    datasets: [{
                        data: data.msg,
                        backgroundColor: ['#FF7506', '#7E7D88'],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });
        }
    })
}

function ChartPieServices() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/services/load-ratio",
        type: "post",
        success: function(data) {
            $("#ratio-active-services-dashboard").html(data.ratio + "%");
            var canvas_chart_services = $("#chart-pie-services");
            var myPieChart = new Chart(canvas_chart_services, {
                type: 'doughnut',
                data: {
                    labels: ["Active", "In-Active"],
                    datasets: [{
                        data: data.msg,
                        backgroundColor: ['#4277FF', '#7E7D88'],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });
        }
    })
}

function ChartPieNumbers() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/number/load-ratio",
        type: "post",
        success: function(data) {
            $("#ratio-active-numbers-dashboard").html(data.ratio + "%");
            var canvas_chart_numbers = $("#chart-pie-numbers");
            var myPieChart = new Chart(canvas_chart_numbers, {
                type: 'doughnut',
                data: {
                    labels: ["Used", "Waiting", "Missed"],
                    datasets: [{
                        data: data.msg,
                        backgroundColor: ['#35C75A', '#7E7D88', '#F178B6'],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });
        }
    })
}