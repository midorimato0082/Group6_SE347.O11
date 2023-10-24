@extends('templates.admin')

@section('content')
<form action="save-admin" method="post" enctype="multipart/form-data">
    <div class="row mb-2 align-items-center">
        <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Tên danh mục <span>*</span></label>
        <div class="col-3 col-sm-3 col-md-3 col-lg-3">
            <input type="text" class="form-control form-control-sm" name="name" id="name" onkeyup="ChangeToSlug()" required />
        </div>
    </div>
    <div class="row mb-2 align-items-center">
        <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Slug</label>
        <div class="col-3 col-sm-3 col-md-3 col-lg-3">
            <input type="text" class="form-control form-control-sm" name="slug" id ="slug" disabled/>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col offset-4 offset-sm-4 offset-md-4 offset-lg-4">
            <input type="checkbox" name="check-box"> Kích hoạt
        </div>
    </div>
    <div class="row mt-3">
        <div class="col offset-4 offset-sm-4 offset-md-4 offset-lg-4">
            <button type="submit" class="btn btn-sm btn-blue">Cập nhật</button>
        </div>
    </div>
</form>
@endsection
