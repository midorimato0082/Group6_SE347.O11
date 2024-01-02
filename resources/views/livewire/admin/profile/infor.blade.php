<div class="row">
    @include('admin.edit-profile-modal')

    <div class="col-lg-5 text-center mt-3">
        <img src="{{ $avatar }}" class="rounded-circle img-fluid profile-avatar" alt="Avatar Review Travel">
        <h5 class="fw-bold mt-3">{{ $user->full_name }}</h5>
        <span class="btn btn-sm btn-blue btn-file mt-1">
            Cập nhật avatar
            <input wire:model="avatar" type="file" accept=".jpeg,.png,.jpg" id="input-avatar">
        </span>
        @error('avatar')
            <p class="error-avatar mt-2">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="col d-flex flex-column profile">
        <div class="row">
            <div class="col-lg-4 fw-bold">
                <p>Họ và tên</p>
            </div>
            <div class="col">
                <p>{{ $user->full_name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 fw-bold">
                <p>Email</p>
            </div>
            <div class="col">
                <p>{{ $user->email }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 fw-bold">
                <p>Số điện thoại</p>
            </div>
            <div class="col">
                <p>{{ $user->phone }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 fw-bold">
                <p>Ngày gia nhập</p>
            </div>
            <div class="col">
                <p>{{ Auth::user()->created_time }}</p>
            </div>
        </div>

        <div class="mt-auto text-end">
            <button type="button" class="btn btn-sm btn-blue" data-bs-toggle="modal"
                data-bs-target="#edit-profile-modal">
                Cập nhật thông tin
            </button>
        </div>
    </div>
</div>
