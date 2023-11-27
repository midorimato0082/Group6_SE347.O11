<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row bg-white p-3 border rounded-5 shadow">
            <div class="col m-auto" style="background-color: white">
                <div class="row ps-5 pe-5">
                    <h1 class="title text-wrap text-center mt-4 mb-3">ĐĂNG KÝ</h1>

                    <form id="register-form" action="register" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="form-outline mb-3">
                            <input type="text"
                                class="form-control bg-light rounded-2 col @error('last_name') is-invalid @enderror"
                                placeholder="Họ" name="last_name" value="{{ old('last_name') }}" autofocus required>
                            @error('last_name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <input type="text"
                                class="form-control bg-light rounded-2 col @error('first_name') is-invalid @enderror"
                                placeholder="Tên" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <input type="text"
                                class="form-control bg-light rounded-2 @error('email') is-invalid @enderror"
                                placeholder="Email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password"
                                class="form-control bg-light rounded-2 @error('password') is-invalid @enderror"
                                placeholder="Mật khẩu" name="password" required minlength="6" maxlength="12">
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password" class="form-control bg-light rounded-2"
                                placeholder="Nhập lại mật khẩu" name="password_confirmation" required>
                        </div>

                        <div class="form-outline mb-3 text-center">
                            <img src="images/user/no-avatar.png" class="rounded-circle img-upload-avatar mb-3"
                                id="img-holder">

                            <div class="input-group custom-file-btn">
                                <label class="input-group-text" for="avatar">Chọn avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar"
                                    accept=".jpg,.jpeg,.png,.gif" onchange="chooseImage(this)" />
                            </div>
                            <p id="error-avatar"></p>
                        </div>

                        <div class="mb-4">
                            <button id="register-btn" class="btn btn-orange w-100 fs-5 fw-bold shadow">Đăng ký</button>
                        </div>
                    </form>

                    <div class="row">
                        <p>Bạn đã có tài khoản đăng nhập? <a href="login">Hãy đăng nhập ở đây</a></p>
                    </div>

                </div>
            </div>

            <div class="col rounded-4 d-flex align-items-center justify-content-center">
                <img src="images/others/register-page.jpg" alt="Register" class="img-box rounded-5">
            </div>

        </div>
    </div>

    @include('includes.scripts')

</body>

</html>
