<div class="d-flex">
    @auth
        <div class="flex-shrink-0">
            <img class="rounded-circle shadow-1-strong" src="{{ Auth::user()->avatar_url }}" alt="Avatar Review Travel" width="60"
                height="60" />
        </div>
        <div class="flex-grow-1 ms-3">
            <form wire:submit="save">
                <textarea wire:model="newComment" id="new-comment" placeholder="Viết bình luận..."
                    class="form-control form-control-sm @error('comment') is-invalid @enderror" rows="4"></textarea>
                @error('comment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="mt-3">
                    <button type="submit" class="btn btn-orange btn-sm">
                        Đăng bình luận
                    </button>
                    <button wire:click="clear" type="button" class="btn btn-red btn-sm ms-1">Hủy</button>
                </div>
            </form>
        </div>
    @else
        <div class="flex-grow-1">
            <textarea class="form-control form-control-sm" rows="4" placeholder="Viết bình luận..."></textarea>
            <div class="mt-2">
                <a href="{{ route('login') }}" class="btn btn-orange btn-sm">Đăng nhập để bình
                    luận</a>
                <a href="{{ route('register') }}" class="btn btn-dark btn-sm ms-2">Đăng ký nếu chưa có tài
                    khoản</a>
            </div>
        </div>
    @endauth
</div>