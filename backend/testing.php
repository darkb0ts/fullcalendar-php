<?php

$start_date = new DateTime('2023-10-01');
$end_date = new DateTime('2023-10-01');

$dates = [];
while ($start_date <= $end_date) {
    $dates[] = $start_date->format('Y-m-d');
    $start_date->add(new DateInterval('P1D'));
}
$arrLength = count($dates);
echo $arrLength."----";
foreach ($dates as $date) {
    echo $date . PHP_EOL."<br>";
}

?>