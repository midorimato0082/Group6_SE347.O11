<div>
    @if (session('resent'))
        <p class="text-success">Link xác minh email mới đã được gửi đến địa chỉ email của bạn.</p>
    @endif
    <div class="mb-2" wire:loading wire:target="resend">
        <p class="text-loading">
            <i class="fa fa-spinner fa-spin fa-2x me-2" aria-hidden="true"></i>
            Đang thực hiện yêu cầu. Vui lòng đợi một lát...
        </p>
    </div>
    <div>
        <button wire:click="resend" class="btn btn-orange" @disabled($errors->any())>Gửi lại email xác nhận</button>
    </div>
</div>
