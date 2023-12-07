<div>
    @include('livewire.admin.import-modal', ['data' => 'địa điểm'])

    <div class="px-1 mb-4 d-flex align-items-center">
        <a href="{{ url('all-location') }}" class="btn btn-blue btn-sm" role="button">
            <i class="fa-solid fa-sm fa-list"></i>
            Danh sách địa điểm
        </a>

        <a data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-blue btn-sm ms-2" role="button">
            <i class="fas fa-file-import me-1"></i>
            Import Excel
        </a>
    </div>

    <form wire:submit="save" enctype="multipart/form-data">

        <div class="row">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">
                Địa điểm<span>*</span>
            </label>
            <div class="col-8 col-sm-8 col-md-9 col-lg-9 col-xl-9">
                <input wire:model="name" type="text" class="form-control form-control-sm" autofocus>
            </div>
        </div>

        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">Vùng miền</label>
            <div class="col-5 col-sm-3 col-md-2">
                <select wire:model="regionId" class="form-select form-select-sm">
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
                    <input wire:model="isActive" type="checkbox" class="form-check-input" role="switch">
                    <label class="form-check-label">Hiển thị</label>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div wire:loading wire:target="save" class="col offset-3 offset-sm-3 offset-md-2 offset-lg-2 offset-xl-2">
                <p class="text-loading">
                    <i class="fa fa-spinner fa-spin fa-2x me-2" aria-hidden="true"></i>
                    Đang thực hiện yêu cầu. Vui lòng đợi một lát...
                </p>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col offset-3 offset-sm-3 offset-md-2 offset-lg-2 offset-xl-2">
                <button id="save-review" type="submit" class="btn btn-sm btn-blue px-3">Lưu</button>
                <button wire:click="clear" id="clear-review" type="button"
                    class="btn btn-sm btn-red px-3 ms-2">Hủy</button>
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
                $('#clear-review').on('click', function() {
                    editor.setData('');
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
