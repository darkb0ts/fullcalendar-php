<?php
/*

upload [First audio] before playing audio and [Second audio] after upload audio 

button of ON and Off the Gpio

set Time Interval for after playing  [1,30,22]

check the status for Pin 


*/


include("./gpio_database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['selftest']) && $_POST['selftest']==1){
        echo "hello";
    }

    if (isset($_POST['isToggled']) && isset($_POST['count'])) {

        $button_status = htmlspecialchars($_POST['isToggled']);

        $button_time_Interval = $_POST['count'];


        $targetDirectory = "audioBell/"; // Specify the directory where you want to store the uploaded audio files

        $start_audio = $_FILES["startaudio"]["name"];

        $end_audio = $_FILES["endaudio"]["name"];

        $start_temp = $_FILES["startaudio"]["tmp_name"];

        $end_temp = $_FILES["endaudio"]["tmp_name"];

        $First_File = $targetDirectory . uniqid() . '.' . strtolower(pathinfo($start_audio, PATHINFO_EXTENSION));

        $Second_File = $targetDirectory . uniqid() . '.' . strtolower(pathinfo($end_audio, PATHINFO_EXTENSION));

        $uploadOk = 1;

        $fileType1 = strtolower(pathinfo($_FILES["startaudio"]["name"], PATHINFO_EXTENSION));

        $fileType2 = strtolower(pathinfo($Second_File, PATHINFO_EXTENSION));

        if ($fileType1 != "mp3" && $fileType1 != "wav" && $fileType2 != "mp3" && $fileType2 != "wav") {

            $message = "Sorry, only MP3, WAV, and OGG audio files are allowed.";

            $uploadOk = 0;
        } else {

            if (move_uploaded_file($_FILES["startaudio"]["tmp_name"], $First_File)) {

                // move_uploaded_file($end_audio, $Second_File);

                $message = "The audio file " . $First_File . " has been uploaded";

                //echo "The audio file " . basename($_FILES["audioFile"]['tmp_name']);
                $uploadOk = 1;
            }

            if (move_uploaded_file($_FILES["endaudio"]["tmp_name"], $Second_File)) {

                $uploadOk = 1;
            } else {

                $uploadOk = 0;

                $message = "Sorry, there was an error uploading your audio file.";
            }
        }

        if ($uploadOk) {

            $sql = "UPDATE `gpio_setting` 
        SET `start_audio` = '$start_audio', 
            `end_audio` = '$end_audio', 
            `button_status` = '$button_status', 
            `time_interval` = '$button_time_Interval' 
        WHERE `id` = 1";

            if (mysqli_query($conn, $sql)) {

                $count_insert = 1;


                echo $message . " and Successful Insert";

                mysqli_close($conn);

                return;
            } else {
                echo "Unable to Insert Data";
            }
        } else {

            echo "Check the Database Connecting";
        }
        // // !! Pin off or On
        // if($button_status){

        //     //@@ exec for on the pin

        //     echo $message;

        // }
        // else{

        //     //@@ exec off the pin

        //     echo $message;
        // }


        // !! audio off and on using shell_exec
    }

}
