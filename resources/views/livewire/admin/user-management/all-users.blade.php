<div class="all-content" x-data="data">

    @include('livewire.admin.delete-confirm-modal')
    @include('admin.import-modal', ['data' => 'user'])
    @include('admin.add-modal', ['data' => 'admin'])
    @include('admin.edit-modal', ['data' => 'user'])

    <div class="px-1 mb-3 d-flex justify-content-end">
        <a data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-blue btn-sm" role="button">
            <i class="fas fa-file-import me-1"></i>
            Import Excel
        </a>

        <a data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-blue btn-sm ms-2" role="button">
            <i class="fa fa-sm fa-plus"></i>
            Thêm admin
        </a>
    </div>

    <div class="px-1 mb-3 d-flex align-items-center">
        <div><label for="per-page" class="me-1">Hiển thị</label></div>
        <div class="me-auto">
            <select wire:model.live="perPage" id="per-page" class="form-select form-select-sm">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
            </select>
        </div>

        @if ($checkedRecords)
            <div class="btn-group me-1">
                <button type="button" class="btn btn-blue btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Hành động
                </button>
                <ul class="dropdown-menu w-auto">
                    <li>
                        <a data-bs-toggle="modal" data-bs-target="#delete-modal" class="dropdown-item">
                            <i class="fa fa-trash me-2"></i>
                            Xóa
                        </a>
                    </li>
                    <li>
                        <a wire:click.prevent="export" class="dropdown-item">
                            <i class="fas fa-file-excel me-2"></i>
                            Export Excel
                        </a>
                    </li>
                </ul>
            </div>
        @endif

        <div class="me-1">
            <button x-on:click="filter" type="button" class="btn btn-blue btn-sm">
                <i class="fa-solid fa-sm" :class="open ? 'fa-filter-circle-xmark' : 'fa-filter'"></i>
                Lọc
            </button>
        </div>

        <div class="position-relative">
            <input wire:model.live.debounce.200ms="search" type="search" class="form-control form-control-sm"
                placeholder="Tìm kiếm">
            <button class="btn btn-sm btn-blue pointer-none position-absolute top-0 end-0">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    @if ($checkedRecords)
        <div class="px-1 mb-3">
            Bạn đã chọn <b x-text="$wire.checkedRecords.length"></b> user.
            @if ($checkedPageRecords && $this->users->count() != $this->users->total())
                Bạn có muốn chọn tất cả <b>{{ $this->users->total() }}</b> user đang được hiển thị trên tất cả các
                trang?
                <a wire:click.prevent="checkAllRecords">
                    <b>Chọn tất cả user.</b>
                </a>
            @endif
        </div>
    @endif

    <div class="table-responsive mb-1">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><input wire:model.live="checkedPageRecords" type="checkbox"
                            class="form-check-input form-check-input-sm"></th>
                    <th>STT</th>
                    <th wire:click="setSortBy('full_name')" class="text-nowrap">Họ và tên
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'full_name' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('email')" class="text-nowrap">Email
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'email' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('phone')" class="text-nowrap">Số điện thoại
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'phone' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('role')" class="text-nowrap">Vai trò
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'role' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('email_verified_at')" class="text-nowrap">Xác nhận email
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'email_verified_at' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('created_at')" class="text-nowrap">Tạo
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'created_at' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('updated_at')" class="text-nowrap">Cập nhật
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'updated_at' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('is_active')" class="text-nowrap">Trạng thái
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'is_active' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="table-content">
                <tr x-show="open" class="filter-row">
                    <td>
                        <i class="fa-solid fa-sm fa-filter text-primary"></i>
                    </td>
                    <td colspan="10">
                        <div class="d-flex align-items-center">
                            <select wire:model.live="filterRole" class="form-select form-select-sm me-2 w-auto">
                                <option value="">Tất cả vai trò</option>
                                @foreach ($this->roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="filterStatus" class="form-select form-select-sm me-2 w-auto">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                            <label for="startDate">Tạo từ</label>
                            <input wire:model="createdFrom" id="startDate" type="date"
                                class="form-control form-control-sm mx-1 w-auto" />
                            <label for="endDate">đến</label>
                            <input wire:model="createdTo" id="endDate" type="date"
                                class="form-control form-control-sm mx-1 w-auto" />
                        </div>
                    </td>
                </tr>

                @foreach ($this->users as $key => $user)
                    <tr wire:key="row-{{ $user->id }}" @class(['table-primary' => $this->isChecked($user->id)])>
                        <td>
                            <input wire:model.live="checkedRecords" type="checkbox"
                                class="form-check-input form-check-input-sm" value="{{ $user->id }}">
                        </td>
                        <td>{{ $key + $this->users->firstItem() }}</td>
                        <td class="text-start text-nowrap">
                            <img src="{{ $user->avatar_url }}" class="rounded-circle img-table me-2">
                            {{ $user->full_name }}
                        </td>
                        <td class="text-start">{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <i class="fa {{ $user->email_verified_at ? 'fa-check text-success' : 'fa-ban text-danger' }}"
                                data-bs-toggle="tooltip"
                                title="{{ $user->email_verified_at ? 'Email đã xác nhận' : 'Email chưa được xác nhận' }}">
                            </i>
                        </td>
                        <td>{{ $user->created_time }}</td>
                        <td>{{ $user->updated_time }}</td>

                        <td>
                            @can('update', $user)
                                <a wire:click.prevent="changeStatus({{ $user->id }})" data-bs-toggle="tooltip"
                                    title="Ẩn/hiện user">
                                    <i
                                        class="fas fa-lg {{ $user->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}">
                                    </i>
                                </a>
                            @else
                                <i
                                    class="fas fa-lg {{ $user->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}">
                                </i>
                            @endcan
                        </td>
                        <td>
                            @if (Auth::user()->id !== $user->id)
                                @can('update', $user)
                                    <a wire:click="$dispatch('edit-user', { id: {{ $user->id }} })"
                                        data-bs-toggle="tooltip" title="Cập nhật user">
                                        <i data-bs-toggle="modal" data-bs-target="#edit-modal"
                                            class="fas fa-pencil fa-sm text-primary"></i>
                                    </a>

                                    <a x-on:click="$wire.deletedId = {{ $user->id }}" data-bs-toggle="tooltip"
                                        title="Xóa user">
                                        <i data-bs-toggle="modal" data-bs-target="#delete-modal"
                                            class="fa fa-times fa-lg text-danger"></i>
                                    </a>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row align-content-start">
        <div class="col-4 col-sm-3 col-md-4 col-lg-4 col-xl-4">
            <small>Hiển thị {{ $this->users->count() }} user trong số {{ $this->users->total() }} user.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $this->users->links() }}
            </ul>
        </div>
    </div>
</div>
