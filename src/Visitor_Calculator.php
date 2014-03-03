<?php

require_once 'Filereader.php';
require_once 'Minute_String_Converter.php';

/**
 * Has methods that can be used to find the maximum number of visitors and the
 * time ranges
 */
class Visitor_Calculator {

    /**
     * Holds the visitors arrival and leaving times in minutes 
     * _visitors[i]['arrival'] has the visitor's arrival time who arrived at 
     * i:th place. Respectively _visitors[i]['leaving'] has the i:th visitor's 
     * leaving time.
     * @var array
     */
    private $_visitors = array();
    
    /**
     * Holds the number of visitors for each minute. The value in index zero 
     * marks the number of visitors when the first visitor arrived and the
     * subsequent indexes hold the number of visitors for every subsequent
     * minute.
     * @var array 
     */
    private $_minuteArray = array();
    
    /**
     * The maximum number of visitors is saved in this variable
     * @var type 
     */
    private $_max;
    
    /**
     * The starting time(s) of the period(s) having the maximum number of people
     * are saved in this array as strings.
     * @var array 
     */
    private $_mostVisitorsStart = array();
    
    /**
     * The ending time(s) of the period(s) having the maximum number of people
     * are saved in this array as strings.
     * @var array
     */
    private $_mostVisitorsEnd = array();
    
    /**
     * The time in minutes when the first visitor arrived
     * @var type 
     */
    private $_firstArrival;

    
    public function __construct($filename) {
        $reader = new Filereader($filename);
        $reader->readFileToArray($this->_visitors);
        $this->_max = 0;
        $this->_firstArrival = $this->_visitors[0]['arrival'];
    }

    /**
     * Finds the maximum number of simultaneous visitors in the museum
     * 
     * Goes through the _visitor array and marks the times when the visitor
     * has been in the museum by increasing the corresponding numbers in the
     * _minuteArray. Saves the number of visitors to the _max variable whenever
     * the _max variable is smaller than the current number in the _minuteArray
     * array.
     * @return int   Returns the maximum number of visitors
     */
    public function findMax() {
        for ($i = 0; $i < count($this->_visitors); $i++) {
            for ($j = ($this->_visitors[$i]['arrival'] - $this->_firstArrival); $j <= ($this->_visitors[$i]['leaving'] - $this->_firstArrival); $j++) {
                $this->_minuteArray[$j]++;
                if ($this->_minuteArray[$j] > $this->_max) {
                    $this->_max = $this->_minuteArray[$j];
                }
            }
        }
        return $this->_max;
    }

    /**
     * Finds the time periods with the maximum number of visitors
     * 
     * Goes through the _minuteArray array and saves the start time(s) of the
     * period(s) with maximum number of people in the array _mostVisitorsStart
     * and correspondingly the end time(s) of the period(s) in the array
     * _mostVisitorsEnd. 
     */
    public function findRanges() {
        for ($i = 0; $i < count($this->_minuteArray); $i++) {
            if ($this->_minuteArray[$i] == $this->_max && ($i == 0 || $this->_minuteArray[$i - 1] != $this->_max)) {
                $this->_mostVisitorsStart[] = Minute_String_Converter::minutesToString(($this->_firstArrival + $i));
            }
            if ($this->_minuteArray[$i] == $this->_max &&
                    ($i == (count($this->_minuteArray) - 1) || $this->_minuteArray[$i + 1] != $this->_max)) {
                $this->_mostVisitorsEnd[] = Minute_String_Converter::minutesToString($this->_firstArrival + $i);
            }
        }
    }

    /**
     * Echos the maximum number of visitors and teh time ranges in standard
     * output
     */
    public function printResults() {
        for ($i = 0; $i < count($this->_mostVisitorsStart); $i++) {
            echo $this->_mostVisitorsStart[$i] . "-" . $this->_mostVisitorsEnd[$i] . ";" . $this->_max;
        }
    }

}
