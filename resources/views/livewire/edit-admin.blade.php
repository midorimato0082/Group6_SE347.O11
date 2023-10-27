<div>
    <form wire:submit="update" enctype="multipart/form-data">
        @include('includes.flash-message')

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Họ </label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="text" wire:model.blur="user.last_name"
                    class="form-control form-control-sm @error('user.last_name') is-invalid @enderror" autofocus>
                @error('user.last_name')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Tên </label>
            <div class="col-6 col-sm-6 col-md-4 col-lg-5 col-xl-3">
                <input type="text" wire:model.blur="user.first_name"
                    class="form-control form-control-sm @error('user.first_name') is-invalid @enderror">
                @error('user.first_name')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Email </label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="text" wire:model.blur="user.email"
                    class="form-control form-control-sm @error('user.email') is-invalid @enderror">
                @error('user.email')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Số điện thoại </label>
            <div class="col-6 col-sm-6 col-md-4 col-lg-5 col-xl-3">
                <input type="text" wire:model.blur="user.phone"
                    class="form-control form-control-sm @error('user.phone') is-invalid @enderror">
                @error('user.phone')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Mật khẩu mới </label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="password" wire:model.blur="newPassword"
                    class="form-control form-control-sm @error('newPassword') is-invalid @enderror">
                @error('newPassword')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="row mb-1">
            <div class="col offset-5 offset-sm-4 offset-md-4 offset-lg-4 offset-xl-4">
                @if ($avatarValidity == 1)
                    <img src="{{ $newAvatar->temporaryUrl() }}" class="rounded-circle img-upload-avatar admin">
                @else
                    <img src="../images/user/{{ $originalAvatar }}" class="rounded-circle img-upload-avatar admin">
                @endif
            </div>
        </div>

        <div class="row">
            <label class="col-form-label col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-end">Hình đại diện </label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input type="file" class="form-control form-control-sm" accept=".jpeg,.png,.jpg"
                    wire:model.blur="newAvatar" wire:change="checkAvatarValidity" id="{{ $rand }}">
                @if ($avatarValidity == 0)
                    <p class="error-avatar">Ảnh không hợp lệ. Chỉ chấp nhận ảnh jpeg, jpg, png và có kích thước nhỏ hơn 1MB.</p>
                @endif
            </div>
        </div>

        <div class="row mb-2">
            <div class="col offset-5 offset-sm-4 offset-md-4 offset-lg-4 offset-xl-4" wire:loading wire:target="update">
                <i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i><span class="text-loading ps-3">Đang cập nhật
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
