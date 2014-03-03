<?php

require_once 'Minute_String_Converter.php';

class Filereader {

    private $_filename;

    public function __construct($filename) {
        $this->_filename = $filename;
    }

    /**
     * Reads a file identified by the filename and puts the contents into the
     * $visitors array. Also calls the lineFormattingOk() method to check that the
     * lines of the file contain the times in the correct format.
     * @param type $visitors Two dimensional array which will contain the user arrival
     *                      and leaving times as strings.
     * @param type $filename The name of the file containing the visiting times
     */
    public function readFileToArray(&$visitors) {
        $handle = fopen($this->_filename, "r")
                or exit("Failed to open the file. Please check the filename and run the program again.");
        $i = 0;

        while ($userinfo = fscanf($handle, "%s")) {
            $visitor = $userinfo[0];

            if (!$this->lineFormattingOk($visitor)) {
                echo "wrong formatting on line " . ($i + 1) .
                "! Please check that the times are supplied in format \"hh:mm,hh:mm\", " .
                "where the part before the comma is the arrival time in hours and minutes " .
                "and the part after the comma is the leaving time in hours and minutes\n";
            }

            $this->visitingTimeIntoArray($visitor, $visitors);
            $i++;
        }

        fclose($handle);
    }

    private function visitingTimeIntoArray($visitor, &$visitors) {
        $in = Minute_String_Converter::stringToMinutes(substr($visitor, 0, 5));
        $out = Minute_String_Converter::stringToMinutes(substr($visitor, -5));
        $visitors[] = array('arrival' => $in,
            'leaving' => $out);
        sort($visitors);
    }

    private function stringToMinutes($string) {
        $hour = $this->hour($string);

        $minutes = $this->minute($string);
        return ($hour * 60) + $minutes;
    }

    private function hour($string) {
        return intval(substr($string, 0, 2));
    }

    private function minute($string) {
        return intval(substr($string, 3, 5));
    }

    private function lineFormattingOk($visitor) {
        if (preg_match("/^[0-9]{2}:[0-9]{2},[0-9]{2}:[0-9]{2}$/", $visitor) != 1) {
            return false;
        }
        return true;
    }

}