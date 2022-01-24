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
        $randStrPool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $setRandStr  = strtoupper(substr(str_shuffle(str_repeat($randStrPool, 3)), 0, 3));
        $setRandDate = date('ymd');
        $setRandTime = date('his');
        $setRandId   = $setRandStr . $setRandDate . $setRandTime;
        // return trim($setRands);
        return $setRandId;
    }

    public static function geneRandString($length = 3)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString   = '';
        $upRandomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $upRandomString = strtoupper($randomString);
        return $upRandomString;
    }

    public static function geneName($name, $brand)
    {
        $newName        = substr($name, 0, 1);
        $newBrand       = substr($brand, 0, 2);
        $combineName    = $newName . $newBrand;
        $generateName   = strtoupper($combineName);
        return $generateName;
    }
}
