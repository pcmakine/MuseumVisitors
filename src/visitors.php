<?php
require_once 'Visitor_Calculator.php';
$filename = $argv[1];
if(!file_exists($filename)){
    exit("File not found! Please check the filename and run the program again. Program stopped.");
}

$calculator = new Visitor_Calculator($filename);
$calculator ->findMax();
$calculator -> findRanges();
$calculator ->printResults();

