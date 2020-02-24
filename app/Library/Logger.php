<?php
namespace App\Library;

class Logger {
    public function logger($type, $message, $e = null) {
        if($type == 'error'){
            error_log("[".date('Y-m-d H:i:s')."]".$e->getMessage()."\n", 3, __DIR__ . "/exceptions.log");
        }else{
            error_log("[".date('Y-m-d H:i:s')."]".$message."\n", 3, __DIR__ . "/trace.log");
        }
    }
}