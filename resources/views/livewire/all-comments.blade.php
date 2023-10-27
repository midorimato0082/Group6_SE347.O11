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
                <th class="th-sm">Khách hàng</th>
                <th>Bài viết</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
            </thead>

            <tbody id="table-content">
            @foreach ($comments as $key => $comment)
                <tr>
                    <th>
                        <input
                            class="form-check-input form-check-input-sm"
                            type="checkbox"
                            wire:model.live="checkedRecords"
                            value="{{ $comment->id }}"
                        >
                    </th>
                    <td>
                        {{ $key++ }}
                    </td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->review->title }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>
                        <button class="bg-transparent border-0" wire:click="changeStatus({{ $comment->id }})">
                            @if ($comment->is_active == 1)
                                <i class="fa-solid fa-eye"></i>
                            @else
                                <i class="fa-solid fa-eye-slash"></i>
                            @endif
                        </button>
                    </td>
                    <td>
                        <button onclick="return confirm('Bạn chắc chắn muốn xóa các bình luận này?') || event.stopImmediatePropagation()" type="button" class="btn btn-danger" wire:click="deleteRecord({{ $comment->id }})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $comments->links() }}
    </div>
</div>
