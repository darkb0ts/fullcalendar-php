<?php
include('config.php');
?>
<!doctype html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Time based Unit</title>
      
      <!-- Favicon -->
        <!-- Favicon -->
      <link rel="shortcut icon" href="https://templates.iqonic.design/calendify/html/assets/images/favicon.ico" />
      
      <link rel="stylesheet" href="../assets/css/backend.minf700.css?v=1.0.1">
      <link rel="stylesheet" href="../assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">    <!-- Fullcalender CSS -->
    <link rel='stylesheet' href='../assets/vendor/fullcalendar/core/main.css' />
    <link rel='stylesheet' href='../assets/vendor/fullcalendar/daygrid/main.css' />
    <link rel='stylesheet' href='../assets/vendor/fullcalendar/timegrid/main.css' />
    <link rel='stylesheet' href='../assets/vendor/fullcalendar/list/main.css' />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
  <body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->

    <script>
     var   calendar1
           document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar1');

            calendar1 = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                plugins: ["timeGrid", "dayGrid", "list", "interaction"],
                timeZone: "UTC",
                defaultView: "dayGridMonth",
                contentHeight: "auto",
                eventLimit: true,
                dayMaxEvents: 4,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
                },
                eventClick: function(info) {
                    var eventid= {"id":info.event.id};
                    $.ajax({
                type: 'POST',
                url: "popup.php",
                data: eventid,
                success: function(response) {
                    //console.log(response);
                    const jsonObject = JSON.parse(response);
                    //console.log(jsonObject);
                    const id=jsonObject[0].id;
                    const mes= jsonObject[0].message;
                    const startdate = jsonObject[0].startdate;
                    const enddate = jsonObject[0].enddate;
                    const notallowed = jsonObject[0].notallowed;
                    const times = jsonObject[0].timing;
                  $('#date-event1 #schedule-title-sss').val(mes);
                  $('#date-event1 #schedule-start-sss').val(startdate);
                  $('#date-event1 #schedule-end-sss').val(enddate);
                  $('#date-event1 #schedule-Notallowed-sss').val(notallowed);
                  $('#date-event1 #schedule-timinigs-sss').val(times);
                  $('#edit_id').val(id);
                },
              });
                    $('#date-event1').modal('show')
  },
                dateClick: function (info) {
                    $('#schedule-start-date').val(info.dateStr)
                    $('#schedule-end-date').val(info.dateStr)
                    $('#date-event').modal('show')
                   
                   
                  
                },
                events: [
                    <?php


  

$sql = "SELECT * FROM taskmanager";
$result = mysqli_query($conn, $sql);

$events = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}

// Output the JavaScript code
foreach ($events as $event) {
    echo "{\n";
        echo "    id: '" . $event['id'] . "',";
        echo "    title: '" . $event['message'] . "',";
        echo "    start: '" . $event['startdate'] . 'T'.$event['timing'].'.000Z'."',";
        //secho "    end: '" .$event['enddate'] .'T'.$event['timing'].'.000Z'."',";
        echo "    color: '" .$event['colour'] ."',";
        echo "    notallowed: '" .$event['notallowed'] ."',";
        echo "    timing: '" .$event['timing'] ."',";
        echo "},\n";
}

