@extends('layouts.user')

{{-- Em làm tương tự cho các view location-page, region-page,... nhé --}}
@section('breadcrumn')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    @include('user.carousel-reviews')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8 col-lg-8 col-xl-8">
                {{-- Code thêm nội dung bên trái ở đây --}}
            </div>

            @livewire('user.latest-reviews')
        </div>
    </div>
@endsection
