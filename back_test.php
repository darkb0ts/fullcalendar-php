<?php
// $start_date = '2023-11-12';
// $startDate = new DateTime($start_date);

// // Example 2: Create a DateTime object for a specific date
// $end_date = '2024-01-25';
// $endDate = new DateTime($end_date);
// $dates = [];

// while ($startDate <= $endDate) {
//     $currentDay = $startDate->format('d');
//     echo $currentDay."<br>";
//     $startDate->add(new DateInterval('P1D'));
// }

// function countSaturdaysInMonth($month, $year) {
//     // Set the first day of the month
//     $firstDayOfMonth = strtotime("$year-$month-01");

//     // Get the total number of days in the month
//     $daysInMonth = date('t', $firstDayOfMonth);

//     // Initialize the counter for Saturdays
//     $saturdayCount = 0;

//     // Loop through each day of the month
//     for ($day = 1; $day <= $daysInMonth; $day++) {
//         // Get the timestamp for the current day
//         $currentDay = strtotime("$year-$month-$day");

//         // Check if the current day is a Saturday (day of week = 6)
//         if (date('w', $currentDay) == 6) {
//             $saturdayCount++;
//         }
//     }

//     return $saturdayCount;
// }

// // Example usage
// $month = 6;  // June
// $year = 2024;
// echo "Number of Saturdays in $month/$year: " . countSaturdaysInMonth($month, $year);

// function countSaturdaysBetweenDates($startDate, $endDate) {
//     // Convert the start and end dates to timestamps
//     $startTimestamp = strtotime($startDate);
//     $endTimestamp = strtotime($endDate);

//     // Initialize the counter for Saturdays
//     $saturdayCount = 0;

//     // Loop through each day between the start and end dates
//     for ($currentTimestamp = $startTimestamp; $currentTimestamp <= $endTimestamp; $currentTimestamp = strtotime('+1 day', $currentTimestamp)) {
//         // Check if the current day is a Saturday (day of week = 6)
//         if (date('w', $currentTimestamp) == 6) {
//             $saturdayCount++;
//         }
//     }

//     return $saturdayCount;
// }

// // Example usage
// $startDate = '06/11/2024';
// $endDate = '09/11/2024';
// echo "Number of Saturdays between $startDate and $endDate: " . countSaturdaysBetweenDates($startDate, $endDate);


// $check1 = strtotime($startDate);
// $check2 = strtotime($endDate);

// while ($check1 < $check2) {
//   echo date('d-m-Y', $check1) . PHP_EOL; // Print date with newline
//   $check1 = strtotime("1+day", $check1);
// }

// function countSaturdaysBetweenDates($startDate, $endDate) {
//     // Convert the start and end dates to timestamps
//     $startTimestamp = strtotime($startDate);
//     $endTimestamp = strtotime($endDate);

//     // Initialize the counter for Saturdays
//     $saturdayCount = 0;

//     // Iterate through each day between the start and end dates
//     while ($startTimestamp <= $endTimestamp) {
//         // Print the current date
//         echo date('d-m-Y', $startTimestamp) . PHP_EOL;

//         // Check if the current day is a Saturday (day of week = 6)
//         if (date('w', $startTimestamp) == 6) {
//             $saturdayCount++;
//         }

//         // Move to the next day
//         $startTimestamp = strtotime("+1 day", $startTimestamp);
//     }

//     return $saturdayCount;
// }

// // Example usage
$startDate = '06/01/2024';
$endDate = '07/01/2024';
// echo "Number of Saturdays between $startDate and $endDate: " . countSaturdaysBetweenDates($startDate, $endDate) . PHP_EOL;

$start_date = new DateTime($startDate);
$end_date = new DateTime($endDate);
$saturday_check = array(1,2,3,4,5);    //five saturday 0 mean 1 saturday and 1 mean 2 saturday and 2 mean 3 saturday 
$dates= [];
$sat_count = 0;
$day_check_allowed = array('Sun','Mon','Tue');

while ($start_date < $end_date){
    $check_day = $start_date->format('d');
    $saturday_count = $start_date->format('w');
    $formatted_day = substr($start_date->format('l'),0,3);

    if ((int)$check_day == 01 && (int)$check_day <= 07){
        $sat_count = 0; 
    }
    if($saturday_count == 6){
        $sat_count++;
    }
    if($saturday_count == 6 && in_array($sat_count,$saturday_check)){
        $start_date->add(new DateInterval('P1D'));
        continue;
    }
    elseif (!in_array($formatted_day, $day_check_allowed)) { // Check if the day is in the allowed days array
        $dates[] = $start_date->format('Y-m-d'); // Add the date to the array
        $start_date->add(new DateInterval('P1D'));
        continue;
    }
    else{
        $start_date->add(new DateInterval('P1D'));
    }
}
foreach ($dates as $date) {
    echo $date . PHP_EOL.'<br>'; // Print each date on a new line
  }
?>