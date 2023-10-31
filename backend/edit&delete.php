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
        $notallowed = $_POST['notallowed'];
        $timing = $_POST['times'];
        $message=$_POST['message'];
        $startdate=$_POST['startdate'];
        $enddate=$_POST['enddate'];
        $id=$_POST['edit_id'];
        //echo $notallowed."----".$timing."---".$message."---".$startdate."---".$enddate."---".$id;
        $sql = "UPDATE taskmanager SET message = '$message', startdate = '$startdate' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    // $jsonString = json_encode($_POST);
    // //var_dump($_POST);
    // echo $jsonString;
}
else{
    echo "Invaild data";
}
?>