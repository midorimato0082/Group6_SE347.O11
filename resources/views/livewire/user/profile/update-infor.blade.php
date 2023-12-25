<div>
    <form wire:submit="update">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="mb-1">Họ</label>
                <input wire:model="last_name" type="text"
                    class="form-control form-control-sm @error('last_name') is-invalid @enderror" autofocus>
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="mb-1">Tên</label>
                <input wire:model="first_name" type="text"
                    class="form-control form-control-sm @error('first_name') is-invalid @enderror">
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="mb-1">Địa chỉ email</label>
                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                    wire:model.blur="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="mb-2 text-end" wire:loading wire:target="update">
                <small class="text-loading">
                    <i class="fa fa-spinner fa-spin me-2" aria-hidden="true"></i>
                    Đang thực hiện yêu cầu. Vui lòng đợi một lát...
                </small>
            </div>
            <div class="text-end">
                <button wire:click="clear" type="button" class="btn btn-sm btn-red me-1">Hủy</button>
                <button type="submit" class="btn btn-sm btn-orange">Lưu</button>
            </div>
        </div>
    </form>
</div>
