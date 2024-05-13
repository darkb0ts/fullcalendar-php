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

    if (isset($_POST["id"])) {

        $deleteid = $_POST['id'];
        //echo $notallowed."----".$timing."---".$message."---".$startdate."---".$enddate."---".$id;

        $sql = "DELETE FROM taskmanager WHERE id = $deleteid";

        if (mysqli_query($conn, $sql)) {

            echo "successfully Data delete";                            //--delete day on databse

        } else {

            echo "unable to delete";
        }
    }
    if (isset($_POST["eventid"]) && isset($_POST["delete_event_id"])) {        //-- delete fully event on database

        $delete_id = $_POST["eventid"];

        $delete_event_id = $_POST["delete_event_id"];

        $filename = $_POST['exitpath'];

        $delete = 0;

        if (file_exists($filename)) {

            if (unlink($filename)) {

                $delete = 1;
            }
        }

        $sql = "DELETE FROM taskmanager WHERE  event_id = \"$delete_event_id\";";

        if (mysqli_query($conn, $sql) && $delete == 1) {

            echo "successfully Data delete";
        } else {

            echo "unable to delete";
        }
    }

    mysqli_close($conn);
} else {

    echo "Invaild data";
}

?>