<div wire:ignore.self class="modal fade" id="import-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title text-uppercase fw-bold text-light fs-5" id="importModalLabel">Import dữ liệu {{ $data }}</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                @livewire('admin.import', ['table' => $data])
        </div>
    </div>
</div>