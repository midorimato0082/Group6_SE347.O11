<div>
    <form wire:submit="register">
        @csrf

        <div class="form-outline mb-3">
            <input wire:model.blur="lastName" wire:blur="generateName" type="text"
                class="form-control bg-light rounded-2 col @error('lastName') is-invalid @enderror" placeholder="Họ"
                required autofocus>
            @error('lastName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input wire:model.blur="firstName" wire:blur="generateName" type="text"
                class="form-control bg-light rounded-2 col @error('firstName') is-invalid @enderror" placeholder="Tên" required>
            @error('firstName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input wire:model.blur="email" type="email"
                class="form-control bg-light rounded-2 @error('email') is-invalid @enderror" placeholder="Email" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input wire:model="password" type="password"
                class="form-control bg-light rounded-2 @error('password') is-invalid @enderror" placeholder="Mật khẩu" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline mb-3">
            <input wire:model="password_confirmation" type="password" class="form-control bg-light rounded-2"
                placeholder="Nhập lại mật khẩu" required>
        </div>

        <div class="form-outline mb-3 text-center">
            @if ($avatar)
                <img src="{{ $avatar->temporaryUrl() }}" class="rounded-circle mb-3 img-upload" alt="Review Travel Group 6 SE347.O11 - Hình Upload">
                <a wire:click.prevent="removeAvatar"><i class="fa fa-times text-danger fw-bold"></i></a>               
            @else
                <img src="{{ asset('images/others/no-avatar.jpg') }}" class="rounded-circle mb-3 img-upload" alt="Review Travel Group 6 SE347.O11 - Hình Upload">
            @endif

            <div class="input-group custom-file-btn">
                <label class="input-group-text" for="file-{{ $id }}">Chọn avatar</label>
                <input id="file-{{ $id }}" wire:model="avatar" type="file"
                    class="form-control @error('avatar') is-invalid @enderror" accept=".png,.jpeg,.jpg" />
                @error('avatar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="mb-2" wire:loading wire:target="register">
            <p class="text-loading">
                <i class="fa fa-spinner fa-spin fa-2x me-2" aria-hidden="true"></i>
                Đang thực hiện yêu cầu. Vui lòng đợi một lát...
            </p>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-orange w-100 fs-5 fw-bold shadow" @disabled($errors->hasAny('lastName', 'firstName', 'email'))>Đăng ký</button>
        </div>
    </form>
</div>
