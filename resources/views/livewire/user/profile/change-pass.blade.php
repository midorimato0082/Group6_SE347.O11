<div>
    <form wire:submit="update">
        <div class="row">
            <label class="col-md-5 mb-3">Mật khẩu cũ</label>
            <div class="col-md-7 mb-3">
                <input wire:model="old" type="password"
                    class="form-control form-control-sm @error('old') is-invalid @enderror" autofocus>
                @error('old')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <label class="col-md-5 mb-3">Mật khẩu mới</label>
            <div class="col-md-7 mb-3">
                <input wire:model="new" type="password"
                    class="form-control form-control-sm @error('new') is-invalid @enderror">
                @error('new')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <label class="col-md-5 mb-3">Nhập lại mật khẩu mới</label>
            <div class="col-md-7 mb-3">
                <input wire:model="new_confirmation" type="password" class="form-control form-control-sm">
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="text-end">
                <button wire:click="clear" data-bs-dismiss="modal" type="button" class="btn btn-sm btn-red me-1">Hủy</button>
                <button type="submit" class="btn btn-sm btn-orange">Thay đổi</button>
            </div>
        </div>
    </form>
</div>
