<div class="all-content">

    @include('livewire.admin.delete-confirm-modal')

    <div class="px-1 mb-3 d-flex align-items-center justify-content-end">
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
                <option value="1">Bình luận đang hiển thị</option>
                <option value="0">Bình luận đã ẩn</option>
            </select>
        </div>

        <label for="startDate">Bình luận tạo từ</label>
        <input wire:model="createdFrom" id="startDate" type="date"
            class="form-control form-control-sm mx-1 w-auto" />
        <label for="endDate">đến</label>
        <input wire:model="createdTo" id="endDate" type="date" class="form-control form-control-sm w-auto ms-1" />
    </div>

    @if ($checkedRecords)
        <div class="px-1 mb-3">
            Bạn đã chọn <b x-text="$wire.checkedRecords.length"></b> bình luận.
            @if ($checkedPageRecords && $this->comments->count() != $this->comments->total())
                Bạn có muốn chọn tất cả <b>{{ $this->comments->total() }}</b> bình luận đang được hiển thị trên tất cả các
                trang?
                <a wire:click.prevent="checkAllRecords">
                    <b>Chọn tất cả bình luận.</b>
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
                    <th wire:click="setSortBy('content')" class="text-nowrap">Nội dung
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'content' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('user')" class="text-nowrap">User
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'user' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('title')" class="text-nowrap">Bài viết
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'title' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('likes_count')" class="text-nowrap">Lượt thích
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'likes_count' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('replies')" class="text-nowrap">Lượt trả lời
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'replies' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('created_at')" class="text-nowrap">Tạo
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'created_at' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th wire:click="setSortBy('is_active')" class="text-nowrap">Trạng thái
                        <i
                            class="fas pointer fa-sm {{ $sortBy !== 'is_active' ? 'fa-sort' : ($sortDirection === 'asc' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt') }}"></i>
                    </th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="table-content">
                @foreach ($this->comments as $key => $comment)
                    <tr wire:key="row-{{ $comment->id }}" @class(['table-primary' => $this->isChecked($comment->id)])>
                        <td>
                            <input wire:model.live="checkedRecords" type="checkbox"
                                class="form-check-input form-check-input-sm" value="{{ $comment->id }}">
                        </td>
                        <td>{{ $key + $this->comments->firstItem() }}</td>
                        <td class="text-start">{{ str($comment->content)->words(20) }}</td>
                        <td data-bs-toggle="tooltip" title="{{ $comment->user->email }}">
                            {{ $comment->user->first_name }}</td>
                        <td class="text-start">{{ $comment->post->title }}</td>
                        <td>{{ $comment->likes_count }}</td>
                        <td>{{ $comment->replies_count }}</td>
                        <td>{{ $comment->created_time }}</td>
                        <td>
                            @can('update', $comment)
                                <a wire:click.prevent="changeStatus({{ $comment->id }})" data-bs-toggle="tooltip"
                                    title="Ẩn/hiện bài viết">
                                    <i
                                        class="fas fa-lg {{ $comment->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                                </a>
                            @endcan

                            @cannot('update', $comment)
                                <i
                                    class="fas fa-lg {{ $comment->is_active ? 'fa-toggle-on text-primary' : 'fa-toggle-off' }}"></i>
                            @endcannot
                        </td>
                        <td>
                            @if ($comment->post->slug)
                                <a href="{{ route('post', $comment->post->slug) }}" data-bs-toggle="tooltip"
                                    title="Chi tiết bình luận">
                                    <i class="fa-solid fa-eye text-success"></i>
                                </a>
                            @else
                                <i data-bs-toggle="tooltip" title="Bài viết đã bị xóa"
                                    class="fa-solid fa-eye-slash"></i>
                            @endif

                            @can('delete', $comment)
                                <a x-on:click="$wire.deletedId = {{ $comment->id }}" data-bs-toggle="tooltip"
                                    title="Xóa bình luận">
                                    <i data-bs-toggle="modal" data-bs-target="#delete-modal"
                                        class="fa fa-times fa-lg text-danger"></i>
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
            <small>Hiển thị {{ $this->comments->count() }} bình luận trong số {{ $this->comments->total() }} bình luận.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $this->comments->links() }}
            </ul>
        </div>
    </div>
</div>
