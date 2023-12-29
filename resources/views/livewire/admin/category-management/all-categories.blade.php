<div class="all-content">

    @include('livewire.admin.delete-confirm-modal')
    @include('admin.add-modal', ['data' => 'danh mục'])
    @include('admin.edit-modal', ['data' => 'danh mục'])

    <div class="px-1 mb-3 d-flex align-items-center justify-content-end">
        @if ($checkedRecords)
            <div class="me-1">
                <button type="button" class="btn btn-blue btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal">
                    <i class="fa fa-trash fa-sm me-1"></i>
                    Xoá
                </button>
            </div>
        @endif

        <div class="me-1">
            <a data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-blue btn-sm" role="button">
                <i class="fa fa-sm fa-plus"></i>
                Thêm danh mục
            </a>
        </div>

        <div class="position-relative">
            <input wire:model.live.debounce.200ms="search" type="search" class="form-control form-control-sm"
                placeholder="Tìm kiếm">
            <button class="btn btn-sm btn-blue pointer-none position-absolute top-0 end-0">
                <i class="fa fa-search"></i>
            </button>
        </div>
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

        <div class="me-2">
            <select class="form-select form-select-sm" wire:model.live="filterStatus">
                <option value="">Tất cả trạng thái</option>
                <option value="1">Danh mục đang hiển thị</option>
                <option value="0">Danh mục đã ẩn</option>
            </select>
        </div>

        <label for="startDate">Danh mục tạo từ</label>
        <input wire:model="createdFrom" id="startDate" type="date"
            class="form-control form-control-sm mx-1 w-auto" />
        <label for="endDate">đến</label>
        <input wire:model="createdTo" id="endDate" type="date" class="form-control form-control-sm w-auto ms-1" />
    </div>

    @if ($checkedRecords)
        <div class="px-1 mb-3">
            Bạn đã chọn <b x-text="$wire.checkedRecords.length"></b> danh mục.
            @if ($checkedPageRecords && $this->categories->count() != $this->categories->total())
                Bạn có muốn chọn tất cả <b>{{ $this->categories->total() }}</b> danh mục đang được hiển thị trên tất cả các
                trang?
                <a wire:click.prevent="checkAllRecords">
                    <b>Chọn tất cả danh mục.</b>
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
                    <th wire:click="setSortBy('name')" class="text-nowrap">Tên
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'name' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('posts_count')" class="text-nowrap">Số bài viết
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'posts_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('places_count')" class="text-nowrap">Số địa điểm
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'places_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
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
                @foreach ($this->categories as $key => $category)
                    <tr wire:key="row-{{ $category->id }}" @class(['table-primary' => $this->isChecked($category->id)])>
                        <td>
                            <input wire:model.live="checkedRecords" type="checkbox"
                                class="form-check-input form-check-input-sm" value="{{ $category->id }}">
                        </td>
                        <td>{{ $key + $this->categories->firstItem() }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->posts_count }}</td>
                        <td>
                            @if ($category->is_place)
                                {{ $category->places_count }}
                            @endif
                        </td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>
                            <a wire:click.prevent="changeStatus({{ $category->id }})" data-bs-toggle="tooltip"
                                title="Ẩn/hiện danh mục">
                                <i
                                    class="fas fa-lg {{ $category->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                            </a>
                        </td>
                        <td>
                            <a wire:click="$dispatch('edit-category', { id: {{ $category->id }} })"
                                data-bs-toggle="tooltip"
                                title="Cập nhật danh mục">
                                <i data-bs-toggle="modal" data-bs-target="#edit-modal" class="fas fa-pencil fa-sm text-primary"></i>
                            </a>

                            <a x-on:click="$wire.deletedId = {{ $category->id }}" data-bs-toggle="tooltip"
                                title="Xóa danh mục">
                                <i data-bs-toggle="modal" data-bs-target="#delete-modal"
                                    class="fa fa-times fa-lg text-danger"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row align-content-start">
        <div class="col-4 col-sm-3 col-md-4 col-lg-4 col-xl-4">
            <small>Hiển thị {{ $this->categories->count() }} danh mục trong số {{ $this->categories->total() }} danh mục.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $this->categories->links() }}
            </ul>
        </div>
    </div>
</div>
