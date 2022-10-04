@extends('admin.layout.master3')

@section('title')
Thông tin cấp số
@endsection

@section('page')
Cấp số
@endsection

@section('name-content')
Quản lý cấp số
@endsection

@section('breadcrumb')
<i class="fas fa-angle-right"></i> Danh sách cấp số <i class="fas fa-angle-right"></i> <span style="color: #FF9138">Chi tiết</span>
@endsection




@section('content')
<?php

use Carbon\Carbon;
?>

<div class="row">
    <div style="padding-top: 20px;padding-left:22px;" class="col-lg-12">
        <!-- Content Row -->
        <form id="form-create-devices">
            <div style=" padding-right:10px;" class="row pb-2">
                <div style="border-radius: 15px; min-height:520px;" class="col-lg-12 bg-white pb-4 mb-4 shadow">
                    <div class="row pt-4 pl-2 pr-2">
                        <div class="col-lg-12">
                            <div style="font-weight: bold;color:#FF7506;" class="h5">Thông tin cấp số</div>
                        </div>

                    </div>
                    <div class="row pt-2 pl-2 pr-2">
                        <div class="col-lg-6">
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Họ tên:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ $data->user->fullname }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Tên dịch vụ:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ $data->services->name }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Số thứ tự:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ $data->number }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Thời gian cấp:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ Carbon::parse($data->date_started)->hour.":".Carbon::parse($data->date_started)->minute." - ".Carbon::parse($data->date_started)->day."/".Carbon::parse($data->date_started)->month."/".Carbon::parse($data->date_started)->year }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Hạn sử dụng:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ Carbon::parse($data->date_end)->hour.":".Carbon::parse($data->date_end)->minute." - ".Carbon::parse($data->date_end)->day."/".Carbon::parse($data->date_end)->month."/".Carbon::parse($data->date_end)->year }}
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Nguồn cấp:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{$data->device->name}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Trạng thái:</div>
                                </div>
                                <div class="col-lg-9">
                                    @if($data->status == 1)
                                    <i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ
                                    @elseif($data->status == 2)
                                    <i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng
                                    @elseif($data->status == 3)
                                    <i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Số điện thoại:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{ $data->user->phone }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div style="color: #282739;font-weight:bold;" class="h6">Địa chỉ Email:</div>
                                </div>
                                <div class="col-lg-9">
                                    {{$data->user->email}}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>


@endsection