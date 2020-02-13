<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservedInfo;
use Util;

class ReservedInfoController extends Controller
{
    public function index() {
      $from = date("Y/m/d");
      $until = date("Y/m/d", strtotime("7 day"));

      $date = ReservedInfo::whereBetween('reserved_date', [$from, $until])->pluck('reserved_date')->toArray();
      $time = ReservedInfo::whereBetween('reserved_date', [$from, $until])->pluck('reserved_time')->toArray();
      $nums = Util::calc($date, $time);
      return response()->json(['nums'=> $nums, 'from'=> $from]);
    }

    public function show(Request $request) {
      $date = $request->input('date');
      $direct = $request->input('direct');
      if($direct == 'prev') {
        $start = date("Y/m/d", strtotime($date));
        $end = date("Y/m/d", strtotime($start.'-1 week'));
        $prevDate = ReservedInfo::whereBetween('reserved_date', [$end, $start])->pluck('reserved_date')->toArray();
        $prevTime = ReservedInfo::whereBetween('reserved_date', [$end, $start])->pluck('reserved_time')->toArray();
        $nums = Util::calc($prevDate, $prevTime);
      }else{
        $start = date("Y/m/d", strtotime($date));
        $end = date("Y/m/d", strtotime($start.'+1 week'));
        $nextEnd = date("Y/m/d", strtotime($end.'+1 week'));
        $nextDate = ReservedInfo::whereBetween('reserved_date', [$end, $nextEnd])->pluck('reserved_date')->toArray();
        $nextTime = ReservedInfo::whereBetween('reserved_date', [$end, $nextEnd])->pluck('reserved_time')->toArray();
        $nums = Util::calc($nextDate, $nextTime);
      }
      return response()->json(['nums'=> $nums, 'date'=> $end]);
    }
}
