@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-2">
                        @if (Auth::user()->email_verified_at)
                            <p class="text-success">Email của {{ Auth::user()->first_name }} đã được xác nhận thành công.</p>
                            <p>Bây giờ bạn có thể sử dụng toàn bộ các chức năng của chúng tôi.</p>
                            <a href="{{ route('home') }}" class="btn btn-orange fw-bold shadow">Đến trang chủ</a>
                        @else
                            <p>Cảm ơn {{ Auth::user()->first_name }} đã tham gia cộng đồng nhỏ của
                                {{ config('app.name') }}.</p>
                            <p>Để sử dụng được toàn bộ các chức năng, vui lòng xác nhận địa chỉ email của bạn bằng cách nhấn
                                vào link mà chúng tôi đã gửi đến hộp thư email.</p>
                            <p>Nếu bạn vẫn chưa nhận được email của chúng tôi, vui lòng nhấn vào nút dưới đây để chúng tôi
                                gửi
                                lại email cho bạn.</p>

                            @livewire('auth.resend')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection