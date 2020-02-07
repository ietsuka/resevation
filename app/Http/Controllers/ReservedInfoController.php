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
      $time = ReservedInfo::pluck('reserved_time')->toArray();

      $nums = Util::calc($date, $time);
      $weekly = Util::weekly();
      return response()->json(['nums'=> $nums, 'weekly' => $weekly]);
    }
}
