@extends('admin.layout.master3')

@section('title')
Thêm tài khoản
@endsection

@section('page')

@endsection

@section('name-content')

@endsection

@section('breadcrumb')
<span style="color: #FF9138">Thông tin cá nhân</span>
@endsection




@section('content')


<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-add-user">
            <div style=" padding-right:90px;" class="row pb-2">
                <div style="border-radius: 15px;" class="col-lg-12 bg-white shadow">
                    <!-- <div class="row pt-4 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div style="font-weight: bold;color:#FF7506;" class="h5">Thông tin tài khoản</div>
                            <div class="alert alert-success" role="alert">
                                This is a success alert—check it out!
                            </div>
                            <div class="alert alert-danger" role="alert">
                                This is a danger alert—check it out!
                            </div>
                        </div>

                    </div> -->
                    <div class="row pt-2 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3 p-4 text-center">
                                    <div class="box-image-avatar">
                                        <img src="<?php

                                                    use Illuminate\Support\Facades\Auth;

                                                    echo asset('backend/layout/img/' . Auth::guard('web')->user()->avt) ?>" alt="" width="100%" height="100%">
                                    </div>
                                    <span id="box-icon-change-avatar"><input type="file" name="myFile" id="myFile"><label for="myFile"><i class="fas fa-camera"></i></label></span>

                                    <div style="font-weight: bold;color:#282739;" class="h5 mt-4">{{ Auth::guard('web')->user()->fullname }}</div>
                                    <div id="box-all-form-change-avt">
                                     
                                            <input type="hidden" id="myFile_hidden" name="code_base" value="">
                                            <button style="background:#FF9138 ;border:none;" type="button" class="btn btn-primary btn-change-avatar">Lưu đổi ảnh</button>
                                          
                                    </div>
                                    
                                    <button onclick="window.location.reload()"  type="button" class="btn btn-success btn-refresh-change-avt mt-2"><i class="	fas fa-redo"></i> Làm mới</button>
                                </div>
                                <div class="col-lg-9">
                                    <form>
                                        <div class="row pt-4 pb-4">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Tên người dùng</label>
                                                    <input type="text" class="form-control" value="{{ Auth::guard('web')->user()->fullname }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập họ tên" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Số điện thoại</label>
                                                    <input type="text" value="{{ Auth::guard('web')->user()->phone }}" class="form-control" id="exampleInputPassword1" placeholder="Nhập tên số điện thoại" autocomplete="off" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Email</label>
                                                    <input type="text" class="form-control" value="{{ Auth::guard('web')->user()->email }}" id="exampleInputPassword1" placeholder="Nhập Email" disabled>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Tên đăng nhập</label>
                                                    <input type="text" class="form-control" value="{{ Auth::guard('web')->user()->name }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tên đăng nhập" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Mật khẩu</label>
                                                    <input type="text" class="form-control" value="{{ Auth::guard('web')->user()->password_2 }}" id="exampleInputPassword1" placeholder="Nhập mật khẩu" disabled>

                                                </div>
                                                <div class="form-group">
                                                    <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Vai trò</label>
                                                    <input type="text" class="form-control" value="{{ Auth::guard('web')->user()->roles->nameRole }}" id="exampleInputPassword1" placeholder="Nhập lại mật khẩu" disabled>

                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="box_crop_image_avatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Chỉnh sửa kích thước ảnh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image_avatar" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="crop" class="btn btn-primary">Lưu cắt ảnh</button>
            </div>
        </div>
    </div>
</div>
@endsection