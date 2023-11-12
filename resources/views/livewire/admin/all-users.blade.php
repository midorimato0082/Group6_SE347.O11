<div>
    @include('livewire.admin.delete-confirm-modal')

    <div class="row px-1 mb-4">
        <div class="col-4 col-sm-5 col-md-5 col-lg-6 col-xl-7">
            @if (count($checkedUser) != 0)
                <button data-bs-toggle="modal" data-bs-target="#delete-modal" class="btn btn-sm btn-blue">Xóa
                    {{ count($checkedUser) }} dòng được chọn</button>
            @endif
        </div>

        <div class="col-4 col-sm-4 col-md-3 col-lg-3 col-xl-2">
            <select class="form-select form-select-sm" wire:model="role" wire:change="resetPageChecked">
                <option value="">Tất cả User</option>
                <option value="1">Admin</option>
                <option value="0">Normal User</option>
            </select>
        </div>

        <div class="col position-relative">
            <input type="search" wire:model="keyword" wire:input="resetPageChecked"
                class="form-control form-control-sm searchbox" placeholder="Tìm kiếm...">
            <button class="btn btn-sm btn-blue search-icon position-absolute top-0" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    @if (count($checkedUser) != 0)
        <div class="px-1 mb-4">
            Bạn đã chọn <strong>{{ count($checkedUser) }}</strong> user. 
            @if($checkedPage && $users->count() != $users->total())
            Bạn có muốn chọn tất cả <strong>{{ $users->total() - 1 }}</strong> user (trừ bạn) đang được hiển thị? <a wire:click="checkAll"><strong>Chọn tất cả user.</strong></a>
            @endif            
        </div>
    @endif

    @include('includes.flash-message')

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><input class="form-check-input form-check-input-sm" type="checkbox"
                            wire:model.live="checkedPage"></th>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Avatar</th>
                    <th>Trạng thái</th>
                    <th>Vai trò</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="table-content">
                @foreach ($users as $key => $user)
                    <tr wire:key="row-{{ $user->id }}"
                        @if (session('user.id') == $user->id) class="table-danger"
                        @elseif($this->isChecked($user->id))
                        class="table-primary" @endif>
                        <td>
                            @if (session('user.id') != $user->id)
                                <input class="form-check-input form-check-input-sm" type="checkbox"
                                    value="{{ $user->id }}" wire:model.live.debounce.150ms="checkedUser">
                            @endif
                        </td>
                        <td>{{ $key + $users->firstItem() }}</td>
                        <td>{{ $user->fullName }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td><img src="{{ asset('images/users/' . $user->avatar) }}" class="rounded-circle img-table"></td>
                        <td>
                            @if (!empty($user->email_verified_at))
                                <i class="fa fa-chimgeck text-success" data-bs-toggle="tooltip"
                                    title="Email đã xác nhận"></i>
                            @else
                                <i class="fa fa-ban text-danger" data-bs-toggle="tooltip"
                                    title="Email chưa được xác nhận"></i>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_admin == 1)
                                <i class="fas fa-user-cog" data-bs-toggle="tooltip" title="Admin"></i>
                            @else
                                <i class="fas fa-user" data-bs-toggle="tooltip" title="Normal user"></i>
                            @endif
                        </td>
                        <td>
                            @if (session('user.id') != $user->id)
                                @if ($user->is_admin == 1)
                                    <a href="{{ url('edit-admin/' . $user->id) }}" data-bs-toggle="tooltip"
                                        title="Cập nhật Admin">
                                        <i class="fas fa-pencil fa-sm"></i>
                                    </a>
                                @endif
                                @if (!$this->isChecked($user->id))
                                    <a data-bs-toggle="tooltip" title="Xóa user">
                                        <i class="fa fa-times fa-lg text-danger" data-bs-toggle="modal"
                                            data-bs-target="#delete-modal"
                                            wire:click="set('userId', {{ $user->id }})">
                                        </i>
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-2">
        <div class="col-4 col-sm-3 col-md-4 col-lg-4 col-xl-4">
            <small>Hiển thị {{ $users->count() }} user trong số {{ $users->total() }} user.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $users->links() }}
            </ul>
        </div>
    </div>
</div>