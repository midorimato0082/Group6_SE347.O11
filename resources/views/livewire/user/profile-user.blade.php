<div class="container">
    @include('livewire.admin.edit-profile-modal')

    <div class="row">
        <div class="col-lg-5 mt-2">
            <div class="card bg-transparent border-0">
                <div class="card-body text-center">
                    @if ($successAvatar == 1)
                        <img src="{{ $newAvatar->temporaryUrl() }}" class="rounded-circle img-fluid profile-admin">
                    @else
                        <img src="{{ asset('images/avatars/' . $originalAvatar) }}" class="rounded-circle img-fluid profile-admin">
                    @endif
                    <h4 class="fw-bold mt-3">{{ $user->fullName }}</h4>
                    <span class="btn btn-blue btn-file mt-1">Cập nhật avatar<input type="file"
                                                                                   wire:model="newAvatar" wire:change="updateAvatar" accept=".jpeg,.png,.jpg"></span>
                    @if ($successAvatar == 0)
                        <p class="error-avatar mt-2">Ảnh không hợp lệ. Chỉ chấp nhận ảnh jpeg, jpg, png và có
                            kích thước nhỏ hơn 1MB.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <p class="mb-0">Họ</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-muted mb-0">{{ $user->last_name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p class="mb-0">Tên</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-muted mb-0">{{ $user->first_name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p class="mb-0">Số điện thoại</p>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-muted mb-0">{{ $user->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="button" class="btn btn-blue" data-bs-toggle="modal"
                        data-bs-target="#edit-profile-modal">Cập nhật thông tin</button>
            </div>
        </div>
    </div>
</div>
