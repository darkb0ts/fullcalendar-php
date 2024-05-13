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

        $valid_date = [["Saturday", "Sunday"], ["Sunday"], ["Saturday"], ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"]]; //@@new feature adding custom data for weekend or sunday to saturday leave
        /* vaild date is allowed select insert data 
        [0] - leave sunday and monday
        [1] - leave sunday only
        [2] - leave saturday only
        [3] - leave all working day expect sunday and saturday
        */
        
        $notallowed = $_POST['notallowed'];
        
        $timing = $_POST['timing'];

        $title = $_POST['title'];

        $startdate = $_POST['start'];

        $enddate = $_POST['end'];

        $colour = $_POST['colour'];

        $audioFile = $_FILES['audioFile'];

        $start_date = new DateTime($startdate); //-- set start date 

        $end_date = new DateTime($enddate); //-- set end date 

        $notallowed = (empty($notallowed)) ? "0000-00-00" : $notallowed; //NA chang into array to check the 

        $skip_date = new DateTime($notallowed);  //NA 

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

            $message = "Sorry, only MP3, WAV, and OGG audio files are allowed.";

            $uploadOk = 0;
        } else {

            if (move_uploaded_file($_FILES["audioFile"]["tmp_name"], $targetFile)) {

                $message = "The audio file " . basename($_FILES["audioFile"]["name"]) . " has been uploaded";

                //echo "The audio file " . basename($_FILES["audioFile"]['tmp_name']);
                $uploadOk = 1;

            } else {

                $uploadOk = 0;

                $message = "Sorry, there was an error uploading your audio file.";
            }
        }
        //------------------------------------------------------------------------------------------
        // $adding=1;
        // while ($start_date <= $end_date) {
        //     $starting_date=$start_date->format('l');
        //     foreach ($valid_date[$owed] as $date_check) {
        //         if($date_check == $starting_date){
        //             $start_date->add(new DateInterval('P1D'));
        //             $adding=0;
        //             break;
        //         }
        //     }
        //     // $dates[] = $start_date->format('Y-m-d');
        //     if($adding==1){
        //         $dates[] = $start_date->format('Y-m-d');
        //         $start_date->add(new DateInterval('P1D'));
        //         $adding=1;
        //     }

        // }
        while ($start_date <= $end_date) {

            $dates[] = $start_date->format('Y-m-d');

            $start_date->add(new DateInterval('P1D'));
        }

        $dates_count = count($dates);

        if ($dates_count > 1) {


            foreach ($dates as $date) {

                $dateinsert = $date . PHP_EOL;


                if ($date != $skip_date->format('Y-m-d') && $uploadOk == 1) {
                    //echo "---".$dateinsert."------".$notallowed."<br>";

                    $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`,`audio`,`audioname`) VALUES ('$event_id','$title','$dateinsert','$enddate','$notallowed','$timing','$colour','$targetFile','$filename')";

                    if (mysqli_query($conn, $sql)) {

                        ++$count_insert;
                        //echo $count_insert."-";
                    } else {
                        echo "Unable to Insert";
                    }
                } else {
                    $dates_count -= 1;
                }
            }
        } else {

            $notallowed = "0000-00-00";

            $sql = "INSERT INTO `taskmanager`( `event_id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`,`audio`,`audioname`) VALUES ('$event_id','$title','$startdate','$enddate','$notallowed','$timing','$colour','$targetFile','$filename')";

            if (mysqli_query($conn, $sql)) {

                $count_insert = 1;


                echo $message . " and Successful Insert";

                mysqli_close($conn);

                return;
            } else {

                echo "Unable to Insert Data";
            }
        }


        if ($count_insert == $dates_count) {

            echo $message . " and Successful Insert";
        } else {
            //echo "@--".$count_insert."----".count($dates)."--@";

            echo $message . " and Unable to Insert Datas";
        }

        mysqli_close($conn);
    } else {

        echo "Invalid data received";
    }
}

?>