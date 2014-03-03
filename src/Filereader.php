<?php
/**
 * Has functions to read a file and put the contents into an array
 * 
 * @package src
 * @author Petri Mäkinen
 */

/**
 * Uses Minute_String_Converter.php to do conversions
 */
require_once 'Minute_String_Converter.php';

/**
 * Can be used to read a file and put its contents into an array
 * 
 * @package src
 */
class Filereader {

    /**
     * The name of the file to be read
     * @var string 
     */
    private $_filename;

    /**
     * Constructs a Filereader object and saves the filename to variable _filename
     * @param type $filename    The name of the file to be read
     */
    public function __construct($filename) {
        $this->_filename = $filename;
    }

    /**
     * Reads a file identified by the filename and puts the contents into an array.
     * 
     * Also calls the lineFormattingOk() method to check that the lines of the
     * file are properly formatted.
     * 
     * @param array $visitors Two dimensional array which will contain the user arrival
     *                      and leaving times in minutes.
     * @param string $filename The name of the file containing the visiting times
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

    /**
     * Extracts the arrival and leaving times of an visitor and puts them into an array
     * 
     * Gets a line from the source file as a parameter. Extracts from the line
     * (which is in format hh:mm,hh:mm where hh means hours and mm minutes in 24
     * hour format) the strings representing the arrival and leaving times of a 
     * visitor. Uses Minute_String_Converter to convert those strings into an
     * integer value of minutes.
     * 
     * The arrival time is saved with a key "arrival" and the leaving time with
     * a key "leaving".
     * 
     * @param string $visitor   A string representing the arrival and leaving times
     * of a visitor
     * @param type $visitors    The array where the times are to be saved
     */
    private function visitingTimeIntoArray($visitor, &$visitors) {
        $in = Minute_String_Converter::stringToMinutes(substr($visitor, 0, 5));
        $out = Minute_String_Converter::stringToMinutes(substr($visitor, -5));
        $visitors[] = array('arrival' => $in,
            'leaving' => $out);
        sort($visitors);
    }

    /**
     * Checks that a given line is in the correct format
     * 
     * The expected format is hh:mm,hh:mm where all h and m are numbers from 0-9.
     * Only checks this condition, doesn't make sure that the given string actually
     * represents a time in 24 hour format.
     * 
     * @param string $visitor A string representing the arrival and leaving times
     * of a visitor
     * @return boolean  Returns true is the format is as expected, otherwise false
     */
    private function lineFormattingOk($visitor) {
        if (preg_match("/^[0-9]{2}:[0-9]{2},[0-9]{2}:[0-9]{2}$/", $visitor) != 1) {
            return false;
        }
        return true;
    }

}