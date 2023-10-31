<?php
include("./config.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
if (isset($_POST['timing']) && isset($_POST['title'])) {
    $notallowed = $_POST['notallowed'];
    $timing = $_POST['timing'];
    $title=$_POST['title'];
    $startdate=$_POST['start'];
    $enddate=$_POST['end'];
    $colour=$_POST['colour'];
    $start_date = new DateTime($startdate); //-- set start date 
    $end_date = new DateTime($enddate); //-- set end date 
    $sql ="SELECT MAX(event_id) AS id FROM taskmanager"; // Combines timestamp and 16-character random string
    $result=mysqli_query($conn,$sql);
    if ($result){
        $row = mysqli_fetch_assoc($result);
        $event_id=$row['id'];
        $event_id++;
    }else{
        $event_id=1;
    }
//echo $uniqueID;

    if (!empty($notallowed)){  //
        $skip_date = new DateTime($notallowed); //-- set skip date 
    }
   
    $period = new DatePeriod($start_date, new DateInterval('P1D'), $end_date); //-- create object for startdate and enddate 
    //echo $startdate.'T'.$timing.':00.000Z';
    //echo $notallowed,var_dump($notallowed);
    //echo $title."&&&".$timing."&&&".$startdate."&&&".$enddate."&&&".$notallowed."&&&".$colour;
    foreach ($period as $date){
        $dateinsert=$date->format('Y-m-d').PHP_EOL;
        echo $dateinsert;
        if (empty($notallowed)){
            $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`) VALUES ('$event_id','$title','$dateinsert','$enddate','0000-00-00','$timing','$colour')";
            if(mysqli_query($conn, $sql)){
                continue;
            }else{
                echo "Unable to Insert Data";
            }
            echo "if working-------";
        }
        elseif ($date != $skip_date){
            echo "not--allowed-working----------------";
            $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`) VALUES ('$event_id','$title','$dateinsert','$enddate','$notallowed','$timing','$colour')";
            if(mysqli_query($conn, $sql)){
                continue;
            }else{
                echo "Unable to Insert Data";
            }
            echo "elseif working-------";
        }

    }
    echo "Sucessfull Insert";
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
