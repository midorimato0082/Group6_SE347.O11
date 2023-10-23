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
$(function () {
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass('open');
        return false;
    });

    $('.nav-item').on('hide.bs.dropdown', function (e) {
        if (e.clickEvent) {
            e.preventDefault();
        }
    })

    var current_url = window.location.href.split('#')[0].split('?')[0];
    var value_editing = '';

    var nav_link = $('#sidebar').find('a').filter(function () {
        if (current_url.includes('edit')) {
            value_editing = current_url.split('edit-')[1].split('/')[0];
            return $(this).hasClass(value_editing);
        }

        return this.href == current_url;
    }).addClass('active');


    if (nav_link.parent('.dropdown-menu').length) {
        $('#title-section').removeClass('d-none').text(nav_link.text());
        nav_link = nav_link.parent('.dropdown-menu').siblings('.dropdown-toggle').addClass('active');
        new bootstrap.Dropdown(nav_link).show();
    }

    $('#title-content').text(nav_link.text());

    if (current_url.includes('edit'))
        $('a.' + value_editing).removeClass('d-none');

});
// -----------------------------

// View All
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('.page-item').on('click', function () {
        Livewire.dispatch('resetChecked');
    });

});

tinymce.init({
    selector: 'textarea#default-editor',
    plugins: 'tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    // ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant"))
});

// -----------------------------

// View Dashboard

// -----------------------------
