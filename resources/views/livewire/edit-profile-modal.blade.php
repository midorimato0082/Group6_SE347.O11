<div wire:ignore.self class="modal fade" id="edit-profile-modal" tabindex="-1" aria-labelledby="editProfileModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold text-light" id="editProfileModal">Chỉnh sửa hồ sơ cá nhân
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <ul class="nav nav-pills flex-column nav-tabs nav-vertical-edit-profile" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-infor-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-infor" role="tab" aria-controls="pills-infor"
                                        aria-selected="true">Chỉnh sửa thông tin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-pass-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-pass" role="tab" aria-controls="pills-pass"
                                        aria-selected="false">Thay đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-8 mt-3">
                            <div class="tab-content mb-3">
                                <div class="tab-pane fade show active" id="pills-infor" role="tabpanel"
                                    aria-labelledby="pills-infor-tab" tabindex="0">
                                    <form wire:submit.prevent="updateInfor">
                                        @include('includes.flash-message')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="mb-1">Họ</label>
                                                <input type="text" wire:model.blur="user.last_name"
                                                    class="form-control form-control-sm @error('user.last_name') is-invalid @enderror"
                                                    autofocus>
                                                @error('user.last_name')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="mb-1">Tên</label>
                                                <input type="text"
                                                    class="form-control form-control-sm @error('user.first_name') is-invalid @enderror"
                                                    wire:model.blur="user.first_name">
                                                @error('user.first_name')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <label class="mb-1">Địa chỉ email</label>
                                                <input type="text"
                                                    class="form-control form-control-sm @error('user.email') is-invalid @enderror"
                                                    wire:model.blur="user.email">
                                                @error('user.email')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <label class="mb-1">Số điện thoại</label>
                                                <input type="text"
                                                    class="form-control form-control-sm @error('user.phone') is-invalid @enderror"
                                                    wire:model.blur="user.phone">
                                                @error('user.phone')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row">
                                            <div class="text-end">
                                                <button type="button" class="btn btn-red me-1"
                                                    wire:click="clear">Hủy</button>
                                                <button type="submit" class="btn btn-blue">Lưu</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="pills-pass" role="tabpanel"
                                    aria-labelledby="pills-pass-tab" tabindex="0">
                                    @livewire('change-pass-admin')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
