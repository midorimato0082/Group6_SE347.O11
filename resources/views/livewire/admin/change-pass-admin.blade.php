<div>
    <form wire:submit.prevent="changePass">
        @include('includes.flash-message')
        <div class="row">
            <label class="col-md-5 mb-3">Mật khẩu cũ</label>
            <div class="col-md-7 mb-3">
                <input type="text" wire:model.blur="oldPassword"
                    class="form-control form-control-sm @error('oldPassword') is-invalid @enderror" autofocus>
                @error('oldPassword')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <label class="col-md-5 mb-3">Mật khẩu mới</label>
            <div class="col-md-7 mb-3">
                <input type="text" wire:model.blur="newPassword"
                    class="form-control form-control-sm @error('newPassword') is-invalid @enderror" autofocus>
                @error('newPassword')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <label class="col-md-5 mb-3">Nhập lại mật khẩu mới</label>
            <div class="col-md-7 mb-3">
                <input type="text" wire:model.blur="newPassword_confirmation"
                    class="form-control form-control-sm" autofocus>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="text-end">
                <button type="button" class="btn btn-red me-1" wire:click="clear">Hủy</button>
                <button type="submit" class="btn btn-blue">Thay đổi</button>
            </div>
        </div>
    </form>
</div>
