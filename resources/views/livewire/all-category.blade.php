<div>
    <div class="row px-1 mb-4">
        <div class="col col-3">
            @if (count($checkedRecords) != 0)
                <button onclick="return confirm('Bạn chắc chắn muốn xóa các danh mục này?') || event.stopImmediatePropagation()"
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
                    <th>Tên danh mục</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="table-content">
                @csrf
                @foreach ($all_category as $key => $category)
                    <tr>
                        <th>
                            <input
                                class="form-check-input form-check-input-sm"
                                type="checkbox"
                                wire:model.live="checkedRecords"
                                value="{{ $category->id }}"
                            >
                        </th>
                        <td>{{ ++$key }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <button class="bg-transparent border-0" wire:click="changeStatus({{ $category->id }})">
                                @if ($category->status == 1)
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                @endif
                            </button>
                        </td>
                        <td>
                            <a href="edit-category/{{ $category->id }}" data-bs-toggle="tooltip" title="Cập nhật category">
                                <i class="fas fa-pencil fa-sm"></i>
                            </a>
                            <button onclick="return confirm('Bạn chắc chắn muốn xóa các danh mục này?') || event.stopImmediatePropagation()" type="button" class="btn" wire:click="deleteRecord({{ $category->id }})" data-bs-toggle="tooltip" title="Xóa location">
                                <i class="fa fa-times fa-lg text-danger"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-2">
        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
            <small>Hiển thị {{ $all_category->count() }} danh mục trong số {{ $all_category->total() }} danh mục.</small>
        </div>
        <div class="col">
            <ul class="pagination pagination-sm justify-content-end">
                {{ $all_category->links() }}
            </ul>
        </div>
    </div>
</div>
