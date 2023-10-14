// View Register
function chooseImage(input) {
    var img_path = $(input)[0].value;
    var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();

    if (input.files && input.files[0] && (extension == 'gif' || extension == 'png' || extension == 'jpeg' || extension == 'jpg')) {
        $('#error-avatar').text('');

        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img-holder')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#img-holder').attr('src', $('#img-holder').hasClass('admin') ? 'images/user/no_avatar_admin.png' : 'images/user/no_avatar.png');
        $('#error-avatar').text('Ảnh không hợp lệ. Chỉ chấp nhận ảnh jpeg, jpg, png và gif.');
    }
}

$(function () {
    $('#avatar').on('change', function () {
        chooseImage(this);
    });

    $('#register-form').submit(function () {
        $("#register-btn").text('Đợi một lát...');
    });
});
// --------------------------------------

// View Admin Layout
function dislayTooltip() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

$(function () {
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass('open');
        return false;
    });

    var current_url = window.location.href.split('#')[0].split('?')[0];

    var nav_link = $('#sidebar').find('a').filter(function () {
        return this.href == current_url;
    }).addClass('active')

    if (nav_link.parent('.dropdown-menu').length) {
        $('#title-section').removeClass('d-none').text(nav_link.text());
        nav_link = nav_link.parent('.dropdown-menu').siblings('.dropdown-toggle').addClass('active');
        new bootstrap.Dropdown(nav_link).show();
    }

    $('#title-content').text(nav_link.text());

    dislayTooltip();
});
// -----------------------------

