<?php
namespace App\Library;

use Logger;
use Exception;

class Util
{
  public static function calc($v1, $target2) {
    try{
      if(!empty($v1)){
        foreach ($v1 as $val1) {
          $val1 = ((strtotime($val1) - strtotime(date("Y/m/d"))) / 86400);
          $val1 %= 7;
          $val1 ++;
          $target1[] = $val1;
        }
      }

      $arr = [];
      for ($i=0;$i<15;$i++) {
        $arr[$i] = ["","","","","","",""];
      }
      
      for($i=0;$i<count($arr); $i++){
        for($j=0;$j<count($arr[$i]);$j++){
          if(!empty($v1)){
            foreach(array_map(null, $target2, $target1) as $v)
            if($i == $v[0]){
              array_splice($arr[$v[0]], $v[1]-1, 1, "●");
            }
          }
        }
      }

      return $arr;
    }
    catch(Exception $e)
    {
      Logger::logger("error", "", $e);
      $response['message'] = $e->getMessage();
    }
  }
}
