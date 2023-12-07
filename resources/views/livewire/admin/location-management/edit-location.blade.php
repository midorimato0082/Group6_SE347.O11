<div>
    <div class="px-1 mb-4 d-flex align-items-center">
        <a href="{{ url('all-locations') }}" class="btn btn-blue btn-sm" role="button">
            <i class="fa-solid fa-sm fa-list"></i>
            Danh sách địa điểm
        </a>

        <a href="{{ url('add-location') }}" class="btn btn-blue btn-sm ms-1" role="button">
            <i class="fa fa-sm fa-plus"></i>
            Thêm địa điểm mới
        </a>
    </div>

    <form wire:submit="update" enctype="multipart/form-data">

        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">Vùng miền</label>
            <div class="col-5 col-sm-3 col-md-2">
                <select wire:model="region_id" class="form-select form-select-sm">
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col offset-3 offset-sm-3 offset-md-2 offset-lg-2 offset-xl-2 d-flex">
                Ẩn
                <div class="form-switch form-check ms-2">
                    <input wire:model="is_active" type="checkbox" class="form-check-input" role="switch">
                    <label class="form-check-label">Hiển thị</label>
                </div>

            </div>
        </div>

        <div class="row mt-3">
            <div wire:loading wire:target="update" class="col offset-3 offset-sm-3 offset-md-2 offset-lg-2 offset-xl-2">
                <p class="text-loading">
                    <i class="fa fa-spinner fa-spin fa-2x me-2" aria-hidden="true"></i>
                    Đang thực hiện yêu cầu. Vui lòng đợi một lát...
                </p>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col offset-3 offset-sm-3 offset-md-2 offset-lg-2 offset-xl-2">
                <button id="save-review" type="submit" class="btn btn-sm btn-blue px-3">Lưu</button>
                <button wire:click="clear" id="clear-edit" type="button" class="btn btn-sm btn-red px-3 ms-2">Hủy</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                removePlugins: ["MediaEmbedToolbar"]
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                })
                $(document).bind('clear-content', function(e) {
                    editor.setData(@this.content);
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
