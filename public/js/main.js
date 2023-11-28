$(function () {
    // Layouts
    $('a[href*="logout"]').on('click', function (e) {
        e.preventDefault();
        $('#logout-form').submit();
    });
    // --------------------------------------

    // View Admin Layout
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass('open');
        return false;
    });

    $('#sidebar .nav-item').on('hide.bs.dropdown', function (e) {
        if (e.clickEvent)
            e.preventDefault();
    });

    $('#sidebar').ready(setupLayoutAdmin);
    // --------------------------------------

    // View All
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('.page-item').on('click', function () {
        Livewire.dispatch('reset-checked-page');
    });

    $(document).bind('close-modal', function () {
        $('#delete-modal').modal('hide');
        $('#edit-profile-modal').modal('hide');
    });

    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            queueMicrotask(() => {
                $('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
            });
        });
    });

    toastr.options = {
        "positionClass": "toast-bottom-right",
        "progressBar": true,
        "closeButton": true,
    }
    $(document).bind('alert-success', function (e) {
        toastr.success(e.detail.message, 'Thành công!')
    });
    // --------------------------------------

    // View Edit
    $('#add-review').on('click', function () {
        Livewire.dispatch('get-tags', { tags: $('input[data-role="tagsinput"]').val() });
    });
    // --------------------------------------

    // Header
    $('.navbar-left').find('a').filter(function () {
        return this.href == window.location.href.split('#')[0].split('?')[0];
    }).addClass('active');

    $('.search-header').on('click', function () {
        $('.input-header').toggleClass('input-header-open');
    });
    // --------------------------------------

    // Button scroll to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 30)
            $('#btn-to-top').fadeIn();
        else
            $('#btn-to-top').fadeOut();
    });

    $('#btn-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, '300');
    });
    // -----------------------------

    // Breadcrumb - Latest Reviews Section

    $('#breadcrumb').ready(function () {
        if (window.location.pathname != '/' && !window.location.pathname.includes('/email/verify'))
            $('#breadcrumb div').removeClass('d-none');
    });

    $('.latest-reviews').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more');
    });

    // -----------------------------

});

function setupLayoutAdmin() {
    let current_url = window.location.href.split('#')[0].split('?')[0];
    let value_editing = '';

    let nav_link = $('#sidebar').find('a').filter(function () {
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
        $('a.' + value_editing).removeClass('d-none').css('pointer-events', 'none');
}