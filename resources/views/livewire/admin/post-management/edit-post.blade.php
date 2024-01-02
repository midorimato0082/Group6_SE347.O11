<div>
    @include('admin.add-modal', ['data' => 'địa điểm'])

    <div class="px-1 mb-4 d-flex align-items-center">
        <a href="{{ url('all-posts') }}" class="btn btn-blue btn-sm" role="button">
            <i class="fa-solid fa-sm fa-list"></i>
            Danh sách bài viết
        </a>

        <a href="{{ url('add-post') }}" class="btn btn-blue btn-sm ms-1" role="button">
            <i class="fa fa-sm fa-plus"></i>
            Thêm bài viết mới
        </a>

        <a href="{{ route('post', $post->slug) }}" class="btn btn-blue btn-sm ms-auto" role="button">
            <i class="fa fa-sm fa-eye"></i>
            Xem bài viết ở trang chính
        </a>
    </div>

    <form wire:submit="update" enctype="multipart/form-data">
        <div class="row">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">
                Tiêu đề<span>*</span>
            </label>
            <div class="col-8 col-sm-8 col-md-9 col-lg-9 col-xl-9">
                <input wire:model.blur="title" type="text"
                    class="form-control form-control-sm @error('title') is-invalid @enderror" autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">
                Mô tả tóm tắt
            </label>
            <div class="col-8 col-sm-8 col-md-9 col-lg-9 col-xl-9">
                <textarea wire:model="desc" rows="3" class="form-control form-control-sm"></textarea>
            </div>
        </div>

        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">
                Nội dung
            </label>
            <div wire:ignore class="col-8 col-sm-8 col-md-9 col-lg-9 col-xl-9">
                <textarea id="editor" class="form-control form-control-sm">
                    <span>{!! $content !!}</span>                  
                </textarea>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col offset-3 offset-sm-3 offset-md-2 offset-lg-2 offset-xl-2 d-flex">
                @if ($newImages)
                    @foreach ($newImages as $key => $image)
                        <img src="{{ $image->temporaryUrl() }}" class="rounded-2 img-upload">
                        <a wire:click.prevent="removeNewImage({{ $key }})" data-bs-toggle="tooltip"
                            title="Xóa ảnh"><i class="fa fa-times text-danger fw-bold mx-2"></i></a>
                    @endforeach
                @else
                    @forelse ($this->oldImages as $key => $image)
                        <img src="{{ $image->url }}" class="rounded-2 img-upload" alt="{{ $post->title }}">
                        <a wire:click.prevent="removeOldImage({{ $key }})" data-bs-toggle="tooltip"
                            title="Xóa ảnh"><i class="fa fa-times text-danger fw-bold mx-2"></i></a>
                    @empty
                        <img src="{{ asset('images/others/no-image.jpg') }}" class="rounded-2 img-upload"
                            alt="{{ $post->title }}">
                    @endforelse
                    @if ($deletedImages)
                        <a wire:click.prevent="restoreOldImages" data-bs-toggle="tooltip" title="Khôi phục lại">
                            <i class="fa-solid fa-arrow-rotate-left fw-bold mx-2"></i></a>
                    @endif
                @endif
            </div>
        </div>


        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">Hình ảnh</label>
            <div class="col-6 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                <input wire:model="newImages" id="file-{{ $fileId }}" type="file" multiple
                    accept=".png,.jpeg,.jpg"
                    class="form-control form-control-sm @error('newImages.*') is-invalid @enderror">
                @error('newImages.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">Tags</label>
            <div wire:ignore class="col-8 col-sm-8 col-md-9 col-lg-9 col-xl-9">
                <input type="text" data-role="tagsinput" class="form-control" value="{!! $tags !!}">
            </div>
        </div>

        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">Danh mục</label>
            <div class="col-5 col-sm-3 col-md-2">
                <select wire:model.live="category_id" class="form-select form-select-sm" id="category-edit-post">
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <label class="col-form-label col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 text-end">Chọn địa điểm</label>
            <div wire:ignore class="col">
                <select wire:model="placeIds" multiple id="place-dropdown">
                    @if ($this->places)
                        @foreach ($this->places as $place)
                            <option value="{{ $place->id }}">{{ $place->name }}</option>
                        @endforeach
                    @endif
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
                <button id="save-post" type="submit" class="btn btn-sm btn-blue px-3">Lưu</button>
                <button wire:click="clear" type="button" class="btn btn-sm btn-red px-3 ms-2">Hủy</button>
            </div>
        </div>
    </form>

    <div id="app">
        <chat-bot></chat-bot>
    </div>
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
