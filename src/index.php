<?php
/**
 * The program is started by running this file. Uses the Visitor_Calculator
 * to calculate the maximum number of visitors and printout the results
 * 
 * PHP version 5
 */
require_once 'Visitor_Calculator.php';
/**
 * Name of the visiting time's file
 */
$filename = $argv[1];

$calculator = new Visitor_Calculator($filename);
$calculator ->findMax();
$calculator -> findRanges();
$calculator ->printResults();

