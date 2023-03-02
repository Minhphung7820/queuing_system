<?php

namespace App\Http\Controllers;

use App\Models\Numbers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use App\Models\Devices;
use App\Models\Services;

class IndexController extends Controller
{
    public $base;
    public function __construct()
    {
        $this->base = new BaseController();
    }
    public function index()
    {
        // $times = new Carbon();
        // echo $times->month;
        // Thiết bị
        // $times = Carbon::parse('2022-2-28');
        // $countDay = $times->weekOfMonth;
        // echo $countDay;
        // for ($i=1; $i <= $countDay; $i++) { 
        //   echo $i."<br>";    
        // }
        // $base = new BaseController();
        // echo $base->getAllWeeks();
        $allDevices = count(Devices::all());
        $devicesActive = Devices::where('status_active', '=', 1)->count();
        $devicesInActive = Devices::where('status_active', '=', 2)->count();
        # Tỷ lệ thiết bị
        $ratioDevicesActive = ceil($devicesActive * 100 / $allDevices);
        $ratioDevicesInActive = ceil($devicesInActive * 100 / $allDevices);
        //   Kết thúc thiết bị
        // Dịch vụ
        $allServices = count(Services::all());
        $servicesActive = Services::where('status_active', '=', 1)->count();
        $servicesInActive = Services::where('status_active', '=', 2)->count();
        //  Tỷ lệ dịch vụ
        $ratioServicesActive = ceil($servicesActive * 100 / $allServices);
        $ratioServicesInActive = ceil($servicesInActive * 100 / $allServices);
        // Kết thúc dịch vụ
        // Số tt
        $numbersWaiting = Numbers::where('status', '=', 1)->count();
        $numbersUsed = Numbers::where('status', '=', 2)->count();
        $numbersBQ = Numbers::where('status', '=', 3)->count();
        // Kết thúc số tt

        $totalDevices = count(Devices::all());
        $totalServices = count(Services::all());
        $totalNumbers = count(Numbers::all());
        $totalNumeber = count(Numbers::all());
        $dataAllNumbers = Numbers::all();
        $dataNumberUsed = Numbers::where("status", "=", 2)->get();
        $dataNumberWaiting = Numbers::where("status", "=", 1)->get();
        $dataNumberBQ = Numbers::where("status", "=", 3)->get();
        $totalNumberWaiting = Numbers::where("status", "=", 1)->count();
        $totalNumberUsed = Numbers::where("status", "=", 2)->count();
        $totalNumberBQ = Numbers::where("status", "=", 3)->count();
        $arrMonthNow = [];
        $arrMonthAgo = [];
        $arrMonthNowNumbersWaiting = [];
        $arrMonthAgoNumbersWaiting = [];
        $arrMonthNowNumbersUsed = [];
        $arrMonthAgoNumbersUsed = [];
        $arrMonthNowNumbersBQ = [];
        $arrMonthAgoNumbersBQ = [];
        $time = new Carbon();
        $monthNow = $time->month;
        $monthAgo = $time->addMonths(-1);
        $monthAgo = $monthAgo->month;
        $stt = '';
        foreach ($dataAllNumbers as $key => $value) {
            if (Carbon::parse($value->created_at)->month == $monthAgo) {
                $arrMonthAgo[] = $value;
            } elseif (Carbon::parse($value->created_at)->month == $monthNow) {
                $arrMonthNow[] = $value;
            }
        }
        foreach ($dataNumberWaiting as $key => $value) {
            if (Carbon::parse($value->created_at)->month == $monthAgo) {
                $arrMonthAgoNumbersWaiting[] = $value;
            } elseif (Carbon::parse($value->created_at)->month == $monthNow) {
                $arrMonthNowNumbersWaiting[] = $value;
            }
        }
        foreach ($dataNumberUsed as $key => $value) {
            if (Carbon::parse($value->created_at)->month == $monthAgo) {
                $arrMonthAgoNumbersUsed[] = $value;
            } elseif (Carbon::parse($value->created_at)->month == $monthNow) {
                $arrMonthNowNumbersUsed[] = $value;
            }
        }
        foreach ($dataNumberBQ as $key => $value) {
            if (Carbon::parse($value->created_at)->month == $monthAgo) {
                $arrMonthAgoNumbersBQ[] = $value;
            } elseif (Carbon::parse($value->created_at)->month == $monthNow) {
                $arrMonthNowNumbersBQ[] = $value;
            }
        }

        $baseCTR = new BaseController();
        $stt =  $baseCTR->ratioNumbersByMonth($arrMonthNow, $arrMonthAgo)['stt'];
        $ratio = $baseCTR->ratioNumbersByMonth($arrMonthNow, $arrMonthAgo)['ratio'];
        $stt_U = $baseCTR->ratioNumbersByMonth($arrMonthNowNumbersUsed, $arrMonthAgoNumbersUsed)['stt'];
        $ratio_U = $baseCTR->ratioNumbersByMonth($arrMonthNowNumbersUsed, $arrMonthAgoNumbersUsed)['ratio'];
        $stt_W = $baseCTR->ratioNumbersByMonth($arrMonthNowNumbersWaiting, $arrMonthAgoNumbersWaiting)['stt'];
        $ratio_W = $baseCTR->ratioNumbersByMonth($arrMonthNowNumbersWaiting, $arrMonthAgoNumbersWaiting)['ratio'];
        $stt_BQ = $baseCTR->ratioNumbersByMonth($arrMonthNowNumbersBQ, $arrMonthAgoNumbersBQ)['stt'];
        $ratio_BQ = $baseCTR->ratioNumbersByMonth($arrMonthNowNumbersBQ,  $arrMonthAgoNumbersBQ)['ratio'];
        //  $time = Carbon::parse('2022-09-29 15:30:20');
        //  echo $time->weekOfMonth;
        return view(
            'admin.page.dashboard',
            compact(
                'totalNumeber',
                'totalNumberWaiting',
                'totalNumberUsed',
                'totalNumberBQ',
                'stt',
                'ratio',
                'stt_W',
                'ratio_W',
                'stt_U',
                'ratio_U',
                'stt_BQ',
                'ratio_BQ',
                'totalDevices',
                'totalServices',
                'totalNumbers',
                'devicesActive',
                'devicesInActive',
                'servicesActive',
                'servicesInActive',
                'numbersWaiting',
                'numbersUsed',
                'numbersBQ',
            )
        );
    }
    public function ratioDevices(Request $request)
    {
        $all = count(Devices::all());
        $devicesActive = Devices::where('status_active', '=', 1)->count();
        $devicesInActive = Devices::where('status_active', '=', 2)->count();

        $ratioActive = ceil($devicesActive * 100 / $all);
        $ratioInActive = ceil($devicesInActive * 100 / $all);
        return response()->json(['msg' => [$ratioActive, $ratioInActive], 'ratio' => $ratioActive]);
    }

