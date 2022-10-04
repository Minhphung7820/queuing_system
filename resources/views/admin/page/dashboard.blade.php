@extends('admin.layout.master2')

@section('title')
Dashboard
@endsection

@section('content')








<!-- Topbar -->

<!-- End of Topbar -->

<!-- Begin Page Content -->
<div style="background-color:#f6f6f6;" class="container-fluid">

    <div class="row">
        <div style="padding-top:20px ;" class="col-lg-8">
            <h1 style="color: #FF9138;" class="h4 mb-2">Dashboard</h1>
            <br><br>

            <div style="color: #FF9138; font-weight:bold;" class="h5">Biểu đồ cấp số</div>

            <!-- Content Row -->
            <div style="padding-top:20px; padding-right:10px;" class="row pb-2">
                <div class="col-lg-3 col-sm-6 col-xs-12 pb-4">
                    <div style="border: none;border-radius:10px;" class="card shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span id="box-icon-number-required"><i class="	far fa-calendar"></i></span>

                                </div>
                                <div class="col-lg-8">
                                    <div style="color: #535261;font-weight:bold;" class="h6">Số thứ tự <br> đã cấp</div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-lg-7">
                                    <div style="color: #535261;font-weight:bold;" class="h3">{{ number_format($totalNumeber , 0, ',', '.') }}</div>
                                </div>
                                <div class="col-lg-5 p-0">
                                    @if($stt == 'Tăng')
                                    <span style="font-size: 12px;background:rgba(255, 149, 1, 0.15);color:#FF9138;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-up"></i> {{$ratio}} %</span>
                                    @elseif($stt == 'Giảm')
                                    <span style="font-size: 12px;background:rgba(231, 63, 63, 0.15);color:#E73F3F;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-down"></i> {{$ratio}} %</span>
                                    @elseif($stt == 'Bình thường')
                                    <span style="font-size: 12px;background:#e1f7e6;color:#35C75A;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrows-alt-v"></i> {{$ratio}} %</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12 pb-4">
                    <div style="border: none;border-radius:10px;" class="card shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span id="box-icon-number-used"> <i class="	far fa-calendar-check"></i></span>

                                </div>
                                <div class="col-lg-8">
                                    <div style="color: #535261;font-weight:bold;" class="h6">Số thứ tự <br> đã sử dụng</div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-lg-7">
                                    <div style="color: #535261;font-weight:bold;" class="h3">{{ number_format($totalNumberUsed , 0, ',', '.') }}</div>
                                </div>
                                <div class="col-lg-5 p-0">
                                    @if($stt_U == 'Tăng')
                                    <span style="font-size: 12px;background:rgba(255, 149, 1, 0.15);color:#FF9138;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-up"></i> {{$ratio_U}} %</span>
                                    @elseif($stt_U == 'Giảm')
                                    <span style="font-size: 12px;background:rgba(231, 63, 63, 0.15);color:#E73F3F;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-down"></i> {{$ratio_U}} %</span>
                                    @elseif($stt_U == 'Bình thường')
                                    <span style="font-size: 12px;background:#e1f7e6;color:#35C75A;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrows-alt-v"></i> {{$ratio_U}} %</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12 pb-4">
                    <div style="border: none;border-radius:10px;" class="card shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span id="box-icon-number-waiting"><i class="fas fa-user-clock"></i></span>
                                </div>
                                <div class="col-lg-8">
                                    <div style="color: #535261;font-weight:bold;" class="h6">Số thứ tự <br> đang chờ</div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-lg-7">
                                    <div style="color: #535261;font-weight:bold;" class="h3">{{ number_format($totalNumberWaiting , 0, ',', '.') }}</div>
                                </div>
                                <div class="col-lg-5 p-0">
                                    @if($stt_W == 'Tăng')
                                    <span style="font-size: 12px;background:rgba(255, 149, 1, 0.15);color:#FF9138;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-up"></i> {{$ratio_W}} %</span>
                                    @elseif($stt_W == 'Giảm')
                                    <span style="font-size: 12px;background:rgba(231, 63, 63, 0.15);color:#E73F3F;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-down"></i> {{$ratio_W}} %</span>
                                    @elseif($stt_W == 'Bình thường')
                                    <span style="font-size: 12px;background:#e1f7e6;color:#35C75A;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrows-alt-v"></i> {{$ratio_W}} %</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12 pb-4">
                    <div style="border: none;border-radius:10px;" class="card shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span id="box-icon-number-ignored"> <i class="fas fa-bookmark"></i></span>
                                </div>
                                <div class="col-lg-8">
                                    <div style="color: #535261;font-weight:bold;" class="h6">Số thứ tự <br> đã bỏ qua</div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-lg-7">
                                    <div style="color: #535261;font-weight:bold;" class="h3">{{ number_format($totalNumberBQ , 0, ',', '.') }}</div>
                                </div>
                                <div class="col-lg-5 p-0">
                                    @if($stt_BQ == 'Tăng')
                                    <span style="font-size: 12px;background:rgba(255, 149, 1, 0.15);color:#FF9138;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-up"></i> {{$ratio_BQ}} %</span>
                                    @elseif($stt_BQ == 'Giảm')
                                    <span style="font-size: 12px;background:rgba(231, 63, 63, 0.15);color:#E73F3F;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrow-down"></i> {{$ratio_BQ}} %</span>
                                    @elseif($stt_BQ == 'Bình thường')
                                    <span style="font-size: 12px;background:#e1f7e6;color:#35C75A;" id="box-up-dows-number"><i style="font-size: 12px;" class="fas fa-arrows-alt-v"></i> {{$ratio_BQ}} %</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div style="padding-right: 20px;padding-left:10px;" class="col-xl-12 col-lg-12">

                    <!-- Area Chart -->

                    <div style="border-radius:12px;overflow:hidden;" class="card shadow mb-4">
                        <div style="border: none;" class="bg-white card-header py-3">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div style="color: #282739;" class="h5 m-0 font-weight-bold">Bảng thống kê theo <span id="title-type-chart">ngày</span></div>
                                    <div id="title-time-chart" style="color: #A9A9B0;" class="h6 mt-2">Tháng {{ now()->month }}/{{ now()->year }}</div>
                                </div>
                                <div class=" col-lg-4">
                                    <div class="row">
                                        <div style="padding-top: 14px;" class="col-lg-6 text-right">
                                            <div style="color: #282739;font-weight: 600;font-size: 16px;" class="h6">Xem theo</div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="select-box-9">
                                                <div class="options-container_9 shadow">
                                                    <div class="option_9 option-type-time-chart">
                                                        <input type="radio" class="radio" value="date" id="view-chart-by-date" name="type-view-chart" checked />
                                                        <label for="view-chart-by-date">Ngày</label>
                                                    </div>
                                                    <div class="option_9 option-type-time-chart">
                                                        <input type="radio" class="radio" value="week" id="view-chart-by-week" name="type-view-chart" />
                                                        <label for="view-chart-by-week">Tuần</label>
                                                    </div>
                                                    <div class="option_9 option-type-time-chart">
                                                        <input type="radio" class="radio" value="month" id="view-chart-by-month" name="type-view-chart" />
                                                        <label for="view-chart-by-month">Tháng</label>
                                                    </div>
                                                </div>

                                                <div class="selected_9 result-select">
                                                    Ngày
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div style="height:450px ;" class="chart-area">
                                <canvas id="myAreaChartByDate"></canvas>
                                <canvas id="myAreaChartByWeek"></canvas>
                                <canvas id="myAreaChartByMonth"></canvas>
                            </div>
                            <!-- <div class="chart-area">
                                <canvas id="myAreaChartByWeek"></canvas>
                            </div>
                            <div class="chart-area">
                                <canvas id="myAreaChartByMonth"></canvas>
                            </div> -->
                            <!-- <hr>
                            Styling for the area chart can be found in the
                            <code>/js/demo/chart-area-demo.js</code> file. -->
                        </div>
                    </div>

                    <!-- Bar Chart -->
                    <!-- <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-bar">
                                                <canvas id="myBarChart"></canvas>
                                            </div>
                                            <hr>
                                            Styling for the bar chart can be found in the
                                            <code>/js/demo/chart-bar-demo.js</code> file.
                                        </div>
                                    </div> -->

                </div>

                <!-- Donut Chart -->
                <!-- <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                           
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Donut Chart</h6>
                                </div>
                        
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <hr>
                                    Styling for the donut chart can be found in the
                                    <code>/js/demo/chart-pie-demo.js</code> file.
                                </div>
                            </div>
                        </div> -->
            </div>


        </div>
        <div style="background-color: white;" class="col-lg-4 shadow">









            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top">
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>


                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i style="color: #FFAC6A;" class="fas fa-bell fa-fw"></i>

                            <!-- <span class="badge badge-danger badge-counter">3+</span> -->
                        </a>

                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 style="background:  #FF9138;border:none;" class="dropdown-header">
                                Thông báo
                            </h6>
                            <div class="box-all-notifi">
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Đang tải thông báo...</div>
                                        <!-- <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div> -->
                                    </div>
                                </a>
                                <!-- <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">

                                    <div>
                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: Nguyễn thị thùy dung</div>
                                        <div style="color: #535261;">Thời gian nhận số: 12h30 ngày 30/11/2021</div>
                                    </div>
                                </a> -->
                            </div>
                            <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
                        </div>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle" src="<?php

