$(document).on("submit", "#form-create-number", function(e) {
    e.preventDefault();
    if ($('input[name="name_select_services"]:checked').length == 0) {
        alert("Vui lòng chọn dịch vụ !");
        return false;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/number/create",
        type: "post",
        data: $(this).serialize(),
        success: function(data) {
            if (data.status == 200) {
                $(".container-wrap-success-give-numbers").fadeIn(500);
                $("#box-number-new-create").html(data.msg.number);
                $("#name-services-of-number").html(data.msg.name);
                $("#box-counter-services").html(data.msg.counter);
                $("#box-start-timeout-number").html(data.msg.started);
                $("#box-end-timeout-number").html(data.msg.end);
            } else if (data.status == 202) {
                console.log(data.msg);
            }
        }
    })
})
$(document).on("click", "#turn-off-success-give-number", function(e) {
    e.preventDefault();
    $(".container-wrap-success-give-numbers").fadeOut(500);
})