mysqli_close($conn);
?>  
                ]
            });
            calendar1.render();
        });

        $(document).on("submit", "#submit-schedule", function (e) {
            e.preventDefault()
            const title = $(this).find('#schedule-title').val()
            const timing =$(this).find('#schedule-timinigs').val()
            const startDate = moment(new Date($(this).find('#schedule-start-date').val()), 'YYYY-MM-DD').format('YYYY-MM-DD') + "T"+$(this).find('#schedule-timinigs').val()+':00.000Z'
            const endDate = moment(new Date($(this).find('#schedule-end-date').val()), 'YYYY-MM-DD').format('YYYY-MM-DD') + "T"+$(this).find('#schedule-timinigs').val()+':00.000Z'
            const color = $(this).find('#schedule-color').val()
            const notallowed =$(this).find('#schedule-Notallowed').val()
            
            console.log(startDate, endDate, color,timing)   
            const event = {
                title: title,
                start: startDate,
                end: endDate,
                color: color || '#7858d7',
                time:timing,
                notallowed: notallowed
            }
            $(this).closest('#date-event').modal('hide')
            calendar1.addEvent(event)
            const jsonevent = {
                title: title,
            } 
            //jsonevent['title']=title;
            jsonevent['start']= $(this).find('#schedule-start-date').val();
            jsonevent['end']=$(this).find('#schedule-end-date').val()
            jsonevent["colour"]=color;
            jsonevent["notallowed"]=notallowed;                 //adding notallowed daying
            jsonevent["timing"]=timing;                        //addind timing
              //console.log(jsonevent);
              $.ajax({
                type: 'POST',
                url: "backphp.php",
                data: jsonevent,
                success: function(response) {
                  // Handle the successful response
                  alert(response);
                  //location.reload();
                  $('#date-event #schedule-title').val('');
                  $('#date-event #schedule-end-date').val('');
                  $('#date-event #schedule-Notallowed').val('');
                  $('#date-event #schedule-timinigs').val('');
                },
              });



        })
      

      
      
    </script>
    <div id="loading">
          <div id="loading-center">
          </div>
    </div>==
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
      <div class="iq-top-navbar">
          <div class="container">
              <div class="iq-navbar-custom">
                  <div class="d-flex align-items-center justify-content-between">
                      <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                         
                          <a href="index.html" class="header-logo">
                              <img src="../assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                              <img src="../assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo">
                          </a>
                      </div>
                      
                      <nav class="navbar navbar-expand-lg navbar-light p-0">
                          <div class="change-mode">
                              <div class="custom-control custom-switch custom-switch-icon custom-control-indivne">
                                  <div class="custom-switch-inner">
                                      <p class="mb-0"> </p>
                                      <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                                      <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                          <span class="switch-icon-left"><i class="a-left ri-moon-clear-line"></i></span>
                                          <span class="switch-icon-right"><i class="a-right ri-sun-line"></i></span>
                                      </label>
                                  </div>
                              </div>
                          </div>
                          
                         
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                              </ul>
                          </div>
                      </nav>
                  </div>
              </div>
          </div>
      </div>
      <div class="content-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="py-4 border-bottom">
                    <div class="form-title text-center">
                        <h3>My Schedule</h3>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-12">
                
                <div class="d-flex flex-wrap align-items-center justify-content-between my-schedule mb-4">
                   <div class="d-flex align-items-center justify-content-between"> 
                        <div class="form-group mb-0">

                        </div>
                        <div class="select-dropdown input-prepend input-append">
                            <div class="btn-group">
                               
                                <ul class="dropdown-menu w-100 border-none p-3">
                                    <li><div class="item mb-2"><i class="ri-pencil-line mr-3"  ></i>Edit</div></li>
                                    <li><div class="item"><i class="ri-delete-bin-6-line mr-3"></i>Delete</div></li>
                                </ul>
                            </div>
                        </div>
                    </div>  
                    <div class="create-workform">
                        <a href="#" data-toggle="modal" data-target="#date-event" class="btn btn-primary pr-5 position-relative">New Schedule<span class="add-btn"><i class="ri-add-line"></i></span></a>
                    </div>                 
                </div>
                <h4 class="mb-3">Set Your weekly hours</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-block card-stretch">
                            <div class="card-body">
                                <div id="calendar1" class="calendar-s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="date-event" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Add Message</h4>
                        <form action="https://templates.iqonic.design/" id="submit-schedule">
                            <div class="content create-workform row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-title">Schedule For</label>
                                        <input class="form-control" placeholder="Enter Title" type="text" name="message" id="schedule-title" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-start-date">Start Date</label>
                                        <input type="date" value="09/10/2023" type="text" name="startdate" id="schedule-start-date"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-end-date">End Date</label>
                                        <input type="date" value="2023-011-20" type="text" name="enddate" id="schedule-end-date" />
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-Notallowed">Not Allowed</label>
                                        <input type="date" value="2023-011-20" type="text" name="notallowed" id="schedule-Notallowed" />
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-timinigs">Timings</label><br>
                                        <input type="Time" span class="fc-time" name="timing" id="schedule-timinigs" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="color" name="title" id="schedule-color" required />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                        <button class="btn btn-primary mr-4" data-dismiss="modal">Cancel</button>
                                        <!-- <button class="btn btn-primary mr-4" data-dismiss="modal">Delete</button> -->
                                        <button class="btn btn-outline-primary mr-4" type="submit">Save</button>
                                        <!-- <button class="btn btn-primary mr-4" id="editButton" data-dismiss="modal">Edit</button> -->
                                    </div>
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
      </div>
    </div>

    <!--MODAL -->

    <div class="modal fade" id="date-event1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Edit Message</h4>
                        <input type="hidden" id="edit_id">
                        <form action="https://templates.iqonic.design/" id="edit-schedule">
                            <div class="content create-workform row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-title">Schedule For</label>
                                        <input class="form-control" placeholder="Enter Title" type="text" name="message" id="schedule-title-sss" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-start-sss">Start Date</label>
                                        <input type="date" value="09/10/2023" type="text" name="startdate" id="schedule-start-sss"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-end-sss">End Date</label>
                                        <input type="date" value="2023-011-20" type="text" name="enddate" id="schedule-end-sss" />
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-Notallowed">Not Allowed</label>
                                        <input type="date" value="2023-011-20" type="text" name="notallowed" id="schedule-Notallowed-sss" />
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-timinigs">Timings</label><br>
                                        <input type="Time" span class="fc-time" name="timing" id="schedule-timinigs-sss" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="color" name="title" id="schedule-color" required />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                        <!-- <button class="btn btn-primary mr-4" data-dismiss="modal">Cancel</button> -->
                                        <button class="btn btn-primary mr-4" type="button" id="delete_form">DeleteDay</button>
                                        <button class="btn btn-primary mr-4" id="editButton" id="EditEvent">EditDay</button> 
                                        <button class="btn btn-primary mr-4" id="editButton" id="DeleteEvent">DeleteEvent</button> 
                                        <button class="btn btn-primary mr-4" type="button" id="edit_form">Update</button>
                                    </div>
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="popup text-left" id="popup">
                <h4 class="mb-3">Add Action</h4>
                <div class="content create-workform">
                    <div class="form-group">
                      <h6 class="form-label mb-3">Copy Your Link</h6>
                      <div class="input-group">
                        <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2"><i class="las la-link"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <h6 class="form-label mb-3">Email Your Link</h6>
                      <div class="input-group">
                        <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <h6 class="form-label mb-3">Add to Your Website</h6>
                      <div class="input-group">
                        <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon4"><i class="las la-code"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                            <button type="submit" data-dismiss="modal" class="btn btn-primary mr-4">Cancel</button>
                            <button type="submit" data-dismiss="modal" class="btn btn-outline-primary">Save</button>
                        </div>
                    </div>  
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Wrapper End-->
    <!-- <footer class="iq-footer">
        <div class="container-fluid container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    Copyright <span id="currentYear"></span> <a href="#"> Calendify</a> All Rights Reserved.
                </div>
            </div>
        </div>
    </footer> -->
 <script src="../assets/js/backend-bundle.min.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script src="../assets/js/customizer.js"></script>
    
    <!-- Fullcalender Javascript -->
    <script src='../assets/vendor/fullcalendar/core/main.js'></script>
    <script src='../assets/vendor/fullcalendar/daygrid/main.js'></script>
    <script src='../assets/vendor/fullcalendar/timegrid/main.js'></script>
    <script src='../assets/vendor/fullcalendar/list/main.js'></script>
    <script src='../assets/vendor/fullcalendar/interaction/main.js'></script>
    
    <!-- app JavaScript -->
    <script src="../assets/js/app.js"></script>
<script>
      $('#edit_form').on('click', function() {
        var message =$('#schedule-title-sss').val();
        var startdate = $('#schedule-start-sss').val();
        var enddate =$('#schedule-end-sss').val();
        var notallowed = $('#schedule-timinigs-sss').val();
        var times = $('#schedule-Notallowed-sss').val();
        var edit_id = $('#edit_id').val();
        // console.log(message,startdate,enddate,notallowed,times,edit_id);
        // alert(message);
        var jsonData = {
  message: message,
  startdate: startdate,
  enddate: enddate,
  notallowed: notallowed,
  times: times,
  edit_id: edit_id
};
$.ajax({
  type: "POST",
  url: "edit&delete.php",
  data: jsonData,
  success: function(response) {
    // Handle the response from the server
    alert(response);
  }
});
       
});
$('#delete_form').on('click', function() {
        alert("delete click");
});
</script>  </body>
</html>