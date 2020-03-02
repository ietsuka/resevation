<?php

namespace App\Library;

class CreateCsv
{
    public function create_csv($reserved, $filePath)
    {
        $f = [
            0 => '07:00',
            1 => '08:00',
            2 => '09:00',
            3 => '10:00',
            4 => '11:00',
            5 => '12:00',
            6 => '13:00',
            7 => '14:00',
            8 => '15:00',
            9 => '16:00',
            10 => '17:00',
            11 => '18:00',
            12 => '19:00',
            13 => '20:00',
            14 => '21:00',
        ];

        $fp = new \SplFileObject('php://output', 'w');


        $fp->fputcsv(["日付", "氏名", "時間", "メールアドレス"]);
        foreach ($reserved as $value) {
            $row = array(
                $value['reserved_date'],
                $value['name'],
                $f[$value['reserved_time']],
                $value['mail_address']
            );
            $fp->fputcsv($row);
        }

        return $fp;
    }
}
