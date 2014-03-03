<?php

/**
 * Has functions to convert strings to minutes and vice versa
 * 
 * @package src
 * @author Petri Mäkinen
 */

/**
 * Can be used to convert strings to minutes and vice versa
 * 
 * Is designed to with strings that are in the format of hh:mm or
 * hh:mm,hh:mm where h and m are integers from 0 to 9. h means hour and m means
 * minute. All the methods expect this format.
 * 
 * @package src
 * 
 */
class Minute_String_Converter {

    /**
     * Converts a string in the format of hh:mm to a number of minutes
     * 
     * @param type $string  the string to be converted
     * @return int  the number of minutes represented by the given string
     */
    public static function stringToMinutes($string) {
        $hour = self::hour($string);

        $minutes = self::minute($string);
        return ($hour * 60) + $minutes;
    }

    /**
     * Extracts the number of hours from a string that is in the format of hh:mm
     * 
     * @param type $string  The string where the hours are to be extracted
     * @return int     Number of hours extracted from the string
     */
    private static function hour($string) {
        return intval(substr($string, 0, 2));
    }

    /**
     * Extracts the number of minutes from a string that is in the format of hh:mm
     * 
     * @param type $string  The string where the minutes are to be extracted
     * @return int Number of minutes extracted from the string
     */
    private static function minute($string) {
        return intval(substr($string, 3, 5));
    }

    /**
     * Converts a given number of minutes to a string in the format of hh:mm
     * 
     * Uses also the method fixFormat to ensure that the output will have two
     * characters representing the hour and two characters representing the 
     * minutes even though there would be less than ten.
     * 
     * @param int $minutes  The number of minutes to convert to a string
     * @return string   A string representation of the given number of minutes
     */
    public static function minutesToString($minutes) {
        $hours = floor(($minutes / 60));
        $extraMinutes = ($minutes % 60);
        
        $hours = self::fixFormat($hours);
        $extraMinutes = self::fixFormat($extraMinutes);
        $ret = $hours . ":" . $extraMinutes;
        return $ret;
    }

    /**
     * Appends a zero in front of a given number if it is less than ten
     * 
     * @param int $time The number to be checked
     * @return string   String that has a zero in front of the given number if 
     * the number was less than ten.
     */
    private static function fixFormat($time) {
        if ($time < 10) {
            return "0" . $time;
        }
        return $time;
    }

}