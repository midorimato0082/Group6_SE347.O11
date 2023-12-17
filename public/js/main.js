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
        $('#import-modal').modal('hide');
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

    $('#startDate').on('change', function () {
        Livewire.dispatch('set-createdFrom', { value: this.value });
    });

    $('#endDate').on('change', function () {
        Livewire.dispatch('set-createdTo', { value: this.value });
    });
    // --------------------------------------

    // View Add/Edit
    $('#save-review').on('click', function () {
        Livewire.dispatch('get-tags', { tags: $('input[data-role="tagsinput"]').val() });
    });

    $('#clear-review').on('click', function () {
        $('input[data-role="tagsinput"]').tagsinput('removeAll');
    });

    $(document).bind('clear-tags', function (e) {
        $('input[data-role="tagsinput"]').tagsinput('removeAll');
        $('input[data-role="tagsinput"]').tagsinput('add', e.detail.tags);
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

    // Breadcrumb & Latest Posts Section
    $('#breadcrumb').ready(function () {
        if (window.location.pathname != '/' && !window.location.pathname.includes('/email/verify'))
            $('#breadcrumb div').removeClass('d-none');
    });

    $('.latest-posts').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-latest-posts');
    });
    // -----------------------------

    // Like
    $('#like').on('click', function () {
        $('.login-required').removeClass('d-none');
        $('[data-bs-toggle="tooltip"]').tooltip('hide');
    });
    // -----------------------------

    // Rating
    $('#rating').on('click', function () {
        Livewire.dispatch('save-rating');
        $('#rating').addClass('d-none');
        $('#rating-reset').removeClass('d-none');
    });

    $('#rating-reset').on('click', function () {
        Livewire.dispatch('reset-rating');
        $('#rating').removeClass('d-none');
        $('#rating-reset').addClass('d-none');
    });
    // -----------------------------

    // Filter in Page Content Right
    $('.filter-provinces').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-provinces');
    });

    $('.filter-districts').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-districts');
    });
    // -----------------------------

    // Share post
    var popupSize = {
        width: 780,
        height: 550
    };

    $(document).on('click', '.btn-share', function (e) {
        var verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

        var popup = window.open($(this).prop('href'), 'social',
            'width=' + popupSize.width + ',height=' + popupSize.height +
            ',left=' + verticalPos + ',top=' + horisontalPos +
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }

        $('[data-bs-toggle="tooltip"]').tooltip('hide');
    });
    // -----------------------------

    // Search in Page
    $('.search-header').on('click', function () {
        if (!$('.input-header').hasClass('input-header-open'))
            $('#search-result').addClass('d-none');
        else {
            let $value = $('.input-header').val();
            if ($value !== '') {
                $('#search-result').removeClass('d-none');
                Livewire.dispatch('search-page', { search: $value });
            }
            $('.input-header').on('keyup', function () {
                let $value = $(this).val();
                if ($value !== '') {
                    $('#search-result').removeClass('d-none');
                    Livewire.dispatch('search-page', { search: $value });
                } else {
                    $('#search-result').addClass('d-none');
                }
            });
        }
    });

    $(".input-header").on('keyup change search', function() {
        $('#search-result').addClass('d-none');    
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


Alpine.data('data', () => ({
    open: false,

    filter() {
        this.open = !this.open;
        this.open || Livewire.dispatch('close-filter');
    },

    // init() {
    //     this.$watch('checkedRecords', value => console.log(this.checkedRecords.length))
    // }
}))
