<div class="all-content" x-data="data">
    
    @include('livewire.admin.delete-confirm-modal')
    @include('admin.import-modal', ['data' => 'bài viết'])

    <div class="px-1 mb-3 d-flex justify-content-end">
        <a data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-blue btn-sm" role="button">
            <i class="fas fa-file-import me-1"></i>
            Import Excel
        </a>

        <a href="{{ url('add-post') }}" class="btn btn-blue btn-sm ms-2" role="button">
            <i class="fa fa-sm fa-plus"></i>
            Thêm bài viết
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
        Bạn đã chọn <b x-text="$wire.checkedRecords.length"></b> bài viết.
        @if ($checkedPageRecords && $this->posts->count() != $this->posts->total())
            Bạn có muốn chọn tất cả <b>{{ $this->posts->total() }}</b> bài viết đang được hiển thị trên tất cả các trang?
            <a wire:click.prevent="checkAllRecords">
                <b>Chọn tất cả bài viết.</b>
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
                    <th wire:click="setSortBy('title')" class="text-nowrap">Tiêu đề
                        <i class="fas pointer fa-sm {{ $sortBy !== 'title' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th style="width:8%">Ảnh</th>
                    <th wire:click="setSortBy('desc')" class="text-nowrap">Mô tả
                        <i class="fas pointer fa-sm {{ $sortBy !== 'desc' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('tags')" class="text-nowrap">Tags
                        <i class="fas pointer fa-sm {{ $sortBy !== 'tags' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('category')" class="text-nowrap">Danh mục
                        <i class="fas pointer fa-sm {{ $sortBy !== 'category' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('places')" class="text-nowrap">Địa điểm review
                        <i class="fas pointer fa-sm {{ $sortBy !== 'places' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('admin')" class="text-nowrap">Tác giả
                        <i class="fas pointer fa-sm {{ $sortBy !== 'admin' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('created_at')" class="text-nowrap">Tạo
                        <i class="fas pointer fa-sm {{ $sortBy !== 'created_at' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('updated_at')" class="text-nowrap">Cập nhật
                        <i class="fas pointer fa-sm {{ $sortBy !== 'updated_at' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('view_count')" class="text-nowrap">Lượt xem
                        <i class="fas pointer fa-sm {{ $sortBy !== 'view_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('comments_count')" class="text-nowrap">Bình luận
                        <i class="fas pointer fa-sm {{ $sortBy !== 'comments_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('like_count')" class="text-nowrap">Like
                        <i class="fas pointer fa-sm {{ $sortBy !== 'like_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('dislike_count')" class="text-nowrap">Dislike
                        <i class="fas pointer fa-sm {{ $sortBy !== 'dislike_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('is_active')" class="text-nowrap">Trạng thái
                        <i class="fas pointer fa-sm {{ $sortBy !== 'is_active' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th style="width: 5.45%">Hành động</th>
                </tr>
            </thead>

            <tbody id="table-content">
                <tr x-show="open" class="filter-row">
                    <td>
                        <i class="fa-solid fa-sm fa-filter text-primary"></i>
                    </td>
                    <td colspan="16">
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
                            <select wire:model.live="filterAdmin" class="form-select form-select-sm me-2 w-auto">
                                <option value="">Tất cả tác giả</option>
                                @foreach ($this->admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->first_name }}</option>
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

                @foreach ($this->posts as $key => $post)
                    <tr wire:key="row-{{ $post->id }}" @class(['table-primary' => $this->isChecked($post->id)])>
                        <td>
                            <input wire:model.live="checkedRecords" type="checkbox" class="form-check-input form-check-input-sm" value="{{ $post->id }}">
                        </td>
                        <td>{{ $key + $this->posts->firstItem() }}</td>
                        <td class="text-start">{{ $post->title }}</td>
                        <td class="px-1">
                            @foreach ($post->getImagesUrl() as $imageUrl)
                                <img src="{{ $imageUrl }}" class="img-table pb-1" alt="{{ $post->title }}">
                            @endforeach
                        </td>
                        <td class="text-start">{{ str($post->desc)->words(10) }}</td>
                        <td class="text-start">{{ $post->tags }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td class="text-start">{{ $post->places_name }}</td>
                        <td>{{ $post->admin->first_name }}</td>
                        <td>{{ $post->created_time }}</td>
                        <td>{{ $post->updated_time }}</td>
                        <td>{{ $post->view_count }}</td>
                        <td>{{ $post->comments_count }}</td>
                        <td>{{ $post->like_count }}</td>
                        <td>{{ $post->dislike_count }}</td>
                        <td>
                            @can('update', $post)
                                <a wire:click.prevent="changeStatus({{ $post->id }})" data-bs-toggle="tooltip"
                                    title="Ẩn/hiện bài viết">
                                    <i class="fas fa-lg {{ $post->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                                </a>
                            @endcan

                            @cannot('update', $post)
                                <i class="fas fa-lg {{ $post->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                            @endcannot
                        </td>
                        <td>
                            <a href="{{ route('post', $post->slug) }}" data-bs-toggle="tooltip" title="Chi tiết bài viết">
                                <i class="fa-solid fa-eye text-success"></i>
                            </a>

                            @can('update', $post)
                            <a href="{{ route('edit.post', $post) }}" data-bs-toggle="tooltip" title="Cập nhật bài viết">
                                <i class="fas fa-pencil fa-sm"></i>
                            </a>
                            @endcan

                            @can('delete', $post)
                                <a x-on:click="$wire.deletedId = {{ $post->id }}" data-bs-toggle="tooltip" title="Xóa bài viết">                                    
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
            <small>Hiển thị {{ $this->posts->count() }} bài viết trong số {{ $this->posts->total() }} bài viết.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $this->posts->links() }}
            </ul>
        </div>
    </div>

    <div id="app">
        <chat-bot></chat-bot>
    </div>
</div>
