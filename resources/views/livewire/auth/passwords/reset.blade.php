<div>
    <form wire:submit="resetPassword">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-outline mb-3">
            <input wire:model.blur="email" type="email" class="form-control bg-light rounded-2 @error('email') is-invalid @enderror" readonly tabindex="-1">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input wire:model="password" type="password" class="form-control bg-light rounded-2 @error('password') is-invalid @enderror"
                placeholder="Mật khẩu mới" required autofocus>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input wire:model="password_confirmation" type="password" class="form-control bg-light rounded-2" placeholder="Nhập lại mật khẩu mới" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-orange w-100 fs-5 fw-bold shadow" @disabled($errors->has('email'))>Đặt lại mật khẩu</button>
        </div>
    </form>

</div>