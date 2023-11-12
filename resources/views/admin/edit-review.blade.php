@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $review->title }}</h4>
        </div>

        <div class="card-body">
            <form action="/update-review/{{ $review->id  }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mt-3">
                    <label for="title" class="col-3 col-form-label">Tiêu đề</label>
                    <div class="col-8">
                        <input id="title" name="title" type="text" value="{{ $review->title }}" required="required" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label class="col-3 col-form-label" for="">Slug</label>
                    <div class="col-8">
                        <input disabled value="{{ $review->slug }}" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="textarea" class="col-3 col-form-label">Mô tả tóm tắt</label>
                    <div class="col-8">
                        <textarea id="textarea" name="desc" cols="40" rows="3" class="form-control">{{ $review->desc }}</textarea>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="textarea" class="col-3 col-form-label">Nội dung</label>
                    <div class="col-8">
                        <textarea name="content" id="default-editor">
                            {{ $review->content }}
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="category" class="col-4 col-form-label">Thể loại</label>
                    <div class="col-8">
                        <select id="category" name="category_id" class="custom-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id == $review->category->id) selected @endif >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="location" class="col-4 col-form-label">Địa điểm</label>
                    <div class="col-8">
                        <select id="location" name="location_id" class="custom-select">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" @if ($location->id == $review->location->id) selected @endif >{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col offset-4 offset-sm-4 offset-md-4 offset-lg-4">
                        <img src="images/user/no_avatar_admin.png" class="rounded-circle img-upload-avatar admin" id="img-holder">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-4 col-form-label">Hình ảnh</label>
                    <div class="col-8">
                        <input id="image" type="file" class="form-control form-control-sm" name="file" accept=".jpg,.jpeg,.png,.gif" onchange="chooseImage(this)" />
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="offset-4 col-8">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection