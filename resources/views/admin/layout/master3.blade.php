@include('admin.block.header')



<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">





        <div style="background-color:#f6f6f6;" class="container-fluid">
            <div class="row">
                <div class="col-lg-7">
                    <h1 style="margin-top:20px;" class="h4 mb-2">
                        @yield('page') @yield('breadcrumb')
                    </h1>
                    <br><br>

                    <div style="color: #FF9138; font-weight:bold;" class="h5">@yield('name-content')</div>
                </div>
                <div class="col-lg-5">
                    <nav style="background: none;" class="navbar navbar-expand navbar-light topbar mb-4 static-top">
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

                                                                                    echo asset('backend/layout/img/' . Auth::guard('web')->user()->avt) ?>">

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



                </div>

            </div>



            @yield('content')
        </div>















    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website {{ now()->year }}</span>
            </div>
        </div>
    </footer> -->
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn đăng xuất ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Bấm "OK" để đăng xuất khỏi tài khoản.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                <a class="btn btn-primary" href="/dang-xuat">OK</a>
            </div>
        </div>
    </div>
</div>

@include('admin.block.footer')