    public function ratioServices(Request $request)
    {
        $all = count(Services::all());
        $servicesActive = Services::where('status_active', '=', 1)->count();
        $servicesInActive = Services::where('status_active', '=', 2)->count();

        $ratioActive = ceil($servicesActive * 100 / $all);
        $ratioInActive = ceil($servicesInActive * 100 / $all);
        return response()->json(['msg' => [$ratioActive, $ratioInActive], 'ratio' => $ratioActive]);
    }
    public function ratioNumbers(Request $request)
    {
        $all = count(Numbers::all());
        $numbersWaiting = Numbers::where('status', '=', 1)->count();
        $numbersUsed = Numbers::where('status', '=', 2)->count();
        $numbersBQ = Numbers::where('status', '=', 3)->count();

        $ratioWaiting = ceil($numbersWaiting * 100 / $all);
        $ratioUsed = ceil($numbersUsed * 100 / $all);
        $ratioBQ = ceil($numbersBQ * 100 / $all);
        return response()->json(['msg' => [$ratioUsed, $ratioWaiting, $ratioBQ], 'ratio' => $ratioUsed]);
    }
    public function NonFunction()
    {
        return view('admin.notRole.NotRole');
    }
    public function viewChart(Request $request)
    {
        $numbers  = Numbers::all();
        if ($request->type == 'date') {
            $arrDay = [];
            $arr = [];
            $times = new Carbon();
            $countDay = $times->daysInMonth;

            for ($i = 1; $i <= $countDay; $i++) {
                $arrDay[] = "Ngày ".$i;
                $data = [];
                foreach ($numbers as $key => $value) {
                    if (Carbon::parse($value->created_at)->month == now()->month) {
                        if (Carbon::parse($value->created_at)->day == $i) {
                            $data[] = $value;
                        }
                    }
                }
                $arr[] = count($data);
                unset($data);
            }
            return response()->json(['type' => 'date', 'value' => $arr, 'times' => $arrDay,'now'=>'Tháng '.now()->month.'/'.now()->year]);
        } elseif ($request->type == 'week') {
            $dataNumbers = Numbers::all();
            $arrWeeks = [];
            $arr = [];
            for ($i = 1; $i <= $this->base->getAllWeeks(); $i++) {
                $arrWeeks[] = 'Tuần ' . $i;
                $data = [];
                foreach ($dataNumbers as $key => $value) {
                    if (Carbon::parse($value->created_at)->month == now()->month) {
                        if (Carbon::parse($value->created_at)->weekOfMonth == $i) {
                            $data[] = $value;
                        }
                    }
                }
                $arr[] = count($data);
                unset($data);
            }
            return response()->json(['type' => 'week', 'value' => $arr, 'times' => $arrWeeks,'now'=>'Tháng '.now()->month.'/'.now()->year]);
        } elseif ($request->type == 'month') {
            $dataNumbers = Numbers::all();
            $arrMonth = [];
            $arr = [];
            for ($i = 1; $i <= 12; $i++) {
                $arrMonth[] = "Tháng ".$i;
                $data = [];
                foreach ($dataNumbers as $key => $value) {
                    if (Carbon::parse($value->created_at)->month == $i && Carbon::parse($value->created_at)->year == now()->year) {
                        $data[] = $value;
                    }
                }
                $arr[] = count($data);
                unset($data);
            }
            return response()->json(['type' => 'month', 'value' => $arr, 'times' => $arrMonth,'now'=>'Năm '.now()->year]);
        }
    }

    public function loadnotification(Request $request)
    {
        $output = '';
        $data = Numbers::orderBy('created_at','desc')->take(11)->get();
        foreach ($data as $key => $value) {
              $output .= '          <a class="dropdown-item d-flex align-items-center" href="/admin/number/show/'.$value->id.'">
                                                    <div>
                                                        <div style="color: #BF5805;font-size: 16px;font-weight: 700;line-height: 24px;margin-bottom:5px;" class="small">Người dùng: '.$value->user->fullname.'</div>
                                                        <div style="color: #535261;">Thời gian nhận số: '.Carbon::parse($value->created_at)->hour.'h'.Carbon::parse($value->created_at)->minute.' ngày '.Carbon::parse($value->created_at)->format('d/m/yy').'</div>
                                                    </div>
                                   </a>';
        }
        return response()->json(['msg'=>$output]);
    }
}
