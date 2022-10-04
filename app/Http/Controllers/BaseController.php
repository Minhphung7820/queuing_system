<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BaseController extends Controller
{
    public function ratioNumbersByMonth($arrMonthNow, $arrMonthAgo)
    {
        $stt = 0;
        $ratio = 0;
        if (count($arrMonthNow) > count($arrMonthAgo)) {
            $stt = 'Tăng';
            $ratio = round((100 - (count($arrMonthAgo) / count($arrMonthNow)) * 100), 2);
        } elseif (count($arrMonthNow) < count($arrMonthAgo)) {
            $stt = 'Giảm';
            $ratio = round((100 - (count($arrMonthNow) / count($arrMonthAgo)) * 100), 2);
        } elseif (count($arrMonthNow) == count($arrMonthAgo)) {
            $stt = 'Bình thường';
            $ratio = '00.00';
        }
        return ['stt' => $stt, 'ratio' => $ratio];
    }
    public function getAllWeeks()
    {
        $time = new Carbon();
        $count = $time->daysInMonth;
        $arr = [];
        $arrWeeks = [];

        for ($i = 1; $i <= $count; $i++) {
            $html = $time->year . '-' . $time->month . '-' . $i;
            $arr[] = $html;
        }

        foreach ($arr as $key => $value) {
            $arrWeeks[] = Carbon::parse($value)->weekOfMonth;
        }

        return max($arrWeeks);
    }
    public function generateRandomString($characters)
    {
        $length = 6;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return bcrypt($randomString); //This will return encrypted password
    }
}
