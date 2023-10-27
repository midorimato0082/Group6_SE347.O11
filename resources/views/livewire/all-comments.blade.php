<div>
    @include('livewire.delete-confirm-modal')

    <div class="row px-1 my-4">
        <div class="col-4 col-sm-5 col-md-5 col-lg-6 col-xl-7">
            @if (count($checkedRecords) != 0)
                <button data-bs-toggle="modal" data-bs-target="#delete-modal" class="btn btn-sm btn-blue">Xóa
                    {{ count($checkedRecords) }} dòng được chọn</button>
            @endif
        </div>

        <div class="col-4 col-sm-4 col-md-3 col-lg-3 col-xl-2">
            <select class="form-select form-select-sm" wire:model="filter" wire:change="resetPageChecked">
                <option value="">Tất cả bình luận</option>
                <option value="review">Bình luận bài viết</option>
                <option value="news">Bình luận tin tức</option>
                <option value="1">Bình luận đang hiển thị</option>
                <option value="0">Bình luận đã ẩn</option>
            </select>
        </div>

        <div class="col position-relative">
            <input type="search" wire:model="keyword" wire:input="resetPageChecked"
                class="form-control form-control-sm searchbox" placeholder="Tìm kiếm...">
            <button class="btn btn-sm btn-blue search-icon position-absolute top-0" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    @if ($checkedPage && $comments->count() != $comments->total())
        <div class="px-1 mb-4">
            @if ($checkedAllRecords)
                Bạn đã chọn <strong>{{ $comments->total() - 1 }}</strong> bình luận.
            @else
                Bạn đã chọn <strong>{{ count($checkedRecords) }}</strong> bình luận. Bạn có muốn chọn tất cả
                <strong>{{ $comments->total() - 1 }}</strong> bình luận đang được hiển thị? <a href="#"
                    wire:click="checkAllRecords"><strong>Chọn tất cả user.</strong></a>
            @endif
        </div>
    @endif

    @include('includes.flash-message')

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><input class="form-check-input form-check-input-sm" type="checkbox"
                            wire:model.live="checkedPage"></th>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Bài viết/Tin tức</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="table-content">
                @foreach ($comments as $key => $comment)
                    <tr wire:key="row-{{ $comment->id }}"
                        class="@if ($this->isChecked($comment->id)) table-primary @endif">
                        <td>
                            <input class="form-check-input form-check-input-sm" type="checkbox"
                                wire:model.live="checkedRecords" value="{{ $comment->id }}">
                        </td>
                        <td>{{ $key + $comments->firstItem() }}</td>
                        <td>{{ $comment->user->first_name }}</td>
                        <td class="text-start">{{ str($comment->title)->words(5) }}</td>
                        <td class="text-start">{{ str($comment->content)->words(40) }}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td>
                            <a data-bs-toggle="tooltip" title="Ẩn/hiện bình luận" wire:click="changeStatus({{ $comment->id }})">
                                @if ($comment->status == 1)
                                    <i class="fa-solid fa-eye text-primary"></i>
                                @else
                                    <i class="fa-solid fa-eye-slash"></i>
                                @endif
                            </a>
                        </td>
                        <td>
                            @if (!$this->isChecked($comment->id))
                                <a data-bs-toggle="tooltip" title="Xóa bình luận">
                                    <i class="fa fa-times fa-lg text-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal"
                                        wire:click="set('commentId', {{ $comment->id }})">
                                    </i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-2">
        <div class="col-4 col-sm-3 col-md-4 col-lg-4 col-xl-4">
            <small>Hiển thị {{ $comments->count() }} bình luận trong số {{ $comments->total() }} bình luận.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $comments->links() }}
            </ul>
        </div>
    </div>
</div>
