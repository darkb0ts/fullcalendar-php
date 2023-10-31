<?php

// Create a DateTime object for the start date
$start = new DateTime('2022-06-11');

// Create a DateTime object for the end date
$end = new DateTime('2022-09-01');

// Create a DateInterval object to represent the period between the two dates
$interval = new DateInterval('P1D');

// Iterate over the dates between the start and end dates
$period = new DatePeriod($start, $interval, $end);

// Print each date in the period
$i=0;
foreach ($period as $date) {
  echo print_r($date);
  //echo $date->format('Y-m-d').PHP_EOL;
  echo "_----------------------------------------------------";
}
echo "------";
echo gettype($period);
?>