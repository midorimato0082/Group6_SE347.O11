<div>
    <form wire:submit="save">
        <div class="modal-body p-2">
            <div class="row my-2">
                <label class="col-form-label col-md-4 text-end">
                    Tên danh mục<span>*</span>
                </label>
                <div class="col me-2">
                    <input wire:model="name" type="text"
                        class="form-control form-control-sm @error('name') is-invalid @enderror" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-4 text-end">
                    Liên quan địa điểm
                </label>
                <div class="col me-2 d-flex align-items-center">
                    Có
                    <div class="form-switch form-check ms-2">
                        <input wire:model="isPlace" type="checkbox" class="form-check-input" role="switch">
                        <label class="form-check-label">Không</label>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col offset-md-4 d-flex">
                    Ẩn
                    <div class="form-switch form-check ms-2">
                        <input wire:model="isActive" type="checkbox" class="form-check-input" role="switch">
                        <label class="form-check-label">Hiển thị</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div wire:loading wire:target="save" class="w-100 text-end mb-0">
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