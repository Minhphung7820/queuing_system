<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Numbers;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        $arr = [];
        $SttFilter = [];
        $arrTimeFilter = [];
        $all = Numbers::orderBy('created_at', 'desc')->paginate(10);
        $total = Numbers::orderBy('created_at', 'desc')->get();
        $Services = Services::all();
        $Devices = Devices::all();
        foreach ($total as $key => $value) {
            $arr[] = Carbon::parse($value->created_at)->toDateString();
            $SttFilter[] = $value;
            $arrTimeFilter[] = $value;
        }
        $dataLimit = count($arr) > 0 ? min($arr) : '00';
        return view('admin.page.report', compact('all', 'dataLimit', 'SttFilter', 'Services', 'arrTimeFilter', 'Devices'));
    }
    public function filter(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        $data = Numbers::where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->take(10)->get();
        $count = Numbers::where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ';
                } elseif ($value->status == 2) {
                    $stt = ' <i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng';
                } elseif ($value->status == 3) {
                    $stt = '  <i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua';
                }
                $output .= '          <tr>
                                                <td>' . $value->number . '</td>
                                                <td>' . $value->services->name . '</td>
                                                <td>' . Carbon::parse($value->created_at)->format('h:i - d/m/yy') . '</td>
                                                <td> ' . $stt . ' </td>
                                                <td>' . $value->device->name . '</td>
                                     </tr>';
            }
            $id = $value->id;
            if ($count > 10) {
                $output .= '  <tr class="tr-btn-view-more-report">
                                    <td colspan="5" class="text-center"><button onclick="viewMoreFilterReport(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-report-filter">Xem thêm...</button></td>
                             </tr> ';
            }
        } else {
            $output .= ' <tr>
                                   <td colspan="5" class="text-center">Không có kết quả nào !</td>
                         </tr> ';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function viewMore(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->take(10)->get();
        $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
            $query->where('format_date', '>=', $begin);
            $query->where('format_date', '<=', $end);
        })->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = '<i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ';
                } elseif ($value->status == 2) {
                    $stt = ' <i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng';
                } elseif ($value->status == 3) {
                    $stt = '  <i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua';
                }
                $output .= '          <tr>
                                                <td>' . $value->number . '</td>
                                                <td>' . $value->services->name . '</td>
                                                <td>' . Carbon::parse($value->created_at)->format('h:i - d/m/yy') . '</td>
                                                <td> ' . $stt . ' </td>
                                                <td>' . $value->device->name . '</td>
                                     </tr>';
            }
            $id = $value->id;
            if ($count > 10) {
                $output .= '  <tr class="tr-btn-view-more-report">
                                    <td colspan="5" class="text-center"><button onclick="viewMoreFilterReport(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-report-filter">Xem thêm...</button></td>
                             </tr> ';
            }
        } else {
            $output .= ' <tr>
                                   <td colspan="5" class="text-center">Không có kết quả nào !</td>
                         </tr> ';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function filterInput(Request $request)
    {
        $output = '';
        $time = $request->time;
        $stt = $request->stt;
        $number = $request->number;
        $sers = $request->arrS;
        $dev = $request->dev;
        $arr = [];
        $arrDateLimit = [];
        // echo $stt;
        if ($number == 'all' && $time == 'all' && $stt == 'all' && $dev == 'all') {
            $data = Numbers::take(10)->get();
            $count = count(Numbers::all());
            $total = Numbers::all();
        } elseif ($number != 'all' && $time != 'all' && $stt != 'all' && $dev != 'all') {
            $data = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count =  Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->count();
            $total =  Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->get();
        } elseif ($number != 'all' && $time == 'all' && $stt == 'all' && $dev == 'all') {
            $data = Numbers::where('number', '=', $number)
                ->take(10)
                ->get();
            $count = Numbers::where('number', '=', $number)
                ->count();
            $total =  Numbers::where('number', '=', $number)
                ->get();
        } elseif ($number != 'all' && $time != 'all' && $stt == 'all' && $dev == 'all') {
            $data = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->take(10)
                ->get();
            $count = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->count();
            $total = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->get();
        } elseif ($number != 'all' && $time = 'all' && $stt != 'all' && $dev == 'all') {
            $data = Numbers::where('number', '=', $number)
                ->where('status', '=', $stt)
                ->take(10)
                ->get();
            $count = Numbers::where('number', '=', $number)
                ->where('status', '=', $stt)
                ->count();
            $total =  Numbers::where('number', '=', $number)
                ->where('status', '=', $stt)
                ->get();
        } elseif ($number != 'all' && $time == 'all' && $stt == 'all' && $dev != 'all') {
            $data = Numbers::where('number', '=', $number)
                ->where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count = Numbers::where('number', '=', $number)
                ->where('devices_id', '=', $dev)
                ->count();
            $total =  Numbers::where('number', '=', $number)
                ->where('devices_id', '=', $dev)
                ->get();
        } elseif ($number == 'all' && $time != 'all' && $stt == 'all' && $dev == 'all') {
            $data = Numbers::where('created_at', '=', $time)
                ->take(10)
                ->get();
            $count =  Numbers::where('created_at', '=', $time)
                ->count();
            $total =  Numbers::where('created_at', '=', $time)
                ->get();
        } elseif ($number == 'all' && $time != 'all' && $stt != 'all' && $dev == 'all') {
            $data = Numbers::where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->take(10)
                ->get();
            $count = Numbers::where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->count();
            $total = Numbers::where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->get();
        } elseif ($number == 'all' && $time != 'all' && $stt == 'all' && $dev != 'all') {
            $data = Numbers::where('created_at', '=', $time)
                ->where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count = Numbers::where('created_at', '=', $time)
                ->where('devices_id', '=', $dev)
                ->count();
            $total = Numbers::where('created_at', '=', $time)
                ->where('devices_id', '=', $dev)
                ->get();
        } elseif ($number == 'all' && $time == 'all' && $stt != 'all' && $dev == 'all') {
            $data = Numbers::where('status', '=', $stt)
                ->take(10)
                ->get();
            $count = Numbers::where('status', '=', $stt)
                ->count();
            $total = Numbers::where('status', '=', $stt)
                ->get();
        } elseif ($number == 'all' && $time == 'all' && $stt != 'all' && $dev != 'all') {
            $data = Numbers::where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count = Numbers::where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->count();
            $total = Numbers::where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->get();
        } elseif ($number == 'all' && $time == 'all' && $stt == 'all' && $dev != 'all') {
            $data = Numbers::where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count = Numbers::where('devices_id', '=', $dev)
                ->count();
            $total = Numbers::where('devices_id', '=', $dev)
                ->get();
        } elseif ($number != 'all' && $time != 'all' && $stt != 'all' && $dev == 'all') {
            $data = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->take(10)
                ->get();
            $count = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->count();
            $total = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->get();
        } elseif ($number != 'all' && $time != 'all' && $stt == 'all' && $dev != 'all') {
            $data = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('devices_id', '=', $dev)
                ->count();
            $total = Numbers::where('number', '=', $number)
                ->where('created_at', '=', $time)
                ->where('devices_id', '=', $dev)
                ->get();
        } elseif ($number != 'all' && $time == 'all' && $stt != 'all' && $dev != 'all') {
            $data = Numbers::where('number', '=', $number)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count = Numbers::where('number', '=', $number)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->count();
            $total = Numbers::where('number', '=', $number)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->get();
        } elseif ($number == 'all' && $time != 'all' && $stt != 'all' && $dev != 'all') {
            $data = Numbers::where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->take(10)
                ->get();
            $count = Numbers::where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->count();
            $total = Numbers::where('created_at', '=', $time)
                ->where('status', '=', $stt)
                ->where('devices_id', '=', $dev)
                ->get();
        }


        if ($count > 0) {
            if (count($sers) > 0) {
                foreach ($total as $key => $value) {
                    foreach ($sers as $keys => $values) {
                        if ($value->services_id == $values) {
                            $arr[] = $value;
                            $arrDateLimit[] = Carbon::parse($value->created_at)->toDateString();
                        }
                    }
                }
            } else {
                foreach ($total as $key => $value) {
                    $arr[] = $value;
                    $arrDateLimit[] = Carbon::parse($value->created_at)->toDateString();
                }
            }

            $output .= '   <tr style="display:none;">
                                    <th>Số thứ tự</th>
                                    <th>Tên dịch vụ</th>
                                    <th>Thời gian cấp</th>
                                    <th>Tình trạng</th>
                                    <th>Nguồn cấp</th>
                         </tr>';
            foreach ($arr as $key => $row) {
                if ($row->status == 1) {
                    $stt = '<i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ';
                } elseif ($row->status == 2) {
                    $stt = '<i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng';
                } elseif ($row->status == 3) {
                    $stt = '<i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua';
                }
                $output .= '          <tr>
                   <td>' . $row->number . '</td>
                   <td>' . $row->services->name . '</td>
                   <td>' . Carbon::parse($row->created_at)->format('h:i - d/m/yy') . '</td>
                   <td>' . $stt . '</td>
                   <td>' . $row->device->name . '</td>
               </tr>';
            }
        }
        // else{
        //       $output .= ' <tr style="height:200px;">
        //                        <td  colspan="5">Không tìm thấy kết quả nào !</td>
        //                    </tr>';
        // }
        $dataLimit = count($arrDateLimit) > 0 ? min($arrDateLimit) : "00";
        return response()->json(['status' => 200, 'msg' => $output, 'dataLimit' => $dataLimit]);
    }
}
