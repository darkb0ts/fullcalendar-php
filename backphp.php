<?php
/* Database schema  
id	
message	
startdate	
enddate	
notallowed	
timing	
colour	
*/
include("./config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['timing']) && isset($_POST['title'])) {
        //echo json_encode($_POST);
        
        $notallowed = $_POST['notalloweddate'];
        
        $timing = $_POST['timing'];

        $title = $_POST['title'];

        $startdate = $_POST['start'];

        $enddate = $_POST['end'];

        $colour = $_POST['colour'];

        $audioFile = $_FILES['audioFile'];

        $start_date = new DateTime($startdate); //-- set start date 

        $end_date = new DateTime($enddate); //-- set end date
        
        $success_count = 0;
        
        $date_not_check = (empty($notallowed)) ? "" : array_map('trim',explode(",", $notallowed));

        if(!empty($notallowed)){

            
            $formatted_check_dates = array_map(function($date) {
                return DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
            }, $date_not_check);
        }
        else{
            $formatted_check_dates=array();
        }

        $notallowed = (empty($notallowed)) ? "" : array($notallowed); //NA chang into array to check the 

        if (is_array($notallowed)) {
            $notallowed = implode(',',$notallowed);
        }

        $day_not_allowed = $_POST['days'];

        $day_check_allowed =  array_map('trim',explode(",", $day_not_allowed));

        $dates = [];

        $count_insert = 0;

        $message = "";
        
        $owed = 0;
        //------------------------------------------------------------------------------------------

        $targetDirectory = "upload/"; // Specify the directory where you want to store the uploaded audio files

        $targetFile = $targetDirectory . uniqid() . '.' . strtolower(pathinfo($_FILES["audioFile"]["name"], PATHINFO_EXTENSION));

        $filename = $_FILES["audioFile"]["name"];

        $uploadOk = 1;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        //------------------------------------------------------------------------------------------

        $sql = "SELECT MAX(event_id) AS id FROM taskmanager"; // Combines timestamp and 16-character random string

        $result = mysqli_query($conn, $sql);

        if ($result) {

            $row = mysqli_fetch_assoc($result);

            $event_id = $row['id'];                                   //-- fetch event id from database and create new id for new event.

            $event_id++;
        
        } else {

            $event_id = 1;
        }
        //---------------------------------------------------------------------------

        if ($fileType != "mp3" && $fileType != "wav" && $fileType != "ogg") {

            $message = "Sorry, only MP3, WAV, and OGG audio files are allowed. ";

            $uploadOk = 0;
        } else {

            if (move_uploaded_file($_FILES["audioFile"]["tmp_name"], $targetFile)) {

                $message = "The audio file " . basename($_FILES["audioFile"]["name"]) . " has been uploaded ";

                //echo "The audio file " . basename($_FILES["audioFile"]['tmp_name']);
                $uploadOk = 1;

            } else {

                $uploadOk = 0;

                $message = "Sorry, there was an error uploading your audio file. ";
            }
        }

        while ($start_date <= $end_date) {
            $formatted_day = substr($start_date->format('l'),0,3); // Get short weekday name (Mon-Sun)
            if (!in_array($formatted_day, $day_check_allowed)) { // Check if the day is in the allowed days array
                $dates[] = $start_date->format('Y-m-d'); // Add the date to the array
                $success_count++;
            }
            $start_date->add(new DateInterval('P1D')); // Add one day
        }
        $dates_count = count($dates);

        if ($dates_count >= 2) {


            foreach ($dates as $date) {

                $dateinsert = $date . PHP_EOL;

                if (!in_array($date,$formatted_check_dates) && $uploadOk == 1) {
                    //echo "---".$dateinsert."------".$notallowed."<br>";

                    $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`, `days`,`audio`,`audioname`) VALUES ('$event_id','$title','$dateinsert','$enddate','$notallowed','$timing','$colour','$day_not_allowed','$targetFile','$filename')";

                    if (mysqli_query($conn, $sql)) {

                        ++$count_insert;
                        //echo $count_insert."-";
                    } else {

                        echo "Something Went Wrong. Please Try again on Date";
                        return;

                    }
                } else {

                    $dates_count -= 1;
                    
                }
            }
        } else {

            $notallowed = "";

            $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`, `days`,`audio`,`audioname`) VALUES ('$event_id','$title','$startdate','$enddate','$notallowed','$timing','$colour','$day_not_allowed','$targetFile','$filename')";

            if (mysqli_query($conn, $sql)) {

                $count_insert = 1;

                $uploadOk = 1;

                echo $message . " and Successfull";

                mysqli_close($conn);

                return;
            } else {

                echo "Something Went Wrong. Please Try again";
            }
        }
        mysqli_close($conn);
        if($uploadOk){
            echo "Successfull";
        }
       
    } else {

        echo "Please Again";
    }
}

?>