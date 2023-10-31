<?php
include("./config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id'])){
        $eventid=$_POST['id'];
        $sql = "SELECT `id`,`message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour` FROM `taskmanager` WHERE id = $eventid";
        $result=mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $events[] = $row;
            }
        }
        echo json_encode($events);
        mysqli_close($conn);
    }

}
else{
    echo "Invaild data";
}
?>