<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Numbers;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\ActHistory;
class GiveNumber extends Controller
{

    public function index()
    {
        $arrTime = [];
        $services = Services::all();
        $devices = Devices::all();
        if (isset($_GET['key'])) {
            $key = trim($_GET['key']);
            $number = Numbers::where(function ($query) use ($key) {
                $query->where('number', 'like', '%' . $key . '%');
                $query->orWhereHas('device', function ($qr) use ($key) {
                    $qr->where('name', 'like', '%' . $key . '%');
                });
                $query->orWhereHas('services', function ($qr) use ($key) {
                    $qr->where('name', 'like', '%' . $key . '%');
                });
                $query->orWhereHas('user', function ($qr) use ($key) {
                    $qr->where('fullname', 'like', '%' . $key . '%');
                });
            })->paginate(9);
            $number->appends(['key' => $key]);
            $timeNumber = Numbers::where(function ($query) use ($key) {
                $query->where('number', 'like', '%' . $key . '%');
                $query->orWhereHas('device', function ($qr) use ($key) {
                    $qr->where('name', 'like', '%' . $key . '%');
                });
                $query->orWhereHas('services', function ($qr) use ($key) {
                    $qr->where('name', 'like', '%' . $key . '%');
                });
                $query->orWhereHas('user', function ($qr) use ($key) {
                    $qr->where('fullname', 'like', '%' . $key . '%');
                });
            })->get();
        } else {
            $number = Numbers::orderBy('created_at', 'desc')->paginate(9);
            $timeNumber = Numbers::orderBy('created_at', 'desc')->get();
        }
        if ($timeNumber) {
            foreach ($timeNumber as $key => $value) {
                $arrTime[] = $value->format_date;
            }
        }
        $DateLimit = (count($arrTime) > 0) ? min($arrTime) : '0000';
        return view('admin.page.all_number', compact('services', 'devices', 'number', 'DateLimit'));
    }


    public function create()
    {
        $services = Services::all();
        return view('admin.page.create_number', compact('services'));
    }


    public function store(Request $request)
    {
        $id = $request->name_select_services;
        $counter = [1, 2, 3, 4, 5, 6];
        $service = Services::find($id);
        if ($service->number_current > 9999) {
            return response()->json(['status' => 202, 'msg' => 'Số tối đa 9999 !']);
        }
        if (strlen($service->number_current) == 1) {
            $nbCr = "000" . $service->number_current;
        } elseif (strlen($service->number_current) == 2) {
            $nbCr = "00" . $service->number_current;
        } elseif (strlen($service->number_current) == 3) {
            $nbCr = "0" . $service->number_current;
        } elseif (strlen($service->number_current) == 4) {
            $nbCr =  $service->number_current;
        }
        $giving =  Numbers::create([
            'number' => $nbCr,
            'counter' => Arr::random($counter),
            'user_id' => Auth::guard('web')->user()->id,
            'services_id' => $id,
            'devices_id' => $service->device->id,
            'format_date' => now()->toDateString(),
            'date_started' => now(),
            'date_end' => now()->addDays(5),
            'created_at' => now()
        ])->id;
        $give = Numbers::find($giving);
        $data = array(
            "name" => $service->name,
            "number" =>  $give->number,
            "started" => Carbon::parse($give->date_started)->hour . ":" . Carbon::parse($give->date_started)->minute . " " . Carbon::parse($give->date_started)->day . "/" . Carbon::parse($give->date_started)->month . "/" . Carbon::parse($give->date_started)->year,
            "end" => Carbon::parse($give->date_end)->hour . ":" . Carbon::parse($give->date_end)->minute . " " . Carbon::parse($give->date_end)->day . "/" . Carbon::parse($give->date_end)->month . "/" . Carbon::parse($give->date_end)->year,
            'counter' => $give->counter
        );
        $addHistory = ActHistory::create([
            'nameLogin' => auth()->guard('web')->user()->name,
            'Time' => now(),
            'ipAddress' => $request->ip(),
            'action' => 'Cấp số thứ tự mới ' . $give->number .' dịch vụ '.$service->name,
            'format_date'=>now()->toDateString(),
            'created_at' => now()
        ]);
        $service->update([
            'number_current' => $service->number_current + 1,
        ]);
        if ($giving && $addHistory) {
            return response()->json(['status' => 200, 'msg' => $data]);
        }
    }

