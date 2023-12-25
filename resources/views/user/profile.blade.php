@extends('layouts.user')

@section('breadcrumn')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('content')
    <div class="container px-5">

        @livewire('user.profile.infor')

        <div class="row mt-5 page">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab1" data-bs-toggle="tab" data-bs-target="#tab1-pane"
                        type="button" role="tab" aria-controls="tab1-pane" aria-selected="true">
                        Bình luận
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab2" data-bs-toggle="tab" data-bs-target="#tab2-pane" type="button"
                        role="tab" aria-controls="tab2-pane" aria-selected="false">
                        Thích bình luận
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab3" data-bs-toggle="tab" data-bs-target="#tab3-pane" type="button"
                        role="tab" aria-controls="tab3-pane" aria-selected="false">
                        Thích bài viết
                    </button>
                </li>
            </ul>
        </div>

        <div class="row mt-4 tab-content">
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
        </div>
    </div>
@endsection
