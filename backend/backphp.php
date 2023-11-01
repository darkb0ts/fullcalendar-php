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
    $start_date = new DateTime($startdate);
    $end_date = new DateTime($enddate);
    $notallowed = (empty($notallowed)) ? "0000-00-00" : $notallowed;
    $skip_date = new DateTime($notallowed); 
    echo print_r($skip_date);
    $dates = [];
    $count_insert=0;
    //echo print_r($start_date),print_r($end_date);
    //------------------------------------------------------------------------------------------
    $sql ="SELECT MAX(event_id) AS id FROM taskmanager"; // Combines timestamp and 16-character random string
    $result=mysqli_query($conn,$sql);
    if ($result){
        $row = mysqli_fetch_assoc($result);
        $event_id=$row['id'];                                   //-- fetch event id from database and create new id for new event.
        $event_id++;
    }else{
        $event_id=1;
    }
    //---------------------------------------------------------------------------

while ($start_date <= $end_date) {
    $dates[] = $start_date->format('Y-m-d');
    $start_date->add(new DateInterval('P1D'));
}
if(count($dates)>1){
    foreach ($dates as $date) {
        $dateinsert=$date . PHP_EOL;
        
        if ($date != $skip_date->format('Y-m-d')){
            //echo "---".$dateinsert."------".$notallowed."<br>";
            $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`) VALUES ('$event_id','$title','$dateinsert','$enddate','$notallowed','$timing','$colour')";
            if(mysqli_query($conn, $sql)){
                $count_insert++;
            }else{
                echo "Unable to Insert Data";
            }
        }
        else{
            echo print_r($skip_date);
        }

    }
}
else{
    $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`) VALUES ('$event_id','$title','$startdate','$enddate','$notallowed','$timing','$colour')";
    if(mysqli_query($conn, $sql)){
        $count_insert=1;
    }else{            
    echo "Unable to Insert Data";
    }
}
if($count_insert==count($dates)){
    echo "Successful Insert";
}
else{
    echo "Unable to Insert Data";
}
mysqli_close($conn);
} else {
    echo "Invalid data received";
}
}
?>