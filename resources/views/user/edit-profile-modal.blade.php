<div class="modal fade modal-user" id="edit-profile-modal" tabindex="-1" aria-labelledby="editProfileModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold text-light" id="editProfileModal">
                    Chỉnh sửa hồ sơ cá nhân
                </h5>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <ul class="nav nav-pills flex-column nav-tabs nav-vertical-edit-profile" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-infor-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-infor" role="tab" aria-controls="pills-infor"
                                        aria-selected="true">
                                        Chỉnh sửa thông tin
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-pass-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-pass" role="tab" aria-controls="pills-pass"
                                        aria-selected="false">
                                        Thay đổi mật khẩu
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-8 mt-3">
                            <div class="tab-content mb-3">
                                <div class="tab-pane fade show active" id="pills-infor" role="tabpanel"
                                    aria-labelledby="pills-infor-tab" tabindex="0">
                                    <livewire:user.profile.update-infor :$user @updated="$refresh"/>
                                </div>

                                <div class="tab-pane fade" id="pills-pass" role="tabpanel"
                                    aria-labelledby="pills-pass-tab" tabindex="0">
                                    @livewire('user.profile.change-pass')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
