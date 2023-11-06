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
    if(isset($_POST['message']) && isset($_POST['times'])){
        $timing = $_POST['times'];
        $message=$_POST['message'];
        $id=$_POST['id'];
        $colour=$_POST["colour"];
        
        $audioFile=$_FILES['audioFile'];
        if(!isset($audioFile)){
            echo "22222222222222222";
            echo json_encode($_POST);
            $sql = "UPDATE taskmanager SET message = '$message', timing='$timing' , colour='$colour' WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                echo " Record updated successfully.";
            } else {
                echo " Error updating record: " . mysqli_error($conn);
            }
        }else{
            echo json_encode($_POST);
            echo "111111111111111111111111111111";
            $exit_file=$_POST["exitpath"];
        $targetDirectory = "upload/"; // Specify the directory where you want to store the uploaded audio files
        $targetFile = $targetDirectory . uniqid() . '.' . strtolower(pathinfo($_FILES["audioFile"]["name"], PATHINFO_EXTENSION));
        $uploadOk = 1;
        $filename=$_FILES["audioFile"]["name"];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($fileType != "mp3" && $fileType != "wav" && $fileType != "ogg") {
            $message="Sorry, only MP3, WAV, and OGG audio files are allowed ";
            $uploadOk = 0;
        }else {
            if (move_uploaded_file($_FILES["audioFile"]["tmp_name"], $targetFile)) {
                $message="The audio file " . basename($_FILES["audioFile"]["name"]) . " has been uploaded ";
                //echo "The audio file " . basename($_FILES["audioFile"]['tmp_name']);
            } else {
                $uploadOk = 0;
                $message="Sorry, there was an error uploading your audio file ";
            }
        }
                if($uploadOk==1){                    //`audio`,`audioname`
            $sql = "UPDATE taskmanager SET message = '$message', timing='$timing' , colour='$colour' , audio='$targetFile', audioname='$filename WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                echo $message ." and Record updated successfully.";
            } else {
                echo $message . " Error updating record: " . mysqli_error($conn);
            }
        }
        }
        
        // //echo $notallowed."----".$timing."---".$message."---".$startdate."---".$enddate."---".$id;
        echo json_encode($_POST);
        //--------------------------------
        // $targetDirectory = "upload/"; // Specify the directory where you want to store the uploaded audio files
        // $targetFile = $targetDirectory . uniqid() . '.' . strtolower(pathinfo($_FILES["audioFile"]["name"], PATHINFO_EXTENSION));
        // $uploadOk = 1;
        // $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        // if ($fileType != "mp3" && $fileType != "wav" && $fileType != "ogg") {
        //     $message="Sorry, only MP3, WAV, and OGG audio files are allowed ";
        //     $uploadOk = 0;
        // }else {
        //     if (move_uploaded_file($_FILES["audioFile"]["tmp_name"], $targetFile)) {
        //         $message="The audio file " . basename($_FILES["audioFile"]["name"]) . " has been uploaded ";
        //         //echo "The audio file " . basename($_FILES["audioFile"]['tmp_name']);
        //     } else {
        //         $uploadOk = 0;
        //         $message="Sorry, there was an error uploading your audio file ";
        //     }
        // }
        // //-----------------------------
        // if($uploadOk==1){                    //`audio`,`audioname`
        //     $sql = "UPDATE taskmanager SET message = '$message', timing='$timing' , colour='$colour' , audio='$targetFile', audioname='$filename WHERE id = $id";
        //     if (mysqli_query($conn, $sql)) {
        //         echo $message ." and Record updated successfully.";
        //     } else {
        //         echo $message . " Error updating record: " . mysqli_error($conn);
        //     }
        // }

    }
    if  (isset($_POST['message']) && isset($_POST['times']) &&isset($_POST["eventid"]) ){      
        $update_id = $_POST["eventid"];
        $timing = $_POST['times'];
        $message=$_POST['message'];
        $startdate=$_POST['startdate'];
        $colour=$_POST["colour"];
        $sql = "UPDATE taskmanager SET message = '$message', startdate = '$startdate' , timing='$timing' , colour='$colour' WHERE event_id =  $update_id";
        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    
    mysqli_close($conn);
}
else{
    echo "Invaild data";
}
?>