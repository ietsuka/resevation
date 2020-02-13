<?php
namespace App\Library;

class Util
{
  public static function calc($v1, $target2) {
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
          foreach (array_combine($target2, $target1) as $k => $v){
            if($i == $k){
              array_splice($arr[$k], $v-1, 1, ["●"]);
            }
          }
        }
    	}
    }
    return $arr;
  }
}
