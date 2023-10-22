<div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>
                    <input class="form-check-input form-check-input-sm" type="checkbox" wire:model.live="checkedPage">
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
                    <th><input class="form-check-input form-check-input-sm" type="checkbox"
                               wire:model.live="checkedPage"></th>
                    <td>
                        {{ $key++ }}
                    </td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->review->title }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>
                        @if ($comment->status == 1)
                            status 1
                        @else
                            status 2
                        @endif
                    </td>
                    <td>
                        Xoas
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
