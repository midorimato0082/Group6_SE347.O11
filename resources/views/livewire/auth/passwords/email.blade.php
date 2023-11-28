<div>
    <form wire:submit="sendResetLinkEmail">
        @csrf

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @else
            <p>Nhập địa chỉ email của bạn và Review Travel sẽ gửi link đặt lại mật khẩu cho bạn qua email.</p>
        @endif

        <div class="form-outline mb-3">
            <input wire:model.blur="email" type="email"
                class="form-control bg-light rounded-2 @error('email') is-invalid @enderror" placeholder="Email"
                required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2" wire:loading wire:target="sendResetLinkEmail">
            <p class="text-loading">
                <i class="fa fa-spinner fa-spin fa-2x me-2" aria-hidden="true"></i>
                Đang thực hiện yêu cầu. Vui lòng đợi một lát...
            </p>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-orange w-100 fs-5 fw-bold shadow">Đặt lại mật khẩu</button>
        </div>
    </form>
</div>
