<div>
    <form wire:submit="login">
        @csrf

        @include('includes.flash-message')

        <div class="form-outline mb-3">
            <input wire:model.blur="email" type="email" class="form-control bg-light rounded-2 @error('email') is-invalid @enderror"
                placeholder="Email" autocomplete="email" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input wire:model="password" type="password" class="form-control bg-light rounded-2 @error('password') is-invalid @enderror"
                placeholder="Mật khẩu" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="d-flex justify-content-between mb-3 ps-3 pe-3">
            <div class="form-check">
                <input wire:model="remember" type="checkbox" class="form-check-input" id="remember">
                <label for="remember" class="form-check-label">Nhớ đăng nhập</label>
            </div>
            <div>
                <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-orange w-100 fs-5 fw-bold shadow" @disabled($errors->has('email'))>Đăng nhập</button>
        </div>
    </form>
</div>
