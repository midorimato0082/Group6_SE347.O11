@extends('layouts.admin')

@section('content')
    <div class="container px-5 mt-3">

        @livewire('admin.profile.infor')

        <div class="row mt-5 admin">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab1" data-bs-toggle="tab" data-bs-target="#tab1-pane"
                        type="button" role="tab" aria-controls="tab1-pane" aria-selected="true">
                        Bình luận của bạn
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab2" data-bs-toggle="tab" data-bs-target="#tab2-pane" type="button"
                        role="tab" aria-controls="tab2-pane" aria-selected="false">
                        Đã thích bình luận
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab3" data-bs-toggle="tab" data-bs-target="#tab3-pane" type="button"
                        role="tab" aria-controls="tab3-pane" aria-selected="false">
                        Đã thích bài viết
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab4" data-bs-toggle="tab" data-bs-target="#tab4-pane" type="button"
                        role="tab" aria-controls="tab4-pane" aria-selected="false">
                        Bài viết của bạn
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab5" data-bs-toggle="tab" data-bs-target="#tab5-pane" type="button"
                        role="tab" aria-controls="tab5-pane" aria-selected="false">
                        Bình luận về bài viết của bạn
                    </button>
                </li>
            </ul>
        </div>

        <div class="row my-4 tab-content">
            <div class="tab-pane fade show active tab-pane-scroll" id="tab1-pane" role="tabpanel" aria-labelledby="tab1"
                tabindex="0">
                @livewire('user.profile.tab1')
            </div>

            <div class="tab-pane fade tab-pane-scroll" id="tab2-pane" role="tabpanel" aria-labelledby="tab2" tabindex="0">
                @livewire('user.profile.tab2')
            </div>

            <div class="tab-pane fade tab-pane-scroll" id="tab3-pane" role="tabpanel" aria-labelledby="tab3" tabindex="0">
                @livewire('user.profile.tab3')
            </div>

            <div class="tab-pane fade tab-pane-scroll" id="tab4-pane" role="tabpanel" aria-labelledby="tab4" tabindex="0">
                @livewire('admin.profile.tab4')
            </div>

            <div class="tab-pane fade tab-pane-scroll" id="tab5-pane" role="tabpanel" aria-labelledby="tab5" tabindex="0">
                @livewire('admin.profile.tab5')
            </div>
        </div>
    </div>
@endsection