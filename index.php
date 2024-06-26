<?php
include('config.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Time based Unit</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
    <link rel="shortcut icon" href="https://templates.iqonic.design/calendify/html./assets/images/favicon.ico" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/backend.minf700.css?v=1.0.1">
    <link rel="stylesheet" href="./assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./assets/vendor/remixicon/fonts/remixicon.css"> <!-- Fullcalender CSS -->
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/core/main.css' />
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/daygrid/main.css' />
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/timegrid/main.css' />
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/list/main.css' />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>

<body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->

    <script>
        var calendar1
        document.addEventListener('DOMContentLoaded', function() {
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
                    //var event_id=$('#event_id').val();
                    var eventid = {
                        "id": info.event.id
                    };
                    console.log(eventid);
                    $.ajax({
                        type: 'POST',
                        url: "popup.php",
                        data: eventid,
                        success: function(response) {
                            //console.log(response);
                            const jsonObject = JSON.parse(response);
                            console.log(jsonObject);
                            const id = jsonObject[0].id;
                            const event_id = jsonObject[0].event_id;
                            const mes = jsonObject[0].message;
                            const startdate = jsonObject[0].startdate;
                            const enddate = jsonObject[0].enddate;
                            const notallowed = jsonObject[0].notallowed;
                            const times = jsonObject[0].timing;
                            const colour = jsonObject[0].colour;
                            const audioName = jsonObject[0].audioname;
                            const audio = jsonObject[0].audio;
                            const min_date = jsonObject[1].min_startdate;
                            $('#date-event1 #schedule-title-sss').val(mes);
                            $('#date-event1 #schedule-start-sss').val(min_date); //--fecth data from database show the min_date limit
                            $('#date-event1 #schedule-end-sss').val(enddate);
                            $('#date-event1 #schedule-Notallowed-sss').val(notallowed);
                            $('#date-event1 #schedule-timinigs-sss').val(times);
                            $('#date-event1 #schedule-color-sss').val(colour);
                            $('#date-event1 #audioPath').val(audio);
                            $('#edit_id').val(id);
                            //$('#mindate_id').val(min_date);
                            $('#event_id').val(event_id)
                            $('#showaudio').attr('href', audio);
                            document.getElementById('showaudio').textContent = audioName;

                        },
                    });
                    $('#date-event1').modal('show')
                },
                dateClick: function(info) {
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
                        echo "    start: '" . $event['startdate'] . 'T' . $event['timing'] . '.000Z' . "',";  //--start date for default 
                        echo "    end: '" . $event['startdate'] . 'T' . $event['timing'] . '.000Z' . "',";
                        echo "    color: '" . $event['colour'] . "',";
                        echo "    notallowed: '" . $event['notallowed'] . "',";
                        echo "    timing: '" . $event['timing'] . "',";
                        echo "},\n";
                    }

                    mysqli_close($conn);
                    ?>
                ]
            });
            calendar1.render();
        });

        $(document).on("submit", "#submit-schedule", function(e) {
            $('.js-example-basic-single').select2();
            e.preventDefault()
            const title = $(this).find('#schedule-title').val()
            const timing = $(this).find('#schedule-timinigs').val()
            const startDate = moment(new Date($(this).find('#schedule-start-date').val()), 'YYYY-MM-DD').format('YYYY-MM-DD') + "T" + $(this).find('#schedule-timinigs').val() + ':00.000Z'
            const endDate = moment(new Date($(this).find('#schedule-end-date').val()), 'YYYY-MM-DD').format('YYYY-MM-DD') + "T" + $(this).find('#schedule-timinigs').val() + ':00.000Z'
            const color = $(this).find('#schedule-color').val()
            const notallowed = $(this).find('#schedule-Notallowed').val()
            //const audiofile= document.getElementById("audioFile").files[0];
            //console.log(audiofile);
            var notallowedcheck = new Date(notallowed);
            var notallowedvalue = notallowed ? 1 : 0;
            var startDatecheck = new Date(startDate);
            var endDatecheck = new Date(endDate);
            //console.log(notallowed,notallowedcheck,notallowedvalue,notallowedcheck >= startDatecheck && notallowedcheck <= endDatecheck);
            //var notallowedcheck="0000-00-00";
            if (notallowedvalue == 1 && notallowedcheck >= startDatecheck && notallowedcheck <= endDatecheck) {
                const event = {
                    title: title,
                    start: startDate,
                    end: endDate,
                    color: color || '#7858d7',
                    time: timing,
                    notallowed: notallowed
                }
                $(this).closest('#date-event').modal('hide')
                calendar1.addEvent(event)
                var formData = new FormData();
                formData.append("title", title);
                formData.append("start", $(this).find('#schedule-start-date').val());
                formData.append("end", $(this).find('#schedule-end-date').val());
                formData.append("colour", color); //["notallowed"]=notallowed; 
                formData.append("notallowed", notallowed);
                formData.append("timing", timing);
                formData.append("audioFile", $("#audioFile_pop")[0].files[0]);
                // for (var pair of formData.entries()) {
                //     console.log(pair[0] + ': ' + pair[1]);
                // }
                $.ajax({
                    type: "POST",
                    url: "backphp.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle the successful response
                        alert(response);
                        location.reload();
                        $('#date-event #schedule-title').val('');
                        $('#date-event #schedule-end-date').val('');
                        $('#date-event #schedule-Notallowed').val('');
                        $('#date-event #schedule-timinigs').val('');
                    },
                });
            } else if (notallowedvalue == 0) {
                const event = {
                    title: title,
                    start: startDate,
                    end: endDate,
                    color: color || '#7858d7',
                    time: timing,
                    notallowed: notallowed
                }
                $(this).closest('#date-event').modal('hide')
                calendar1.addEvent(event)
                var formData = new FormData();
                formData.append("title", title);
                formData.append("start", $(this).find('#schedule-start-date').val());
                formData.append("end", $(this).find('#schedule-end-date').val());
                formData.append("colour", color); //["notallowed"]=notallowed; 
                formData.append("notallowed", notallowed);
                formData.append("timing", timing);
                formData.append("audioFile", $("#audioFile_pop")[0].files[0]);
                // for (var pair of formData.entries()) {
                //     console.log(pair[0] + ': ' + pair[1]);
                // }
                $.ajax({
                    type: "POST",
                    url: "backphp.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle the successful response
                        alert(response);
                        location.reload();
                        $('#date-event #schedule-title').val('');
                        $('#date-event #schedule-end-date').val('');
                        $('#date-event #schedule-Notallowed').val('');
                        $('#date-event #schedule-timinigs').val('');
                    },
                });
            } else {
                alert("Invaild Not allowed Enter.")
            }




        })
    </script>
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <div class="iq-top-navbar">
            <div class="container">
                <div class="iq-navbar-custom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="iq-navbar-logo d-flex align-items-center justify-content-between">

                            <a href="index.html" class="header-logo">
                                <img src="./assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                                <img src="./assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo">
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
                                        <li>
                                            <div class="item mb-2"><i class="ri-pencil-line mr-3"></i>Edit</div>
                                        </li>
                                        <li>
                                            <div class="item"><i class="ri-delete-bin-6-line mr-3"></i>Delete</div>
                                        </li>
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
                                            <input type="date" value="09/10/2023" type="text" name="startdate" id="schedule-start-date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="schedule-end-date">End Date</label>
                                            <input type="date" value="2023-011-20" type="text" name="enddate" id="schedule-end-date" required />
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
                                            <label class="form-label" for="audio-file_pop">Audio File</label><br>
                                            <input type="file" name="audioFile_pop" id="audioFile_pop" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="form-control" type="color" name="title" id="schedule-color" />
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
    <style>
        .button-group {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 8px 10px;
            border-radius: 5px;
            border: 0;
            background-color: royalblue;
            box-shadow: rgb(0 0 255 / 5%) 0 0 7px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-size: 12px;
            transition: all .5s ease;
            color: white;
        }

        button:hover {
            letter-spacing: 3px;
            background-color: hsl(261deg 80% 48%);
            color: hsl(0, 0%, 100%);
            box-shadow: rgb(93 24 220) 0px 7px 29px 0px;
        }

        button:active {
            letter-spacing: 3px;
            background-color: hsl(261deg 80% 48%);
            color: hsl(0, 0%, 100%);
            box-shadow: rgb(93 24 220) 0px 0px 0px 0px;
            transform: translateY(10px);
            transition: 100ms;
        }
    </style>

    <div class="modal fade" id="date-event1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Edit Message</h4>
                        <input type="hidden" id="edit_id">
                        <input type="hidden" id="event_id">
                        <input type="hidden" id="audioPath">
                        <input type="hidden" id="mindate_id">
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
                                        <input type="date" value="09/10/2023" type="text" name="startdate" id="schedule-start-sss" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-end-sss">End Date</label>
                                        <input type="date" value="2023-011-20" type="text" name="enddate" id="schedule-end-sss" required />
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
                                        <label class="form-label" for="audio-file">Audio File</label><br>
                                        <input type="file" name="audioFile_edit" id="audioFile_edit" />
                                    </div>
                                    <a href="" id="showaudio"></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="color" name="title" id="schedule-color-sss" required />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <!-- <div class="d-flex flex-wrap align-items-ceter justify-content-center"> -->
                                    <div class="button">
                                        <!-- <button class="btn btn-primary mr-4" data-dismiss="modal">Cancel</button> -->
                                        <div class="button-group">
                                            <button type="button" id="delete_day">Delete Day</button>
                                            <button type="button" id="delete_Event">Delete Event</button>
                                            <button type="button" id="update_Event">Edit Event</button>
                                            <button type="button" id="update_form">Edit Day</button>
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
    <script src="./assets/js/backend-bundle.min.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="./assets/js/customizer.js"></script>

    <!-- Fullcalender Javascript -->
    <script src='./assets/vendor/fullcalendar/core/main.js'></script>
    <script src='./assets/vendor/fullcalendar/daygrid/main.js'></script>
    <script src='./assets/vendor/fullcalendar/timegrid/main.js'></script>
    <script src='./assets/vendor/fullcalendar/list/main.js'></script>
    <script src='./assets/vendor/fullcalendar/interaction/main.js'></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">             </script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <!-- app JavaScript -->
    <script src="./assets/js/app.js"></script>
    <script>
        $('#update_Event').on('click', function() {
            var audioFile = $("#audioFile_edit")[0].files[0];

            var formData = new FormData();

            formData.append("id", $('#edit_id').val());
            formData.append("event_id", $('#event_id').val());
            formData.append("startdate", $('#schedule-start-sss').val());
            formData.append("enddate", $('#schedule-end-sss').val());
            formData.append("notallowed", $('#schedule-Notallowed-sss').val());
            formData.append("exitpath", $('#audioPath').val());
            formData.append("message", $('#schedule-title-sss').val());
            formData.append("colour", $('#schedule-color-sss').val());
            formData.append("times", $('#schedule-timinigs-sss').val()); //showaudio
            formData.append("audioname", document.getElementById('showaudio').textContent);
            if (audioFile) {
                formData.append("audioFile", audioFile);
            } else {
                formData.append("audioFile", "");
            }
            $(this).closest('#date-event1').modal('hide')

            $.ajax({
                type: "POST",
                url: "updatefull_event.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response);
                    location.reload();
                },
            });
        });
        $('#update_form').on('click', function() {
            var message = $('#schedule-title-sss').val();
            var startdate = $('#schedule-start-sss').val();
            var times = $('#schedule-timinigs-sss').val();
            var edit_id = $('#edit_id').val();
            var colour_edit = $('#schedule-color-sss').val();
            var exit_path = $('#audioPath').val();
            console.log(exit_path);

            //         
            var formData = new FormData();
            formData.append("id", edit_id);
            formData.append("message", message);
            formData.append("colour", colour_edit); //["notallowed"]=notallowed; 
            formData.append("times", times);


            var audioFile = $("#audioFile_edit")[0].files[0];
            if (audioFile) {
                formData.append("audioFile", audioFile);
            } else {
                formData.append("audioFile", "");
            }
            $(this).closest('#date-event1').modal('hide')
            $.ajax({
                type: "POST",
                url: "update_event.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    location.reload();
                    alert(response);
                },
            });

        });
        $('#delete_day').on('click', function() {
            var edit_id = $('#edit_id').val();
            var deletedata = {
                "id": edit_id
            };
            $.ajax({
                type: "POST",
                url: "delete.php",
                data: deletedata,
                success: function(response) {
                    // Handle the response from the server
                    alert(response);
                    $(this).closest('#date-event1').modal('hide')
                    location.reload();
                }
            });
        });
        $('#delete_Event').on('click', function() {
            var delete_id = $('#edit_id').val();
            var delete_eventid = $('#event_id').val();
            var exitfile = $('#audioPath').val();
            // var delete_event={"id":delete_id};
            // var delete_whole={"event_id":delete_eventid};
            var jsondelete = {
                eventid: delete_id,
                delete_event_id: delete_eventid,
                exitpath: exitfile
            }
            $.ajax({
                type: "POST",
                url: "delete.php",
                data: jsondelete,
                success: function(response) {
                    // Handle the response from the server
                    alert(response);
                    $(this).closest('#date-event1').modal('hide')
                    location.reload();
                }
            });
        });
    </script>
</body>

</html>