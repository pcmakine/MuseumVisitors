<?php
/**
 * The program is started by running this file. 
 * 
 * Uses the Visitor_Calculator to calculate the maximum number of visitors and 
 * printout the results.
 * 
 * It should be noted that the Filereader does not check whether there are empty
 * lines in the beginning of the source file. That kind of file would produce
 * incorrect results
 * 
 * @package src
 * @author Petri Mäkinen
 */

/**
 * Uses Visitor_Calculator.php
 */
require_once 'Visitor_Calculator.php';

/**
 * Name of the file where the visiting times are listed
 */
$filename = $argv[1];

$calculator = new Visitor_Calculator($filename);
$calculator ->findMax();
$calculator -> findRanges();
$calculator ->printResults();