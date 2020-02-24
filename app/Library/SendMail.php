<?php
namespace App\Library;

use Logger;
use Exception;
class SendMail {
    public function send_mail($mail_addres, $name, $date, $time) {
        try{
            $to = $mail_addres;
            $subject = "予約ありがとうございます。";
            $message = "この度ご予約頂きまして、ありがとうございます。\r\n予約内容をご確認下さい。\r\n名前：$name\r\n日付：$date\r\n時間：$time\r\nメールアドレス：$mail_addres\r\n";
            $headers = "From: from@resevation.jp";
            $result = "";
            
            mb_language("Japanese");
            mb_internal_encoding("UTF-8");
            if (mb_send_mail($to, $subject, $message, $headers)) {
                $result = "$name へメールが送信されました。";
                Logger::logger("", "メール送信されました。");
            } else {
                $result = "$name へメールの送信に失敗しました。";
                Logger::logger("", "メール送信されていません。");
            }
            return $result;
        }
        catch(Exception $e)
        {
        Logger::logger("error", "", $e);
        $response['message'] = $e->getMessage();
        }
    }
}