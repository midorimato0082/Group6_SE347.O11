<div wire:ignore.self class="modal fade" id="add-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title text-uppercase fw-bold text-light fs-5" id="addModalLabel">
                    Thêm {{ $data }}
                </h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            @switch($data)
                @case('địa điểm')
                    <livewire:admin.place-management.add-place @saved="$refresh" />
                @break

                @case('admin')
                    <livewire:admin.user-management.add-admin @saved="$refresh" />
                @break

                @case('danh mục')
                    <livewire:admin.category-management.add-category @saved="$refresh" />
                @break

                @default
            @endswitch

        </div>
    </div>
</div>
