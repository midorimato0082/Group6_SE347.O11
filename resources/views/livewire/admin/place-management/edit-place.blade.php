<div>
    <form wire:submit="update">
        <div class="modal-body p-2">
            <div class="row my-2">
                <label class="col-form-label col-md-3 text-end">
                    Tên địa điểm<span>*</span>
                </label>
                <div class="col">
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
                <label class="col-form-label col-md-3 text-end">
                    Danh mục
                </label>
                <div class="col">
                    <select wire:model="category_id" class="form-select form-select-sm w-50">
                        @foreach ($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-3 text-end">Tỉnh thành</label>
                <div wire:ignore class="col">
                    <select id="province-dropdown-edit" style="width: 50%">
                        @foreach ($this->provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <label class="col-form-label col-md-3 text-end">Quận huyện</label>
                <div wire:ignore class="col">
                    <select wire:model="district_id" id="district-dropdown-edit" style="width: 50%">
                    </select>
                    <button class="btn btn-sm btn-blue my-1" id="new-district-edit" type="button">
                        Tạo quận huyện mới
                    </button>
                </div>
            </div>
            @if ($errors->has('district_id') || $errors->has('newDistrict'))
                <div class="row mb-2">
                    <div class="col offset-md-3">
                        <strong class="error">Bạn cần chọn quận huyện.</strong>
                    </div>
                </div>
            @endif

            <div id="input-new-district-edit" class="row mt-2 d-none">
                <label class="col-form-label col-md-3 text-end px-0">
                    Tên quận huyện
                </label>
                <div class="col-8">
                    <input wire:model="newDistrict" type="text" class="form-control form-control-sm">
                </div>
            </div>

            <div class="row mt-2">
                <label class="col-form-label col-md-3 text-end">
                    Địa chỉ
                </label>
                <div class="col-8">
                    <input wire:model="address" type="text" class="form-control form-control-sm">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-form-label col-md-3 text-end">
                    Giá
                </label>
                <div class="col d-flex align-items-center">
                    <input wire:model="min_price" type="number" class="form-control form-control-sm" placeholder="₫ Từ"
                        min="0">
                    <span class="mx-3">-</span>
                    <input wire:model="max_price" type="number" class="form-control form-control-sm"
                        placeholder="₫ Đến" min="0">
                </div>
                <div class="text-center mt-3">
                    @error('min_price')
                        <p class="error" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
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
            <button id="update-place" type="submit" class="btn btn-sm btn-blue px-3">
                Lưu
            </button>
        </div>
    </form>
</div>
