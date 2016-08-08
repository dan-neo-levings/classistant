<?php

namespace Classistant\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function prettyTime($time) {
        $hour = substr($time, 0, 2);
        $suffix = "AM";
        $minute = substr($time, 3, 2);
        if(intval($hour) > 12) {
            $hour -= 12;
            $suffix = "PM";
        }

        return $hour . ":" . $minute . " " . $suffix;
    }
}
