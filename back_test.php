<?php

$valid_date = [["Saturday", "Sunday"], ["Sunday"], ["Saturday"], ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"]]; 

while ($start_date <= $end_date) {
    $starting_date = $start_date->format('l');
    foreach ($valid_date[0] as $date_check) {
        if ($date_check == $starting_date) {
            $start_date->add(new DateInterval('P1D'));
            $adding = 0;
            break;
        }
    }
    if ($adding == 1) {
        $dates[] = $start_date->format('Y-m-d');
        $start_date->add(new DateInterval('P1D'));
        $adding = 1;
    }
}


$validWeekendDays = ["Saturday", "Sunday"];
$flexibleWeekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

$startDate = new DateTime($start_date); // Assuming $start_date is a valid date string
$endDate = new DateTime($end_date);   // Assuming $end_date is a valid date string

$dates = [];

while ($startDate <= $endDate) {
    $currentDay = $startDate->format('l');

    // Check if current day is a valid weekend day
    if (in_array($currentDay, $validWeekendDays)) {
        $dates[] = $startDate->format('Y-m-d');
    } else if (in_array($currentDay, $flexibleWeekdays)) {
        // Check if the next day is a weekend day
        $nextDay = $startDate->add(new DateInterval('P1D'))->format('l');
        if (in_array($nextDay, $validWeekendDays)) {
            $dates[] = $startDate->format('Y-m-d');
        }
    }

    $startDate->add(new DateInterval('P1D'));
}

echo implode("\n", $dates); // Print dates on separate lines

?>