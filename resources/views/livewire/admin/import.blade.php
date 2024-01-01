<div>
    <form wire:submit.prevent="import">
        <div class="modal-body text-center mt-2">
            <input wire:model="file" id="file-{{ $id }}" type="file" accept=".xlsx,.xls"
                class="form-control form-control-sm @error('file') is-invalid @enderror">
            @error('file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            @if ($failures)
                @foreach ($failures as $failure)
                    <p class="error text-start mt-3">{{ $failure }}</p>
                @endforeach
            @endif
        </div>
        <div class="modal-footer mt-2">
            <button wire:click="closeModal" type="button" class="btn btn-red btn-sm" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-blue btn-sm">Import</button>
        </div>
    </form>
</div>
