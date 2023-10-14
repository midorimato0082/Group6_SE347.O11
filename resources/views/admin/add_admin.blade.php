@extends('templates.admin')

@section('content')
    <form action="save-admin" method="post" enctype="multipart/form-data">
        <div class="row mb-2 align-items-center">
            <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Họ <span>*</span></label>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <input type="text" class="form-control form-control-sm" name="last_name" required />
            </div>
        </div>
        <div class="row mb-2 align-items-center">
            <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Tên <span>*</span></label>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3">
                <input type="text" class="form-control form-control-sm" name="first_name" required />
            </div>
        </div>
        <div class="row mb-2 align-items-center">
            <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Email <span>*</span></label>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <input type="text" class="form-control form-control-sm" name="email" required />
            </div>
        </div>
        <div class="row mb-2 align-items-center">
            <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Số điện thoại <span>*</span></label>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <input type="text" class="form-control form-control-sm" name="phone" required />
            </div>
        </div>
        <div class="row mb-2 align-items-center">
            <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Mật khẩu <span>*</span></label>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <input type="password" class="form-control form-control-sm" name="password" required />
            </div>
        </div>
        <div class="row">
            <div class="col offset-4 offset-sm-4 offset-md-4 offset-lg-4">
                <img src="images/user/no_avatar_admin.png" class="rounded-circle img-upload-avatar admin" id="img-holder">
            </div>
        </div>
        <div class="row align-items-center">
            <label class="col-form-label col-4 col-sm-4 col-md-4 col-lg-4 text-end">Hình đại diện </label>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <input id="avatar" type="file" class="form-control form-control-sm" name="avatar" accept=".jpg,.jpeg,.png,.gif" onchange="chooseImage(this)" />
            </div>
        </div>
        <div class="row mt-3">
            <div class="col offset-4 offset-sm-4 offset-md-4 offset-lg-4">
                <button type="submit" class="btn btn-sm btn-blue">Lưu</button>
            </div>
        </div>
    </form>
@endsection
