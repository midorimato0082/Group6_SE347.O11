<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Khám phá thế giới của trải nghiệm du lịch trên nền tảng đánh giá của chúng tôi. Từ những điểm đến tuyệt vời đến những mẹo nội địa, những đánh giá được cộng đồng tạo ra cung cấp hướng dẫn tuyệt vời cho cuộc phiêu lưu tiếp theo của bạn. Khám phá những địa điểm tốt nhất, những viên ngọc ẩn mình và những thông điệp về du lịch làm cho mỗi chuyến đi đáng nhớ. Bắt đầu kế hoạch cho chuyến đi tiếp theo của bạn với chúng tôi!">

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="{{ asset('images/others/logo-orange.png') }}" />

    {{-- Bootstrap 5.3.2 CSS --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Bootstrap Tags Input --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />

    {{-- AOS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    {{-- Bootstrap Multiselect --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    {{-- Livewire --}}
    @livewireStyles

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GR7X1F8N2D"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-GR7X1F8N2D');
    </script>
</head>
