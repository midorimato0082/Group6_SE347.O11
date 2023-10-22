<div>
    <form wire:submit.prevent="login">
        @csrf

        @include('includes.flash_message')

        <div class="form-outline mb-3">
            <input type="text" wire:model="email"
                class="form-control bg-light rounded-2 @error('email') is-invalid @enderror" placeholder="Email"
                value="{{ Cookie::get('email', old('email')) }}" autofocus>
            @error('email')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input type="password" wire:model="password"
                class="form-control bg-light rounded-2 @error('password') is-invalid @enderror" placeholder="Mật khẩu"
                value="{{ Cookie::get('password', '') }}">
            @error('password')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror

        </div>

        <div class="d-flex justify-content-between mb-3 ps-3 pe-3">
            <div class="form-check">
                <input type="checkbox" wire:model="remember" class="form-check-input" id="remember"
                    @if (Cookie::has('email')) checked @endif>
                <label for="remember" class="form-check-label">Nhớ đăng nhập</label>
            </div>
            <div>
                <a href="forget-password">Quên mật khẩu?</a>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-orange w-100 fs-5 fw-bold shadow">Đăng nhập</button>
        </div>
    </form>
</div>

