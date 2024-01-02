<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="description" content="Khám phá và đánh giá những điểm đến tuyệt vời nhất trên thế giới với chúng tôi. Cộng đồng chia sẻ thông tin hữu ích, đánh giá chân thực và mẹo du lịch độc đáo. Hãy lựa chọn đúng với hướng dẫn từ những người đã trải nghiệm. Bắt đầu hành trình của bạn với sự hiểu biết tốt nhất về du lịch.">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://dulichvuive.online/" />
    <meta property="og:title" content="Review Travel - Đánh Giá và Hướng Dẫn" />
    <meta property="og:description" content="Khám phá thế giới du lịch với đánh giá và hướng dẫn tuyệt vời. Điểm đến, mẹo độc đáo và những bí mật du lịch sẽ làm cho mỗi chuyến đi của bạn đáng nhớ. Bắt đầu kế hoạch cho chuyến du lịch tiếp theo ngay hôm nay!" />
    <meta property="og:image" content="https://dulichvuive.online/images/posts/thung-ca-homestay-phong-2-1-2nguoi647-1024x681.jpeg" />

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Review Travel",
      "url": "https://dulichvuive.online/",
      "logo": "https://dulichvuive.online/images/others/logo.png",
      "description": "Khám phá và đánh giá những điểm đến tuyệt vời cùng cộng đồng của chúng tôi.",
    }
    </script>


    <title>{{ $title . ' - Review Travel' ?? config('app.name') }}</title>

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
