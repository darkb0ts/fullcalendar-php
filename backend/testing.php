<?php
include("./config.php");
if  (isset($_GET['message']) && isset($_GET['times']) &&isset($_GET["event_id"]) ){   
    $event_id = $_GET["event_id"];
    $filename = $_GET['exitpath'];
    $notallowed = $_GET['notallowed'];
    $timing = $_GET['times'];
    $title=$_GET['message'];
    $startdate=$_GET['startdate'];
    $enddate=$_GET['enddate'];
    $colour=$_GET['colour'];
    $exitpath=$_GET['exitpath'];
    $audioname=$_GET['audioname'];
    $id=$_GET['id'];
    

// if  (isset($_POST['message']) && isset($_POST['times']) &&isset($_POST["event_id"]) ){
//     echo json_encode($_POST);
//     //--------------------------------------------------------------------------

//     $event_id = $_POST["event_id"];
//     $filename = $_POST['exitpath'];
//     $notallowed = $_POST['notallowed'];
//     $timing = $_POST['times'];
//     $title=$_POST['message'];
//     $startdate=$_POST['startdate'];
//     $enddate=$_POST['enddate'];
//     $colour=$_POST['colour'];
//     $exitpath=$_POST['exitpath'];
//     $audioname=$_POST['audioname'];

    $audioFile="";
    $start_date = new DateTime($startdate); //-- set start date 
    $end_date = new DateTime($enddate); //-- set end date 
    $start_date = new DateTime($startdate);
    $end_date = new DateTime($enddate);
    $notallowed = (empty($notallowed)) ? "0000-00-00" : $notallowed;
    $skip_date = new DateTime($notallowed); 
    $dates = [];
    $count_insert=0;
    $message="";
    $data_deleted=0;
    $check_start_date=0;
    $check_end_date=0;
    //------------------++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++;
    // if(!empty($_GET['audioFile'])){
        
    //     $audioFile = $_FILES['audioFile'];                              //--new file is exits
        
    //     $filename=$_FILES["audioFile"]["name"];
    //     // echo $filename;                                                   
    // }else{
    //     // echo $exitpath,$audioname;                          //--old file is exits
    // }
    //-------------------------------------------------------------------
    
    $sql = "SELECT MIN(startdate) AS min_startdate,MAX(startdate) AS max_startdate FROM taskmanager WHERE event_id = $event_id";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {                                    
      
        $row = mysqli_fetch_assoc($result);                         //!!fetch max date and min date from database
      echo json_encode($row);
      $minDate = $row['min_startdate'];
      
      $maxDate = $row['max_startdate'];
    }
    //-----------------------------------------------------------------------------"  check the start date
    $ischeckvaild = 0;      // default value 

    $startseparate=substr($minDate, -2);     //--old date get by database

    $newstartseparate=substr($startdate, -2);  //--new date get by user
    
    $startdatevalue=$startseparate-$newstartseparate;          //* if value 1 is insert and if value is negative delete
    
    $startmonth_check=explode("-", $minDate);
    
    $newstartmonth_check=explode("-", $startdate);
    if($minDate!=$startdate){                                         //* start date and old date is not same

        if($startmonth_check[1]==$newstartmonth_check[1]){              //* if true - date will be same month

            $ischeckvaild=-1;
            if ($startdatevalue>=1){                 //* start date and same month insert

                $check_start_date=1;
                
                echo "inserting new data";

            }
            elseif($startdatevalue<0){               //* end date and same month delete
                $sql = "DELETE FROM taskmanager WHERE startdate < '$startdate' AND event_id = $event_id";

                if (mysqli_query($conn, $sql)){

                    $check_start_date=0;
                    
                    $data_deleted=1;                     //--check any data is deleted 

                    echo "deleteing new data";

                }
                
            }
        }
        else{                            //* if month is not equal working [insert new date]

            echo "new month insert ";
            
            $ischeckvaild=1;

        }
    }
    else{
        
        echo "no date modified";

    }


//----------------------------------------------           check the end date


//----------------------------------------------
//echo json_encode($_GET)."+++++".$minDate."+++++".$maxDate;
    mysqli_close($conn);

}

?>