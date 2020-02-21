<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservedInfo;
use Util;
use Illuminate\Support\Facades\DB;

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
    }elseif($direct == 'next') {
      $start = date("Y/m/d", strtotime($date));
      $end = date("Y/m/d", strtotime($start.'+1 week'));
      $nextEnd = date("Y/m/d", strtotime($end.'+1 week'));
      $nextDate = ReservedInfo::whereBetween('reserved_date', [$end, $nextEnd])->pluck('reserved_date')->toArray();
      $nextTime = ReservedInfo::whereBetween('reserved_date', [$end, $nextEnd])->pluck('reserved_time')->toArray();
      $nums = Util::calc($nextDate, $nextTime);
    }else{
      $start = date("Y/m/d", strtotime($date));
      $end = date("Y/m/d", strtotime($start.'+1 week'));
      $Date = ReservedInfo::whereBetween('reserved_date', [$start, $end])->pluck('reserved_date')->toArray();
      $Time = ReservedInfo::whereBetween('reserved_date', [$start, $end])->pluck('reserved_time')->toArray();
      $nums = Util::calc($Date, $Time);
    }
    return response()->json(['nums'=> $nums, 'date'=> $start]);
  }

  public function create(Request $request) {
    $validator = $request->validate([
      'name' => 'required|min:2|max:10',
      'email' => 'required|email:dns',
    ]);
    $result = DB::transaction(function() use ($request){
      $reserved_infos = new ReservedInfo;
      $reserved_infos->name = $request->name;
      $reserved_infos->reserved_date = $request->date;
      $reserved_infos->reserved_time = $request->time;
      $reserved_infos->price = 3000;
      $reserved_infos->mail_address = $request->email;
      $reserved_infos->save();
      return $result = $reserved_infos;
    });
    return response()->json(['result'=> $result]);
  }
}
