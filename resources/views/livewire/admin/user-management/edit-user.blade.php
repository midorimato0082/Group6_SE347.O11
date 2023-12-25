<div>
    <form wire:submit="update">
        <div class="modal-body p-2">
            <div class="row my-2">
                <label class="col-form-label col-md-3 text-end">
                    Họ<span>*</span>
                </label>
                <div class="col me-2">
                    <input wire:model.blur="last_name" type="text"
                        class="form-control form-control-sm @error('last_name') is-invalid @enderror" autofocus>
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-3 text-end">
                    Tên<span>*</span>
                </label>
                <div class="col me-2">
                    <input wire:model.blur="first_name" type="text"
                        class="form-control form-control-sm @error('first_name') is-invalid @enderror" autofocus>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-3 text-end">
                    Email<span>*</span>
                </label>
                <div class="col me-2">
                    <input wire:model.blur="email" type="text"
                        class="form-control form-control-sm @error('email') is-invalid @enderror" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-3 text-end">
                    Số điện thoại
                </label>
                <div class="col me-2">
                    <input wire:model.blur="phone" type="text"
                        class="form-control form-control-sm @error('phone') is-invalid @enderror" autofocus>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-3 text-end">
                    Vai trò
                </label>
                <div class="col">
                    <select wire:model="role_id" class="form-select form-select-sm w-50">
                        @foreach ($this->roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col offset-md-3 d-flex">
                    @if ($newAvatar)
                        <img src="{{ $newAvatar->temporaryUrl() }}" class="rounded-circle mb-2 img-modal">
                        <a wire:click.prevent="removeNewAvatar"><i class="fa fa-times text-danger fw-bold"></i></a>
                    @else
                        <img src="{{ $avatar }}" class="rounded-circle mb-2 img-modal">
                    @endif
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-3 text-end">
                    Hình đại diện
                </label>
                <div class="col me-2">
                    <input wire:model="newAvatar" id="{{ $fileId }}" type="file"
                        class="form-control form-control-sm @error('newAvatar') is-invalid @enderror" autofocus>
                    @error('newAvatar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <div class="col offset-md-3 d-flex">
                    Ẩn
                    <div class="form-switch form-check ms-2">
                        <input wire:model="is_active" type="checkbox" class="form-check-input" role="switch">
                        <label class="form-check-label">Hiển thị</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div wire:loading wire:target="update" class="w-100 text-end mb-0">
                <p class="text-loading">
                    <i class="fa fa-spinner fa-spin me-2" aria-hidden="true"></i>
                    Đang thực hiện yêu cầu. Vui lòng đợi một lát...
                </p>
            </div>
            <button wire:click="closeModal" data-bs-dismiss="modal" type="button" class="btn btn-sm btn-red px-3 ms-2">
                Hủy
            </button>
            <button type="submit" class="btn btn-sm btn-blue px-3">
                Lưu
            </button>
        </div>
    </form>
</div>
