@extends('layouts.user')

@section('content')
    @include('user.carousel-reviews')

    {{-- Code nội dung tiếp theo ở đây --}}
    @for ($i = 0; $i < 20; $i++)
        <div class="row">
            <i class="fas fa-heart fa-3x" data-aos="fade-up"></i>
    @endfor
@endsection
