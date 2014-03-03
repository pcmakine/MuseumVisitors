<?php

class Minute_String_Converter {

    public static function stringToMinutes($string) {
        $hour = self::hour($string);

        $minutes = self::minute($string);
        return ($hour * 60) + $minutes;
    }

    private function hour($string) {
        return intval(substr($string, 0, 2));
    }

    private function minute($string) {
        return intval(substr($string, 3, 5));
    }

    function minutesToString($minutes) {
        $hours = floor(($minutes / 60));
        $extraMinutes = ($minutes % 60);
        self::fixFormat($hours);
        self::fixFormat($extraMinutes);
        $ret = $hours . ":" . $extraMinutes;
        return $ret;
    }

    function fixFormat(&$time) {
        if ($time < 10) {
            return "0" . $time;
        }
    }

}