    public function filter(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        if ($request->services == 4 && $request->devices == 4 && $request->status != 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status', '=', $request->status)->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status', '=', $request->status)->count();
        } elseif ($request->services == 4 && $request->devices != 4 && $request->status == 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)->count();
        } elseif ($request->services != 4 && $request->devices == 4 && $request->status == 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)->count();
        } elseif ($request->services == 4 && $request->devices == 4 && $request->status == 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->count();
        } elseif ($request->services != 4 && $request->devices != 4 && $request->status != 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->count();
        } elseif ($request->services != 4 && $request->devices != 4 && $request->status == 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->count();
        } elseif ($request->services != 4 && $request->devices == 4 && $request->status != 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('status', '=', $request->status)
                ->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('status', '=', $request->status)
                ->count();
        } elseif ($request->services == 4 && $request->devices != 4 && $request->status != 4) {
            $data = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->take(9)->get();
            $count = Numbers::where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->count();
        }
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = ' <i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ';
                } elseif ($value->status == 2) {
                    $stt = '  <i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng';
                } elseif ($value->status == 3) {
                    $stt = '  <i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua';
                }
                $output .= '           <tr>
                                                <td>' . $value->number . '</td>
                                                <td>' . $value->user->fullname . '</td>
                                                <td>' . $value->services->name . '</td>
                                                <td>' . Carbon::parse($value->date_started)->hour . ':' . Carbon::parse($value->date_started)->minute . ' - ' . Carbon::parse($value->date_started)->day . '/' . Carbon::parse($value->date_started)->month . '/' . Carbon::parse($value->date_started)->year . '</td>
                                                <td>' . Carbon::parse($value->date_end)->hour . ':' . Carbon::parse($value->date_end)->minute . ' - ' . Carbon::parse($value->date_end)->day . '/' . Carbon::parse($value->date_end)->month . '/' . Carbon::parse($value->date_end)->year . '</td>
                                                <td>' . $stt . ' </td>
                                                <td>' . $value->device->name . '</td>
                                                <td><a href="/admin/number/show/' . $value->id . '">Chi tiết</a></td>
                                      </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-numbers">
                                      <td class="text-center" colspan="8"><button onclick="viewMoreNumbers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-numbers-filter">Xem thêm...</button></td>
                               </tr>';
            }
        } else {
            $output .= ' <tr>
                           <td class="text-center" colspan="8">Không tìm thấy kết quả nào !</td>
                        </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }


    public function viewMore(Request $request)
    {
        $output = '';
        $begin = $request->begin;
        $end = $request->end;
        if ($request->services == 4 && $request->devices == 4 && $request->status != 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status', '=', $request->status)->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('status', '=', $request->status)->count();
        } elseif ($request->services == 4 && $request->devices != 4 && $request->status == 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)->count();
        } elseif ($request->services != 4 && $request->devices == 4 && $request->status == 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)->count();
        } elseif ($request->services == 4 && $request->devices == 4 && $request->status == 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->count();
        } elseif ($request->services != 4 && $request->devices != 4 && $request->status != 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->count();
        } elseif ($request->services != 4 && $request->devices != 4 && $request->status == 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('devices_id', '=', $request->devices)
                ->count();
        } elseif ($request->services != 4 && $request->devices == 4 && $request->status != 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('status', '=', $request->status)
                ->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('services_id', '=', $request->services)
                ->where('status', '=', $request->status)
                ->count();
        } elseif ($request->services == 4 && $request->devices != 4 && $request->status != 4) {
            $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->take(9)->get();
            $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($begin, $end) {
                $query->where('format_date', '>=', $begin);
                $query->where('format_date', '<=', $end);
            })->where('devices_id', '=', $request->devices)
                ->where('status', '=', $request->status)
                ->count();
        }
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = ' <i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ';
                } elseif ($value->status == 2) {
                    $stt = '  <i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng';
                } elseif ($value->status == 3) {
                    $stt = '  <i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua';
                }
                $output .= '           <tr>
                                                <td>' . $value->number . '</td>
                                                <td>' . $value->user->fullname . '</td>
                                                <td>' . $value->services->name . '</td>
                                                <td>' . Carbon::parse($value->date_started)->hour . ':' . Carbon::parse($value->date_started)->minute . ' - ' . Carbon::parse($value->date_started)->day . '/' . Carbon::parse($value->date_started)->month . '/' . Carbon::parse($value->date_started)->year . '</td>
                                                <td>' . Carbon::parse($value->date_end)->hour . ':' . Carbon::parse($value->date_end)->minute . ' - ' . Carbon::parse($value->date_end)->day . '/' . Carbon::parse($value->date_end)->month . '/' . Carbon::parse($value->date_end)->year . '</td>
                                                <td>' . $stt . ' </td>
                                                <td>' . $value->device->name . '</td>
                                                <td><a href="/admin/number/show/' . $value->id . '">Chi tiết</a></td>
                                      </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-numbers">
                                      <td class="text-center" colspan="8"><button onclick="viewMoreNumbers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-numbers-filter">Xem thêm...</button></td>
                               </tr>';
            }
        } else {
            $output .= ' <tr>
                           <td class="text-center" colspan="8">Không tìm thấy kết quả nào !</td>
                        </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }

    public function keyup(Request $request)
    {
        $output = '';
        $key = $request->key;
        $arrTime = [];
        $data = Numbers::where(function ($query) use ($key) {
            $query->where('number', 'like', '%' . $key . '%');
            $query->orWhereHas('device', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('services', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('user', function ($qr) use ($key) {
                $qr->where('fullname', 'like', '%' . $key . '%');
            });
        })->take(9)->get();
        $dataTime = Numbers::where(function ($query) use ($key) {
            $query->where('number', 'like', '%' . $key . '%');
            $query->orWhereHas('device', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('services', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('user', function ($qr) use ($key) {
                $qr->where('fullname', 'like', '%' . $key . '%');
            });
        })->get();
        $count = Numbers::where(function ($query) use ($key) {
            $query->where('number', 'like', '%' . $key . '%');
            $query->orWhereHas('device', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('services', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('user', function ($qr) use ($key) {
                $qr->where('fullname', 'like', '%' . $key . '%');
            });
        })->count();
        if (count($dataTime) > 0) {
            foreach ($dataTime as $key => $value) {
                $arrTime[] = $value->format_date;
            }
            $dataLimit = min($arrTime);
        } else {
            $dataLimit = '00';
        }

        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = ' <i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ';
                } elseif ($value->status == 2) {
                    $stt = '  <i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng';
                } elseif ($value->status == 3) {
                    $stt = '  <i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua';
                }
                $output .= '           <tr>
                                                <td>' . $value->number . '</td>
                                                <td>' . $value->user->fullname . '</td>
                                                <td>' . $value->services->name . '</td>
                                                <td>' . Carbon::parse($value->date_started)->hour . ':' . Carbon::parse($value->date_started)->minute . ' - ' . Carbon::parse($value->date_started)->day . '/' . Carbon::parse($value->date_started)->month . '/' . Carbon::parse($value->date_started)->year . '</td>
                                                <td>' . Carbon::parse($value->date_end)->hour . ':' . Carbon::parse($value->date_end)->minute . ' - ' . Carbon::parse($value->date_end)->day . '/' . Carbon::parse($value->date_end)->month . '/' . Carbon::parse($value->date_end)->year . '</td>
                                                <td>' . $stt . ' </td>
                                                <td>' . $value->device->name . '</td>
                                                <td><a href="/admin/number/show/' . $value->id . '">Chi tiết</a></td>
                                      </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-numbers">
                                      <td class="text-center" colspan="8"><button onclick="viewMoreKeyupNumbers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-keyup-numbers-filter">Xem thêm...</button></td>
                               </tr>';
            }
        } else {
            $output .= ' <tr>
                           <td class="text-center" colspan="8">Không tìm thấy kết quả nào !</td>
                        </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output, 'limitD' => $dataLimit]);
    }
    public function viewMoreKeyup(Request $request)
    {
        $output = '';
        $key = $request->text;
        $data = Numbers::where('id', '>', $request->id)->where(function ($query) use ($key) {
            $query->where('number', 'like', '%' . $key . '%');
            $query->orWhereHas('device', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('services', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('user', function ($qr) use ($key) {
                $qr->where('fullname', 'like', '%' . $key . '%');
            });
        })->take(9)->get();
        $count = Numbers::where('id', '>', $request->id)->where(function ($query) use ($key) {
            $query->where('number', 'like', '%' . $key . '%');
            $query->orWhereHas('device', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('services', function ($qr) use ($key) {
                $qr->where('name', 'like', '%' . $key . '%');
            });
            $query->orWhereHas('user', function ($qr) use ($key) {
                $qr->where('fullname', 'like', '%' . $key . '%');
            });
        })->count();
        if ($count > 0) {
            foreach ($data as $key => $value) {
                if ($value->status == 1) {
                    $stt = ' <i style="color: #4277FF;" class="fa fa-circle"></i> Đang chờ';
                } elseif ($value->status == 2) {
                    $stt = '  <i style="color: #7E7D88;" class="fa fa-circle"></i> Đã sử dụng';
                } elseif ($value->status == 3) {
                    $stt = '  <i style="color: #E73F3F;" class="fa fa-circle"></i> Bỏ qua';
                }
                $output .= '           <tr>
                                                <td>' . $value->number . '</td>
                                                <td>' . $value->user->fullname . '</td>
                                                <td>' . $value->services->name . '</td>
                                                <td>' . Carbon::parse($value->date_started)->hour . ':' . Carbon::parse($value->date_started)->minute . ' - ' . Carbon::parse($value->date_started)->day . '/' . Carbon::parse($value->date_started)->month . '/' . Carbon::parse($value->date_started)->year . '</td>
                                                <td>' . Carbon::parse($value->date_end)->hour . ':' . Carbon::parse($value->date_end)->minute . ' - ' . Carbon::parse($value->date_end)->day . '/' . Carbon::parse($value->date_end)->month . '/' . Carbon::parse($value->date_end)->year . '</td>
                                                <td>' . $stt . ' </td>
                                                <td>' . $value->device->name . '</td>
                                                <td><a href="/admin/number/show/' . $value->id . '">Chi tiết</a></td>
                                      </tr>';
            }
            $id = $value->id;
            if ($count > 9) {
                $output .= '   <tr class="tr-view-more-numbers">
                                      <td class="text-center" colspan="8"><button onclick="viewMoreKeyupNumbers(this)" data-id="' . $id . '"   style="background-color:#FF9138;border:none;" type="button" class="btn btn-primary btn-view-more-keyup-numbers-filter">Xem thêm...</button></td>
                               </tr>';
            }
        } else {
            $output .= ' <tr>
                           <td class="text-center" colspan="8">Không tìm thấy kết quả nào !</td>
                        </tr>';
        }
        return response()->json(['status' => 200, 'msg' => $output]);
    }
    public function show($id = null)
    {
        if (!$id) {
            return abort(404);
        }
        $data = Numbers::findOrFail($id);
        return view('admin.page.detail_number', compact('data'));
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
