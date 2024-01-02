<div class="all-content" x-data="data">

    @include('livewire.admin.delete-confirm-modal')
    @include('admin.import-modal', ['data' => 'địa điểm'])
    @include('admin.add-modal', ['data' => 'địa điểm'])
    @include('admin.edit-modal', ['data' => 'địa điểm'])

    <div class="px-1 mb-3 d-flex justify-content-end">
        <a data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-blue btn-sm" role="button">
            <i class="fas fa-file-import me-1"></i>
            Import Excel
        </a>

        <a data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-blue btn-sm ms-2" role="button">
            <i class="fa fa-sm fa-plus"></i>
            Thêm địa điểm
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
            Bạn đã chọn <b x-text="$wire.checkedRecords.length"></b> địa điểm.
            @if ($checkedPageRecords && $this->places->count() != $this->places->total())
                Bạn có muốn chọn tất cả <b>{{ $this->places->total() }}</b> địa điểm đang được hiển thị trên tất cả các trang?
                <a wire:click.prevent="checkAllRecords">
                    <b>Chọn tất cả địa điểm.</b>
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
                    <th wire:click="setSortBy('category')" class="text-nowrap">Danh mục
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'category' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('address')" class="text-nowrap">Địa chỉ
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'address' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('district')" class="text-nowrap">Quận huyện
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'district' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('province')" class="text-nowrap">Tỉnh thành
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'province' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('region')" class="text-nowrap">Vùng miền
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'region' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('min_price')" class="text-nowrap">Giá thấp nhất
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'min_price' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('max_price')" class="text-nowrap">Giá cao nhất
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'max_price' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('rating')" class="text-nowrap">Rating
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'rating' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('posts')" class="text-nowrap">Các bài viết
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'posts' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
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
                    <td colspan="15">
                        <div class="d-flex align-items-center">
                            <select wire:model.live="filterCategory" class="form-select form-select-sm me-2 w-auto">
                                <option value="">Tất cả danh mục</option>
                                @foreach ($this->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="filterRegion" class="form-select form-select-sm me-2 w-auto">
                                <option value="">Tất cả vùng</option>
                                @foreach ($this->regions as $region)
                                    <option value="{{ $region->name }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="filterRating" class="form-select form-select-sm me-2 w-auto">
                                <option value="">Tất cả rating</option>
                                <option value="1">1 sao trở lên</option>
                                <option value="2">2 sao trở lên</option>
                                <option value="3">3 sao trở lên</option>
                                <option value="4">4 sao trở lên</option>
                                <option value="5">5 sao trở lên</option>
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

                @foreach ($this->places as $key => $place)
                    <tr wire:key="row-{{ $place->id }}" @class(['table-primary' => $this->isChecked($place->id)])>
                        <td>
                            <input wire:model.live="checkedRecords" type="checkbox"
                                class="form-check-input form-check-input-sm" value="{{ $place->id }}">
                        </td>
                        <td>{{ $key + $this->places->firstItem() }}</td>
                        <td class="text-start">{{ $place->name }}</td>
                        <td>{{ $place->category->name }}</td>
                        <td class="text-start">{{ $place->address }}</td>
                        <td>{{ $place->district->name }}</td>
                        <td>{{ $place->district->province->name }}</td>
                        <td>{{ $place->district->province->region->name }}</td>
                        <td>{!! $place->lowest_price !!}</td>
                        <td>{!! $place->highest_price !!}</td>
                        <td>{{ $place->star }}</td>
                        <td class="text-start">{{ $place->posts_title }}</td>
                        <td>{{ $place->created_time }}</td>
                        <td>{{ $place->updated_time }}</td>

                        <td>
                            <a wire:click.prevent="changeStatus({{ $place->id }})" data-bs-toggle="tooltip"
                                title="Ẩn/hiện địa điểm">
                                <i class="fas fa-lg {{ $place->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}">
                                </i>
                            </a>
                        </td>
                        <td>
                            <a wire:click="$dispatch('edit-place', { id: {{ $place->id }} })" data-bs-toggle="tooltip"
                                title="Cập nhật địa điểm">
                                <i data-bs-toggle="modal" data-bs-target="#edit-modal" class="fas fa-pencil fa-sm text-primary"></i>
                            </a>

                            <a x-on:click="$wire.deletedId = {{ $place->id }}" data-bs-toggle="tooltip"
                                title="Xóa địa điểm">
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
            <small>Hiển thị {{ $this->places->count() }} địa điểm trong số {{ $this->places->total() }} địa điểm.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $this->places->links() }}
            </ul>
        </div>
    </div>

    <div wire:ignore id="app">
        <chat-bot></chat-bot>
    </div>
</div>
