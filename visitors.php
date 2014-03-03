<?php

require_once 'filereader.php';
$filename = $argv[1];
$visitors = array();
$minuteArray = array();

$reader = new Filereader($filename);
$reader->readFileToArray($visitors);


for ($i = 0; $i < count($visitors); $i++) {
    echo ($i + 1) . ". visitor arrived at: " . $visitors[$i]['arrival'] . " and left at: " . $visitors[$i]['leaving'] . "\n";
}

$max = 0;
$rangeStart = 0;
$rangeEnd = 0;
for ($i = 0; $i < count($visitors); $i++) {
    for ($j = $visitors[$i]['arrival']; $j <= $visitors[$i]['leaving']; $j++) {
        $rangeStartedSet = false;
        $rangeEndSet = false;
        $minuteArray[$j]++;
        if ($minuteArray[$j] > $max) {
            $max = $minuteArray[$j];
            if (!$rangeStartedSet) {
                $rangeStartedSet = true;
                $rangeStart = $j;
            }
            if (!$rangeEndSet && $minuteArray[$j-1] != $rangeStart) {
                $rangeEndSet = true;
                $rangeEnd = $j;
            }
            
        }
    }
}

var_dump($minuteArray);
for($i = 0; $i < count($minuteArray); $i++){
    echo($minuteArray[$i]);
    
}

echo "Biggest number of simultaneous visitors: " .
 $max . " Between times: " . $rangeStart .
 " - " . $rangeEnd;

//$maxVisitors = 0;
//$visitornmb = 1;
//$rangeStart;
//$rangeEnd;
//for ($i = 0; $i < count($visitors); $i++) {
//    $latestArrVisitor = $visitors[$i];
//    $earliestLeaveVisitor = $visitors[$i];
//    for ($j = 0; $j < count($visitors); $j++) {
//        if ($j == $i) {
//            continue;
//        }
//        $print = false;
//        if($i == 2){
//            $print = true;
//        }
//        if (visitorsInTheSameTime($visitors[$i], $visitors[$j], $print)) {    //if visitors were in the museum at the same time
//            $visitornmb++;
//            if (arrivedAfterVisitor($latestArrVisitor, $visitors[$j])) { //if the visitor that is compared at the moment arrived later than latest this far
//                $latestArrVisitor = $visitors[$j];
//                if ($print) echo "latest arr: " . $latestArrVisitor['arrival'] . "\n"; 
//            }
//            if (leftBeforeVisitor($earliestLeaveVisitor, $visitors[$j])) {
//                $earliestLeaveVisitor = $visitors[$j];
//                if ($print) echo "latestLeave: " . $earliestLeaveVisitor['leaving'] . "\n"; 
//            }
//        }
//
//    }
//            echo "round: " . $i . " visitors: ". $visitornmb . "\n";
//    if ($visitornmb > $maxVisitors) {
//        $maxVisitors = $visitornmb;
//        $rangeStart = $latestArrVisitor['arrival'];
//        $rangeEnd = $earliestLeaveVisitor['leaving'];
//    }
//    $visitornmb = 1;
//}


function visitorsInTheSameTime($visitor, $secondVisitor, $print) {

    return (arrivedBeforeVisitorLeft($visitor, $secondVisitor, $print) && arrivedBeforeVisitorLeft($secondVisitor, $visitor, $print));
}

function arrivedAfterVisitor($visitor, $secondVisitor) {
    return timeToMinutes($visitor, 'arrival') <= timeToMinutes($secondVisitor, 'arrival');
}

function leftBeforeVisitor($visitor, $secondVisitor) {
    return timeToMinutes($visitor, 'leaving') >= timeToMinutes($secondVisitor, 'leaving');
}

function arrivedBeforeVisitorLeft($visitor, $secondVisitor, $print) {
    if ($print) {
        echo "visitor leaving: " . $visitor['leaving'] . " Second visitor arrival: " . $secondVisitor['arrival'] . "\n";
        echo "Time to minutes for visitor: " . timeToMinutes($visitor, 'leaving') . "\n";
        echo "Time to minutes for secondvisitor: " . timeToMinutes($secondVisitor, 'arrival') . "\n";
    }
    return timeToMinutes($visitor, 'leaving') >= timeToMinutes($secondVisitor, 'arrival') . "\n";
}

function timeToMinutes($visitor, $arrOrLeave) {
    $hour = hour($visitor, $arrOrLeave);

    $minutes = minute($visitor, $arrOrLeave);
    return ($hour * 60) + $minutes;
}

function hour($visitor, $startOrEnd) {
    return intval(substr($visitor[$startOrEnd], 0, 2));
}

function minute($visitor, $startOrEnd) {
    return intval(substr($visitor[$startOrEnd], 3, 5));
}

