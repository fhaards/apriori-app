<?php
namespace App\Http\Helpers;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GlobalHelpers
{
    public static function getRandId()
    {
        $randPool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $setRand1 = strtoupper(substr(str_shuffle(str_repeat($randPool, 5)), 0, 5));
        $setRand2 = strtoupper(substr(str_shuffle(str_repeat($randPool, 5)), 0, 3));
        $setRand3 = date('ymd');
        $setRand4 = date('his');
        $setRands = $setRand1.'-'. $setRand3 .'-'. $setRand2.$setRand4;

        // return trim($setRands);
        return $setRands;
    }
}