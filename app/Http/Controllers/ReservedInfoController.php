<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservedInfo;
use Util;
use SendMail;
use Logger;
use Illuminate\Support\Facades\DB;
use Exception;

class ReservedInfoController extends Controller
{
  public function index() {
    try{
      $response['status'] = 'NG';
      $response['date'] = date('Y-m-d');
      $from = date("Y/m/d");
      $until = date("Y/m/d", strtotime("7 day"));
      $date = ReservedInfo::whereBetween('reserved_date', [$from, $until])->pluck('reserved_date')->toArray();
      $time = ReservedInfo::whereBetween('reserved_date', [$from, $until])->pluck('reserved_time')->toArray();
      $nums = Util::calc($date, $time);
      return response()->json(['nums'=> $nums, 'from'=> $from]);
    }catch(Exception $e){
      Logger::logger("error", "", $e);
      $response['message'] = $e->getMessage();
      return response()->json($response, 500);
    }
  }

  public function show(Request $request) {
    try{
      $response['status'] = 'NG';
      $response['date'] = date('Y-m-d');
      $date = $request->input('date');
      $direct = $request->input('direct');
      if($direct == 'prev') {
        $end = date("Y/m/d", strtotime($date));
        $start = date("Y/m/d", strtotime($end.'-1 week'));
      }elseif($direct == 'next') {
        $today = date("Y/m/d", strtotime($date));
        $start = date("Y/m/d", strtotime($today.'+1 week'));
        $end = date("Y/m/d", strtotime($start.'+1 week'));
      }else{
        $start = date("Y/m/d", strtotime($date));
        $end = date("Y/m/d", strtotime($start.'+1 week'));
      }
      $Date = ReservedInfo::whereBetween('reserved_date', [$start, $end])->pluck('reserved_date')->toArray();
      $Time = ReservedInfo::whereBetween('reserved_date', [$start, $end])->pluck('reserved_time')->toArray();
      $nums = Util::calc($Date, $Time);
      return response()->json(['nums'=> $nums, 'date'=> $start]);
    }catch(Exception $e){
      Logger::logger("error", "", $e);
      $response['message'] = $e->getMessage();
      return response()->json($response, 500);
    }
  }

  public function create(Request $request) {
    try{
      $response['status'] = 'NG';
      $response['date'] = date('Y-m-d');
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
      });
      $result = SendMail::send_mail($request->email, $request->name, $request->date, $request->time);
      return response()->json(['result'=> $result]);
    }catch(Exception $e) {
      Logger::logger("error", "", $e);
      $response['message'] = $e->getMessage();
      return response()->json($response, 500);
    }
  }
}
