<div>
    <div class="row px-1 mb-4">
        <div class="col col-3">
            @if (count($checkedRecords) != 0)
                <button onclick="return confirm('Bạn chắc chắn muốn xóa các bình luận này?') || event.stopImmediatePropagation()"
                        wire:click="deleteRecords" class="btn btn-sm btn-blue">Xóa {{ count($checkedRecords) }}
                    dòng được chọn</button>
            @endif
        </div>
        <div class="col offset-3 col-6 search position-relative">
            <input type="search" wire:model="search" wire:input="searching" class="form-control form-control-sm searchbox" placeholder="Tìm kiếm...">
            <button class="btn btn-sm btn-blue search-icon position-absolute top-0" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>
                    <input class="form-check-input form-check-input-sm" type="checkbox" wire:change="checkAll" wire:model.live="checkedAllRecords">
                </th>
                <th>STT</th>
                <th class="th-sm">Tiêu đề</th>
                <th>Ảnh</th>
                <th>Mô tả ngắn</th>
                <th>Tags</th>
                <th>Danh mục</th>
                <th>Địa điểm</th>
                <th>Tác giả</th>
                <th>Số lượt xem</th>
                <th>Bình luận</th>
                <th>Lượt thích</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
            </thead>

            <tbody id="table-content">
            @foreach ($reviews as $key => $review)
                <tr>
                    <th>
                        <input
                            class="form-check-input form-check-input-sm"
                            type="checkbox"
                            wire:model.live="checkedRecords"
                            value="{{ $review->id }}"
                        >
                    </th>
                    <td>
                        {{ $key++ }}
                    </td>
                    <td>{{ $review->title }}</td>
                    <td>
                        <img src="images/reviews/{{ $review->images }}" class="image-card-dashboard img-fluid rounded-start" alt="{{ $review->title }}">
                    </td>
                    <td title="{{ $review->desc }}" class="truncate-text-3">{{ $review->desc }}</td>
                    <td>{{ $review->tags }}</td>
                    <td>{{ $review->category->name }}</td>
                    <td>{{ $review->location->name }}</td>
                    <td>{{ $review->admin->name }}</td>
                    <td>{{ $review->view_count }}</td>
                    <td>{{ $review->comment_count }}</td>
                    <td>{{ $review->like_count }}</td>
                    <td>
                        <button class="bg-transparent border-0" wire:click="changeStatus({{ $review->id }})">
                            @if ($review->is_active == 1)
                                <i class="fa-solid fa-eye"></i>
                            @else
                                <i class="fa-solid fa-eye-slash"></i>
                            @endif
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" wire:click="editRecord({{ $review->id }})">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button onclick="return confirm('Bạn chắc chắn muốn xóa các bình luận này?') || event.stopImmediatePropagation()" type="button" class="btn btn-danger" wire:click="deleteRecord({{ $review->id }})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $reviews->links() }}
    </div>
</div>
