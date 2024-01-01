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
        $('#add-modal').modal('hide');
        $('#edit-modal').modal('hide');
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

    $(document).bind('alert-warning', function (e) {
        toastr.warning(e.detail.message)
    });

    $('#startDate').on('change', function () {
        Livewire.dispatch('set-createdFrom', { value: this.value });
    });

    $('#endDate').on('change', function () {
        Livewire.dispatch('set-createdTo', { value: this.value });
    });
    // --------------------------------------

    // View Add/Edit
    $('#save-post').on('click', function () {
        Livewire.dispatch('get-tags', { tags: $('input[data-role="tagsinput"]').val() });
        Livewire.dispatch('get-places', { places: $('#place-dropdown').val() });
    });

    $('#clear-post').on('click', function () {
        $('input[data-role="tagsinput"]').tagsinput('removeAll');
        $('#place-dropdown').val(null).trigger('change');
    });

    $(document).bind('clear-tags', function (e) {
        $('input[data-role="tagsinput"]').tagsinput('removeAll');
        $('input[data-role="tagsinput"]').tagsinput('add', e.detail.tags);
    });

    $('#place-dropdown').select2({
        maximumSelectionLength: 5
    });

    $(document).bind('set-places', function (e) {
        $('#place-dropdown').children().remove();
        $.each(e.detail.places, function (key, value) {
            $('#place-dropdown').append($('<option></option>')
                .attr('value', key)
                .text(value));
        });
    });

    $(document).bind('clear-places', function (e) {
        $('#place-dropdown').val(e.detail.places).trigger('change');
    });

    $('#province-dropdown').select2({
        dropdownParent: $('#add-modal')
    });

    $('#district-dropdown').select2({
        dropdownParent: $('#add-modal'),
    });

    $('#new-district').on('click', function () {
        $('#input-new-district').removeClass('d-none');
    });

    $('#province-dropdown').on('change', function (e) {
        Livewire.dispatch('get-province', { province: e.target.value });
    });

    $(document).bind('set-districts', function (e) {
        $('#district-dropdown').children().remove();
        $.each(e.detail.districts, function (key, value) {
            $('#district-dropdown').append($('<option></option>')
                .attr('value', key)
                .text(value));
        });
    });

    $('#save-place').on('click', function () {
        Livewire.dispatch('get-district', { district: $('#district-dropdown').val() });
    });

    $('#province-dropdown-edit').select2({
        dropdownParent: $('#edit-modal')
    });

    $('#district-dropdown-edit').select2({
        dropdownParent: $('#edit-modal')
    });

    $(document).bind('set-province-edit', function (e) {
        $('#province-dropdown-edit').val(e.detail.province).trigger('change');
    });

    let secondChange = false;
    $('#province-dropdown-edit').on('change', function (e) {
        if (secondChange)
            Livewire.dispatch('get-province-edit', { province: e.target.value });
        else
            secondChange = true;
    });

    $('#update-place').on('click', function () {
        Livewire.dispatch('get-district-edit', { district: $('#district-dropdown-edit').val() });
    });

    $(document).bind('set-districts-edit', function (e) {
        $('.option').remove();

        $.each(e.detail.districts, function (key, value) {
            $('#district-dropdown-edit').append($('<option class="option"></option>')
                .attr('value', key)
                .text(value));
        });
    });

    $(document).bind('clear-edit', function (e) {
        secondChange = false;
        $('.option').remove();
    });

    $('#new-district-edit').on('click', function () {
        $('#input-new-district-edit').removeClass('d-none');
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
        $('#rating-reset').removeClass('d-none');
        $('.result-rating').removeClass('d-none');

        $('#rating').addClass('d-none');
        $('#required-rating').addClass('d-none');
    });

    $('#rating-reset').on('click', function () {
        Livewire.dispatch('reset-rating');
        $('#rating-reset').addClass('d-none');
        $('.result-rating').addClass('d-none');

        $('#rating').removeClass('d-none');
        $('#required-rating').removeClass('d-none');
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

    $(".input-header").on('keyup change search', function () {
        $('#search-result').addClass('d-none');
    });
    // -----------------------------

    // Profile Page
    $('#tab1-pane').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-tab1');
    });

    $('#tab2-pane').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-tab2');
    });

    $('#tab3-pane').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-tab3');
    });

    $('#tab4-pane').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-tab4');
    });

    $('#tab5-pane').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 1)
            Livewire.dispatch('load-more-tab5');
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
}))
