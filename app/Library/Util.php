<?php
namespace App\Library;

class Util
{
    public static function calc($v1, $v2) {
      foreach (array_combine($v1, $v2) as $val1 => $val2) {
        $val1 = ((strtotime($val1) - strtotime(date("Y/m/d"))) / 86400);
        $val1 %= 7;
        $val1 ++;
        $answer[] = [$val2 => $val1];
      }
      $time = 0;
      foreach ($answer as $key => $value) {
        if($time != $key ) {
          $answe[$key] = $value;
          $time = $key;
        }else {
          $answer[$time] = $value;
        }
      }
      return $answer;
    }

    public static function weekly() {
      $weekly[] = date("Y/m/d");
      for($i = 1; $i < 7; $i++) {
        $date = strtotime("+ $i day");
        $weekly[] = date("Y/m/d", $date);
      }
      return $weekly;
    }
}
