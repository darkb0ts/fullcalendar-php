<?php
include("./config.php");
static $event_count = 1;
function generateUniqueNumberId() {
    // Get the current timestamp in microseconds.
    $timestamp = microtime(true);
  
    // Generate a random number.
    $randomNumber = rand(1, 9999999);
  
    // Combine the timestamp and random number to create a unique ID.
    $uniqueId = $timestamp . $randomNumber;
  
    // Return the unique ID.
    return $uniqueId;
  }
  
$uniqueId = generateUniqueNumberId();
  
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
if (isset($_POST['timing']) && isset($_POST['title'])) {
    
    $notallowed = $_POST['notallowed'];
    $timing = $_POST['timing'];
    $title=$_POST['title'];
    $startdate=$_POST['start'];
    $enddate=$_POST['end'];
    $colour=$_POST['colour'];
    echo $uniqueId;
    $StartyearMonth = substr($startdate, 0, 7); //-- Seperate the  FIRST 4 digit from [YYYY-MM-DD] in Starting date
    $EndyearMonth = substr($enddate, 0, 7);     //-- Seperate the  FIRST 4 digit from [YYYY-MM-DD] in Ending date
    $sday = intval(explode("-", $startdate)[2]);        //-- string into interger and Seperate the  last 2 digit from [YYYY-MM-DD] in Starting date
    $eday=intval(explode("-", $enddate)[2]);           //-- string into interger and  Seperate the  last 2 digit from [YYYY-MM-DD] in Ending date
    
    $checking=0;
    if (empty($notallowed)) {                            //-- notallowed is empty set '0000-00-00"
        $notallowed="0000-00-00";
        $nday=0;
      } else {
        $nday=intval(explode("-", $notallowed)[2]);
      }
    //echo $startdate.'T'.$timing.':00.000Z';
    //echo $notallowed,var_dump($notallowed);
    //echo $title."&&&".$timing."&&&".$startdate."&&&".$enddate."&&&".$notallowed."&&&".$colour;
    for($x=$sday;$x<=$eday;$x++){
        $dateinsert=$StartyearMonth."-".$x; //--manual insert  [YYYY-MM-DD]
        if($x==$nday){
            continue;
        }else{
            $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`) VALUES ('$event_count','$title','$dateinsert','$enddate','$notallowed','$timing','$colour')";
            //echo $dateinsert,"---";
            mysqli_query($conn, $sql);
        }
        $checking=$x;  //--check the full insert in database
    }
    if ($checking==$eday) {                  //--check the dummy value and eday value  for database insert 
        echo "New record created successfully";
        $event_count++;
        $GLOBALS['event_count'];
    } else {
        //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "Unable to Insert Data";
    }

    mysqli_close($conn);
}
// echo $title;
// $postData = $_POST;                            //!!view the full data in php
// $jsonData = json_encode($postData);
// echo $jsonData;
} else {
    // Handle the case where "notallowed" and "timing" are not set in the POST data
    echo "Invalid data received";
}
?>
