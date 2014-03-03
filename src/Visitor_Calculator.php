<?php

require_once 'Filereader.php';
require_once 'Minute_String_Converter.php';

class Visitor_Calculator {

    private $_visitors = array();
    private $_minuteArray = array();
    private $_max;
    private $_mostVisitorsStart = array();
    private $_mostVisitorsEnd = array();
    private $_firstArrival;

    public function __construct($filename) {
        $reader = new Filereader($filename);
        $reader->readFileToArray($this->_visitors);
        $this->_max = 0;
        $this->_firstArrival = $this->_visitors[0]['arrival'];
    }

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

    public function printResults() {
        for ($i = 0; $i < count($this->_mostVisitorsStart); $i++) {
            echo $this->_mostVisitorsStart[$i] . "-" . $this->_mostVisitorsEnd[$i] . ";" . $this->_max;
        }
    }

}
