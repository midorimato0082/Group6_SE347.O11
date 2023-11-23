<div wire:ignore.self class="modal fade" id="delete-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold text-light" id="deleteModalLabel">Xác nhận xóa dữ liệu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="delete">
                <div class="modal-body text-danger text-center">
                    <h4 class="fw-bold">Bạn chắc chắc muốn xóa dữ liệu này?</h4>
                    <i class="fas fa-trash fa-4x animated rotateIn mt-1"></i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-red" wire:click="closeModal"
                        data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-blue">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>