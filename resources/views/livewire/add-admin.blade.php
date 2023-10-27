<div>
    <form wire:submit="save" enctype="multipart/form-data">
        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Họ <span>*</span></label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="text" wire:model.blur="lastName"
                    class="form-control form-control-sm @error('lastName') is-invalid @enderror" autofocus>
                @error('lastName')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Tên <span>*</span></label>
            <div class="col-6 col-sm-6 col-md-4 col-lg-5 col-xl-3">
                <input type="text" wire:model.blur="firstName"
                    class="form-control form-control-sm @error('firstName') is-invalid @enderror">
                @error('firstName')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Email
                <span>*</span></label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="text" wire:model.blur="email"
                    class="form-control form-control-sm @error('email') is-invalid @enderror">
                @error('email')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Số điện thoại
                <span>*</span></label>
            <div class="col-6 col-sm-6 col-md-4 col-lg-5 col-xl-3">
                <input type="text" wire:model.blur="phone"
                    class="form-control form-control-sm @error('phone') is-invalid @enderror">
                @error('phone')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Mật khẩu
                <span>*</span></label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="password" wire:model.blur="password"
                    class="form-control form-control-sm @error('password') is-invalid @enderror">
                @error('password')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <div class="col offset-5 offset-sm-4 offset-md-4 offset-lg-4 offset-xl-4">
                @if ($avatarValidity == 1)
                    <img src="{{ $avatar->temporaryUrl() }}" class="rounded-circle img-upload-avatar">
                @else
                    <img src="images/user/no-avatar-admin.png" class="rounded-circle img-upload-avatar">
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Hình đại diện </label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="file" class="form-control form-control-sm" accept=".jpeg,.png,.gif"
                    wire:model.blur="avatar" id="{{ $rand }}" wire:change="checkAvatarValidity">
                @if ($avatarValidity == 0)
                    <p class="error-avatar mt-2">Ảnh không hợp lệ. Chỉ chấp nhận ảnh jpeg, jpg, png và có kích thước
                        nhỏ hơn 1MB</p>
                @endif
            </div>
        </div>

        <div class="row mb-2">
            <div class="col offset-5 offset-sm-4 offset-md-4 offset-lg-4 offset-xl-4" wire:loading wire:target="save">
                <i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i><span class="text-loading ps-3">Đang lưu
                    dữ liệu...</span>
            </div>
        </div>

        <div class="row">
            <div class="col offset-5 offset-sm-4 offset-md-4 offset-lg-4 offset-xl-4">
                <button type="submit" class="btn btn-sm btn-blue px-3">Lưu</button>
                <button type="button" class="btn btn-sm btn-red px-3 ms-2" wire:click="clear">Hủy</button>
            </div>
        </div>
    </form>
</div>
