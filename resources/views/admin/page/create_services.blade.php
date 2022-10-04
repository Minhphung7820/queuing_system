@extends('admin.layout.master3')

@section('title')
Danh sách dịch vụ
@endsection

@section('page')
Dịch vụ
@endsection

@section('name-content')
Quản lý dịch vụ
@endsection

@section('breadcrumb')
<i class="fas fa-angle-right"></i> Danh sách dịch vụ <i class="fas fa-angle-right"></i> <span style="color: #FF9138">Thêm dịch vụ</span>
@endsection




@section('content')


<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-create-services">
            <div style=" padding-right:10px;" class="row pb-2">
                <div style="border-radius: 15px;" class="col-lg-12 bg-white shadow">
                    <div class="row pt-4 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div style="font-weight: bold;color:#FF7506;" class="h5">Thông tin dịch vụ</div>
                            <div class="alert alert-success" role="alert">
                                This is a success alert—check it out!
                            </div>
                        </div>

                    </div>
                    <div class="row pt-2 pl-2 pr-2">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputEmail1">Mã dịch vụ <span style="color:#FF4747;">*</span></label>
                                <input type="text" class="form-control" name="codeServices" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập mã dịch vụ">
                                <div id="codeServices" class="invalid-feedback">

                                </div>
                            </div>
                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="exampleInputPassword1">Tên dịch vụ <span style="color:#FF4747;">*</span></label>
                                <input type="text" name="nameServices" class="form-control" id="exampleInputPassword1" placeholder="Nhập tên dịch vụ" autocomplete="off">
                                <div id="nameServices" class="invalid-feedback">

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label style="color: #282739;font-weight:bold;" for="">Mô tả:</label>
                                <textarea type="text" class="form-control" style="resize:none ;height:125px;" name="der" id="" placeholder="Mô tả dịch vụ"></textarea>
                                <div id="name" class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 pb-4">
                            <div style="font-weight: bold;color:#FF7506;" class="h5">Quy tắc cấp số</div>
                            <div class="custom-control custom-checkbox custom-qtcs-create">
                                <input type="checkbox" name="rule[]" value="auto" class="custom-control-input" id="customCheck1" name="example1">
                                <label style="color: #282739;font-weight:bold;" class="custom-control-label" for="customCheck1">Tăng tự động từ: &ensp; <span class="box-in-label">0001</span>&ensp; đến &ensp;<span class="box-in-label">9999</span></label>
                            </div>
                            <div class="custom-control custom-checkbox custom-qtcs-create">
                                <input type="checkbox" name="rule[]" value="prefix" class="custom-control-input" id="customCheck2" name="example1">
                                <label style="color: #282739;font-weight:bold;" class="custom-control-label" for="customCheck2">Prefix: &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp; <span class="box-in-label">0001</span></label>
                            </div>
                            <div class="custom-control custom-checkbox custom-qtcs-create">
                                <input type="checkbox" name="rule[]" value="suffix" class="custom-control-input" id="customCheck3" name="example1">
                                <label style="color: #282739;font-weight:bold;" class="custom-control-label" for="customCheck3">Suffix: &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp; <span class="box-in-label">0001</span></label>
                            </div>
                            <div class="custom-control custom-checkbox custom-qtcs-create">
                                <input type="checkbox" name="rule[]" value="reset" class="custom-control-input" id="customCheck4" name="example1">
                                <label style="color: #282739;font-weight:bold;" class="custom-control-label" for="customCheck4">Reset mỗi ngày</label>
                            </div>
                            <div class="form-group">
                                <label for=""><span style="color:#FF4747;font-weight:bold;">*</span> Là trường thông tin bắt buộc</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 m-auto text-center pt-4 pb-4">
                    <button onclick="history.back()" style="background-color: #FFF2E7;border:2px solid #FF9138;color:#FF9138;margin-right:25px;width:150px;height:40px;" type="button" class="btn btn-primary">Hủy bỏ</button>
                    <button style="background-color:#FF9138 ;color:#FFFFFF;border:none;width:150px;height:40px;" type="submit" class="btn btn-primary btn-add-device">Thêm dịch vụ</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection