{{-- Kiến thức x-data, x-on, x-show, :class đến từ Alpine.js được tích hợp sẵn trong livewire3. Xử lý event viết trong main.js --}}
<div class="all-content" x-data="data">

    @include('livewire.admin.delete-confirm-modal')
    @include('livewire.admin.import-modal', ['data' => 'địa điểm'])

    <div class="px-1 mb-3 d-flex justify-content-end">
        <a data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-blue btn-sm" role="button">
            <i class="fas fa-file-import me-1"></i>
            Import Excel
        </a>

        <a href="{{ url('add-location') }}" class="btn btn-blue btn-sm ms-2" role="button">
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
            <button type="button" class="btn btn-blue btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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
            <input wire:model.live.debounce.200ms="search" type="search" class="form-control form-control-sm" placeholder="Tìm kiếm">
            <button class="btn btn-sm btn-blue pointer-none position-absolute top-0 end-0">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    @if ($checkedRecords)
    <div class="px-1 mb-3">
        Bạn đã chọn <b x-text="$wire.checkedRecords.length"></b> Địa điểm.
        @if ($checkedPageRecords && $locations->count() != $locations->total())
            Bạn có muốn chọn tất cả <b>{{ $locations->total() }}</b> Địa điểm đang được hiển thị trên tất cả các trang?
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
                    <th><input wire:model.live="checkedPageRecords" type="checkbox" class="form-check-input form-check-input-sm"></th>
                    <th>STT</th>
                    <th wire:click="setSortBy('name')" class="text-nowrap">Địa điểm
                        <i class="fas pointer fa-sm {{ $sortBy !== 'name' ? 'fa-sort' : ($sortDirection === 'ASC' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('region_id')" class="text-nowrap">Vùng
                        <i class="fas pointer fa-sm {{ $sortBy !== 'region_id' ? 'fa-sort' : ($sortDirection === 'ASC' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('created_at')" class="text-nowrap">Tạo
                        <i class="fas pointer fa-sm {{ $sortBy !== 'created_at' ? 'fa-sort' : ($sortDirection === 'ASC' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('updated_at')" class="text-nowrap">Cập nhật
                        <i class="fas pointer fa-sm {{ $sortBy !== 'updated_at' ? 'fa-sort' : ($sortDirection === 'ASC' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('is_active')" class="text-nowrap">Trạng thái
                        <i class="fas pointer fa-sm {{ $sortBy !== 'is_active' ? 'fa-sort' : ($sortDirection === 'ASC' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th style="width: 5.45%">Hành động</th>
                </tr>
            </thead>

            <tbody id="table-content">
                <tr x-show="open" class="filter-row">
                    <td>
                        <i class="fa-solid fa-sm fa-filter text-primary"></i>
                    </td>
                    <td colspan="17">
                        <div class="d-flex align-items-center">
                            <select wire:model.live="filterRegion" class="form-select form-select-sm me-2 w-auto">
                                <option value="">Tất cả vùng</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
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

                @foreach ($locations as $key => $location)
                    <tr wire:key="row-{{ $location->id }}" @class(['table-primary' => $this->isChecked($location->id)])>
                        <td>
                            <input wire:model.live="checkedRecords" type="checkbox" class="form-check-input form-check-input-sm" value="{{ $location->id }}">
                        </td>
                        <td>{{ $key + $locations->firstItem() }}</td>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->region->name }}</td>
                        <td>{{ $location->created_at }}</td>
                        <td>{{ $location->updated_at }}</td>
                        <td>
                            @can('update', $location)
                                <a wire:click.prevent="changeStatus({{ $location->id }})" data-bs-toggle="tooltip"
                                    title="Ẩn/hiện địa điểm">
                                    <i class="fas fa-lg {{ $location->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                                </a>
                            @endcan

                            @cannot('update', $location)
                                <i class="fas fa-lg {{ $location->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                            @endcannot
                        </td>
                        <td>
                            <a href="{{ route('location', $location->slug) }}" data-bs-toggle="tooltip" title="Chi tiết địa điểm">
                                <i class="fa-solid fa-eye text-success"></i>
                            </a>

                            @can('update', $location)
                            <a href="{{ route('edit.location', $location) }}" data-bs-toggle="tooltip" title="Cập nhật địa điểm">
                                <i class="fas fa-pencil fa-sm"></i>
                            </a>
                            @endcan

                            @can('delete', $location)
                            {{-- Kiến thức Livewire Alpine phần Controlling Livewire from Alpine using $wire, không gửi request đến server mãi đến khi nhấn nút ok --}}
                                <a x-on:click="$wire.deletedId = {{ $location->id }}" data-bs-toggle="tooltip" title="Xóa địa điểm">
                                    <i data-bs-toggle="modal" data-bs-target="#delete-modal" class="fa fa-times fa-lg text-danger"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row align-content-start">
        <div class="col-4 col-sm-3 col-md-4 col-lg-4 col-xl-4">
            <small>Hiển thị {{ $locations->count() }} địa điểm trong số {{ $locations->total() }} địa điểm.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $locations->links() }}
            </ul>
        </div>
    </div>
</div>
