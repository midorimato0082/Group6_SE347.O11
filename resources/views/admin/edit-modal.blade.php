<div wire:ignore.self class="modal fade" id="edit-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title text-uppercase fw-bold text-light fs-5" id="editModalLabel">
                    Cập nhật {{ $data }}
                </h5>
            </div>

            @switch($data)
                @case('địa điểm')
                    <livewire:admin.place-management.edit-place @updated="$refresh" />
                @break

                @case('user')
                    <livewire:admin.user-management.edit-user @updated="$refresh" />
                @break

                @case('danh mục')
                    <livewire:admin.category-management.edit-category @updated="$refresh" />
                @break

                @default
            @endswitch
        </div>
    </div>
</div>
