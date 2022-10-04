var $modal = $('#box_crop_image_avatar');
var image = document.getElementById('image_avatar');
var cropper;
$("body").on("change", "#myFile", function(e) {
    var files = e.target.files;
    var done = function(url) {
        image.src = url;
        $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});
$modal.on('shown.bs.modal', function() {
    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: '.preview'
    });
}).on('hidden.bs.modal', function() {
    cropper.destroy();
    cropper = null;
});
$("#crop").click(function() {
    canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            $("#box-all-form-change-avt").show();
            var base64data = reader.result;
            $("#myFile_hidden").val(base64data);
            $modal.modal('hide');
            $("#box-icon-change-avatar>label").hide();
        }
    });
})

$(document).on("click", ".btn-change-avatar", function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/change-avt",
        type: "post",
        data: {
            base: $("#myFile_hidden").val(),
        },
        success: function(data) {
            if (data.status == 200) {
                swal({
                    title: "Đã thay đổi!",
                    text: "Ảnh đại diện đã được cập nhật!",
                    icon: "success",
                    button: false,
                });
                setInterval(() => {
                    window.location.reload();
                }, 1500);
            }
        }
    })
})
$(document).on("change", "#myFile", function(e) {
    e.preventDefault();
    if ($(this).val() != "") {
        $(".btn-refresh-change-avt").show();
    } else {
        $(".btn-refresh-change-avt").hide();
    }
})
$(document).ready(function() {
    $("#box-icon-change-avatar>label").show();
})