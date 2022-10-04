@extends('admin.layout.master3')

@section('title')
Nhật ký hoạt động
@endsection

@section('page')
Cài đặt hệ thống
@endsection


@section('name-content')

@endsection


@section('breadcrumb')
<i class="fas fa-angle-right"></i> <span style="color: #FF9138">Nhật ký hoạt động</span>
@endsection
@section('content')
<?php

use Carbon\Carbon;
?>

<div class="row">
    <div style="padding-top: 20px;" class="col-lg-12">




        <!-- Content Row -->
        <div style=" padding-right:10px;" class="row pb-2">
            <div class="col-lg-3">
                <div style="color: #282739;font-weight:bold;" class="h6">Chọn thời gian</div>
                <input onchange="filterTimeDiary()" class="choose-time-filter-diary" type="date" min="{{ now()->addDays(-7)->toDateString() }}" max="{{  now()->toDateString()}}" value="{{ $dateLimit }}" name="" id="date-time-begin-diary">
                <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.13346 2.46129L2.9735 1.75776L1.08342 0.611381C0.683023 0.372106 0 0.543527 0 0.886368V3.11126V5.11474C0 5.45758 0.683023 5.629 1.08342 5.38616L4.13346 3.53624C4.62218 3.2434 4.62218 2.75771 4.13346 2.46129Z" fill="#535261" />
                </svg>
                <input onchange="filterTimeDiary()" class="choose-time-filter-diary" type="date" min="" max="{{  now()->toDateString()}}" value="{{ now()->toDateString() }}" name="" id="date-time-end-diary">
            </div>
            <div class="col-lg-2">

            </div>
            <div class="col-lg-3">

            </div>
            <div style="padding-right:100px;" class="col-lg-4">
                <div style="color: #282739;font-weight:bold;" class="h6 text-left">Từ khóa</div>
                <!-- <form action="/admin/devices/all" method="get"> -->
                <div class="input-group mb-3">
                    <input onkeyup="keyupSearchDiary(this)" style="border-right: none;border-left:2px solid #D4D4D7;border-top:2px solid #D4D4D7;border-bottom:2px solid #D4D4D7;height:52px;" type="text" name="key" class="form-control input-keyup-search-devices" placeholder="Nhập từ khóa" id="input-search-history">
                    <div class="input-group-append">
                        <button type="submit" style="background:white ;border-top:2px solid #D4D4D7;border-bottom:2px solid #D4D4D7;border-right:2px solid #D4D4D7;" class="input-group-text" id="basic-addon2"><i style="color: #FF7506;" class="fas fa-search"></i></button>
                    </div>
                </div>
                <!-- </form> -->
            </div>
            <div style="background-color:#f6f6f6;padding-right:100px;" class="col-lg-12">
                <div class="table-responsive">
                    <table id="table-all-devices" class="table table-all-devices">
                        <thead>
                            <tr>
                                <th style="border-right: 1px solid white;">Tên đăng nhập</th>
                                <th style="border-right: 1px solid white;">Thời gian tác động</th>
                                <th style="border-right: 1px solid white;">IP thực hiện</th>
                                <th style="border-right: 1px solid white;">Thao tác thực hiện</th>

                            </tr>
                        </thead>
                        <tbody id="result-diary">
                            @if(count($all) > 0)
                            @foreach($all as $row)
                            <tr>
                                <td>{{ $row->nameLogin }}</td>
                                <td><?php echo Carbon::parse($row->Time)->format('d/m/y h:i:s') ?></td>
                                <td>{{ $row->ipAddress }}</td>
                                <td>{{ $row->action }}</td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="4">Không có dòng nào !</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6">

                    </div>
                    <div class="col-lg-6 pagination-all-diary">
                        {{$all->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection