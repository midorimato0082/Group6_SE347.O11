// View Register
function chooseImage(input) {
    var img_path = $(input)[0].value;
    var extension = img_path
        .substring(img_path.lastIndexOf(".") + 1)
        .toLowerCase();

    if (
        input.files &&
        input.files[0] &&
        (extension == "gif" ||
            extension == "png" ||
            extension == "jpeg" ||
            extension == "jpg")
    ) {
        $("#error-avatar").text("");

        var reader = new FileReader();

        reader.onload = function (e) {
            $("#img-holder").attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $("#img-holder").attr(
            "src",
            $("#img-holder").hasClass("admin")
                ? "images/user/no_avatar_admin.png"
                : "images/user/no_avatar.png"
        );
        $("#error-avatar").text(
            "Ảnh không hợp lệ. Chỉ chấp nhận ảnh jpeg, jpg, png và gif."
        );
    }
}

$(function () {
    $("#avatar").on("change", function () {
        chooseImage(this);
    });

    $("#register-form").submit(function () {
        $("#register-btn").text("Đợi một lát...");
    });
});
// --------------------------------------

// View Admin Layout
$(function () {
    $(".sidebar-toggler").click(function () {
        $(".sidebar, .content").toggleClass("open");
        return false;
    });

    $(".nav-item").on("hide.bs.dropdown", function (e) {
        if (e.clickEvent) {
            e.preventDefault();
        }
    });

    var current_url = window.location.href.split("#")[0].split("?")[0];
    var value_editing = "";

    var nav_link = $("#sidebar")
        .find("a")
        .filter(function () {
            if (current_url.includes("edit")) {
                value_editing = current_url.split("edit-")[1].split("/")[0];
                return $(this).hasClass(value_editing);
            }

            return this.href == current_url;
        })
        .addClass("active");

    if (nav_link.parent(".dropdown-menu").length) {
        $("#title-section").removeClass("d-none").text(nav_link.text());
        nav_link = nav_link
            .parent(".dropdown-menu")
            .siblings(".dropdown-toggle")
            .addClass("active");
        new bootstrap.Dropdown(nav_link).show();
    }

    $("#title-content").text(nav_link.text());

    if (current_url.includes("edit"))
        $("a." + value_editing).removeClass("d-none");
});
// -----------------------------

// View All
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $(".page-item").on("click", function () {
        Livewire.dispatch("resetChecked");
    });
});

// -----------------------------

// View Dashboard

// -----------------------------

// View Category

function ChangeToSlug() {
    var title, slug;

    //Lấy text từ thẻ input title
    title = document.getElementById("name").value;

    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();

    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
    slug = slug.replace(/đ/gi, "d");
    //Xóa các ký tự đặt biệt
    slug = slug.replace(
        /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
        ""
    );
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-/gi, "-");
    slug = slug.replace(/\-\-/gi, "-");
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = "@" + slug + "@";
    slug = slug.replace(/\@\-|\-\@|\@/gi, "");
    //In slug ra textbox có id “slug”
    document.getElementById("slug").value = slug;
}

// -----------------------------
