<div>
    @dump($checkedUser)
    <div class="row px-1 mb-4">
        <div class="col-7 col-sm-7 col-md-7 col-lg-7">
            @if (count($checkedUser) != 0)
                <button onclick="return confirm('Bạn chắc chắn muốn xóa user này?') || event.stopImmediatePropagation()"
                    wire:click="deleteRecords" class="btn btn-sm btn-blue">Xóa {{ count($checkedUser) }}
                    dòng được chọn</button>
            @endif
        </div>

        <div class="col-2 col-sm-2 col-md-2 col-lg-2">
            <select class="form-select form-select-sm" wire:model="role" wire:change="resetPage()">
                <option value="">Tất cả User</option>
                <option value="1">Admin</option>
                <option value="0">Normal User</option>
            </select>
        </div>

        <div class="col input-group search">
            <input type="text" wire:model.debounce.150ms="keyword" wire:input="resetPage()"
                class="form-control form-control-sm searchbox" placeholder="Tìm kiếm...">

            @if ($keyword)
                <button class="btn bg-transparent clear-icon" type="button" wire:click="$set('keyword', null)">
                    <i class="fa fa-times"></i>
                </button>
            @endif

            <button class="btn btn-sm btn-blue search-icon" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    @if ($checkedPage)
    {{-- Bỏ -1 đi nhé --}}
        <div class="px-1 mb-4">
            @if ($checkedAll)
                Bạn đã chọn <strong>{{ $users->total() - 1 }}</strong> user.
            @else
                Bạn đã chọn <strong>{{ count($checkedUser) }}</strong> user. Bạn có muốn chọn tất cả
                <strong>{{ $users->total() - 1 }}</strong> user (trừ bạn) đang được hiển thị? <a href="#"
                    wire:click="checkAll"><strong>Chọn tất cả user.</strong></a>
            @endif
        </div>
    @endif

    @include('includes.flash_message')

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><input class="form-check-input form-check-input-sm" type="checkbox"
                            wire:model.live="checkedPage"></th>
                    <th>STT</th>
                    <th class="th-sm">Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Avatar</th>
                    <th>Trạng thái</th>
                    <th>Vai trò</th>
                    <th></th>
                </tr>
            </thead>

            {{-- Mọi người lọc bỏ những thứ liên quan đến session('user.id') nhé, vì việc xóa tài khoản có liên quan đến tài khoản đang đăng nhập nên nó có hơi khác chút so với các management khác --}}
            <tbody id="table-content">
                @foreach ($users as $key => $user)
                    <tr wire:key="row-{{ $user->id }}"
                        class="@if (session('user.id') == $user->id) table-danger 
                        @elseif ($this->isChecked($user->id)) 
                        table-primary @endif">
                        <td>
                            @if (session('user.id') != $user->id)
                                <input class="form-check-input form-check-input-sm" type="checkbox"
                                    value="{{ $user->id }}" wire:model.live="checkedUser">
                            @endif
                        </td>
                        <td>{{ $key + $users->firstItem() }}</td>
                        <td>{{ $user->last_name . ' ' . $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td><img src="images/user/{{ $user->avatar }}" class="rounded-circle img-table"></td>
                        <td>
                            @if (!empty($user->email_verified_at))
                                <i class="fa fa-check text-success" data-bs-toggle="tooltip"
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
                            @if ($user->is_admin == 1)
                                <a href="{{ url('edit-admin/' . $user->id) }}" data-bs-toggle="tooltip"
                                    title="Cập nhật Admin">
                                    <i class="fas fa-pencil fa-sm"></i>
                                </a>
                            @endif

                            @if (session('user.id') != $user->id)
                                @if (!$checkedUser)
                                    <a onclick="return confirm('Bạn chắc chắn muốn xóa user này?') || event.stopImmediatePropagation()"
                                        wire:click="deleteSingleRecord({{ $user->id }})" data-bs-toggle="tooltip"
                                        title="Xóa user">
                                        <i class="fa fa-times fa-lg text-danger"></i>
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
        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
            <small>Hiển thị {{ $users->count() }} user trong số {{ $users->total() }} user.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $users->links() }}
            </ul>
        </div>
    </div>
</div>
