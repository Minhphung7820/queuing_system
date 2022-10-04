$(document).on("click", ".btn-sidebar-create-role", function(e) {
    e.preventDefault();
    window.location.href = "/admin/system/role/create";
})

function keyupRole(el) {
    var keyUp = $(el).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/system/role/keyup",
        type: "post",
        data: {
            key: keyUp,
        },
        success: function(data) {
            if (data.status == 200) {
                $("#result-roles").html(data.msg);
            }
        }
    })
}