use Illuminate\Support\Facades\Auth;

 echo asset('backend/layout/img/'.Auth::guard('web')->user()->avt) ?>">

                            <span style="padding-left: 5px;" class="mr-2 d-none d-lg-inline text-gray-600 small"> Xin chào <br> <strong>{{ Auth::user()->fullname }}</strong> </span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="/my-account">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Tài khoản của tôi
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Đăng xuất
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <div class="col-lg-12 pt-2 pl-4 pr-4">
                <div style="color: #FF9138; font-weight:bold;" class="h5 mb-4">Tổng quan</div>
                <div class="row">
                    <div style="margin-bottom: 15px;border-radius:12px;height:80px;" class="col-lg-12 shadow">
                        <div class="row p-2">
                            <div style="height:65px;" class="col-lg-3 p-0">
                                <canvas id="chart-pie-devices"></canvas>
                            </div>
                            <div id="ratio-active-devices-dashboard" class="h6"></div>
                            <div class="col-lg-9 p-0">
                                <div class="row pl-2 pr-2">
                                    <div class="col-lg-5">
                                        <div style="color:#535261 ;font-weight:900;" class="h4">{{ number_format($totalDevices , 0, ',', '.') }}</div>
                                        <div style="color: #FF7506;" class="h6"><i class="	fas fa-chalkboard"></i> Thiết bị</div>
                                    </div>
                                    <div class="col-lg-7 pt-2">
                                        <div style="font-size: 12px;" class="h6"><i style="font-size: 6px;color:#FFD130;" class="fa fa-circle"></i> Đang hoạt động <span style="color:#FF7506 ; font-weight:bold;">{{ number_format($devicesActive , 0, ',', '.') }}</span></div>
                                        <div style="font-size: 12px;" class="h6"><i style="font-size: 6px;color:#7E7D88;" class="fa fa-circle"></i> Ngưng hoạt động <span style="color:#FF7506 ;font-weight:bold;">{{ number_format($devicesInActive , 0, ',', '.') }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom: 15px;border-radius:12px;height:80px;" class="col-lg-12 shadow">
                        <div class="row p-2">
                            <div style="height:65px;" class="col-lg-3 p-0">
                                <canvas id="chart-pie-services"></canvas>
                            </div>
                            <div id="ratio-active-services-dashboard" class="h6"></div>
                            <div class="col-lg-9 p-0">
                                <div class="row pl-2 pr-2">
                                    <div class="col-lg-5">
                                        <div style="color:#535261 ;font-weight:900;" class="h4">{{ number_format($totalServices , 0, ',', '.') }}</div>
                                        <div style="color: #4277FF;" class="h6"><i class="fab fa-servicestack"></i> Dịch vụ</div>
                                    </div>
                                    <div class="col-lg-7 pt-2">
                                        <div style="font-size: 12px;" class="h6"><i style="font-size: 6px;color:#4277FF;" class="fa fa-circle"></i> Đang hoạt động <span style="color:#4277FF ; font-weight:bold;">{{ number_format($servicesActive , 0, ',', '.') }}</span></div>
                                        <div style="font-size: 12px;" class="h6"><i style="font-size: 6px;color:#7E7D88;" class="fa fa-circle"></i> Ngưng hoạt động <span style="color:#4277FF ;font-weight:bold;">{{ number_format($servicesInActive , 0, ',', '.') }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom: 15px;border-radius:12px;height:80px;" class="col-lg-12 shadow">
                        <div class="row p-2">
                            <div style="height:65px;" class="col-lg-3 p-0">
                                <canvas id="chart-pie-numbers"></canvas>
                            </div>
                            <div id="ratio-active-numbers-dashboard" class="h6"></div>
                            <div class="col-lg-9 p-0">
                                <div class="row pl-2 pr-2">
                                    <div class="col-lg-5">
                                        <div style="color:#535261 ;font-weight:900;" class="h4">{{ number_format($totalNumbers , 0, ',', '.') }}</div>
                                        <div style="color:  #35C75A;" class="h6"><i class="	fas fa-layer-group"></i> Cấp số</div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div style="font-size: 12px;" class="h6"><i style="font-size: 6px;color:#35C75A;" class="fa fa-circle"></i> Đã sử dụng <span style="color: #35C75A ; font-weight:bold;">{{ number_format($numbersUsed , 0, ',', '.') }}</span></div>
                                        <div style="font-size: 12px;" class="h6"><i style="font-size: 6px;color:#7E7D88;" class="fa fa-circle"></i> Đang chờ <span style="color: #35C75A ;font-weight:bold;">{{ number_format($numbersWaiting , 0, ',', '.') }}</span></div>
                                        <div style="font-size: 12px;" class="h6"><i style="font-size: 6px;color:#F178B6;" class="fa fa-circle"></i> Bỏ qua <span style="color: #35C75A ;font-weight:bold;">{{ number_format($numbersBQ , 0, ',', '.') }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom: 15px;border-radius:12px;" class="col-lg-12 shadow">

                        <div class="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection