<?php

namespace App\Services;

use App\Folder;
use Illuminate\Support\Facades\Auth;

class GlobalService
{
    public function unserializeForm($str) {
        $returndata = array();
        $strArray = explode("&", $str);
        $i = 0;
        foreach ($strArray as $item) {
            $array = explode("=", $item);
            $returndata[$array[0]] = $array[1];
        }

        return $returndata;
    }

    public function getDate($string)
    {
        $date = strtotime($string);
        $date = date('d/m/Y', $date);
        $date = new \DateTime($date);

        return $date;
    }
}
