$(document).on("submit", "#form-logout", function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
            title: "Bạn chắc chắn muốn đăng xuất?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/dang-xuat",
                    type: "post",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.status == 200) {
                            window.location.reload();
                        }
                    }
                });
            }
        });
})
$(document).on("mousemove", ".list-menu-setting-account", function(e) {
    e.preventDefault()
    $(".menu-setting-account").addClass("menu-hover");
})
$(document).on("mouseleave", ".list-menu-setting-account", function(e) {
    e.preventDefault()
    $(".menu-setting-account").removeClass("menu-hover");
})
$(document).on("click", ".menu-setting-account", function(e) {
    e.preventDefault();
})
$(document).on("click", ".calendar .calendar-prev a", function(e) {
    e.preventDefault();
})
$(document).on("click", ".calendar .calendar-next a", function(e) {
    e.preventDefault();
})
$(document).on("click", ".dateNumber", function(e) {
    e.preventDefault();
})

function loadNotification() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/admin/load-notification",
        type: "post",
        success: function(data) {
            $(".box-all-notifi").html(data.msg);
        }
    })
}
setInterval(() => {
    loadNotification();
}, 1000);