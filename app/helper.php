<?php

use Carbon\Carbon;

function CreateFileName($filename)
{
    $now = Carbon::now()->toDateTimeString();
    $microsecond = Carbon::now()->microsecond;
    $pattern = '/[" " :]/';
    $x = preg_split($pattern, $now);
    $file_name = implode("_", $x) . "_" . $microsecond . "_" . $filename;
    return $file_name;

}
