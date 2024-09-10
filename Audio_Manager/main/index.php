<?php
require("../callbacks/config.php");
session_start();
$login = '<button id="calendar-btn" name="submit" type="submit">Login</button>';

$schedule = '<form action="../../index.php" >
                <button id="login-btn" type="submit">Schedule</button>
            </form>';
$logout =' <form action="../callbacks/logout.php">
    <button id="settings-btn">Logout</button>
    </form>';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../Assests/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Basic styles for popup */
        #login-popup {
            display: none; /* Hidden by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            z-index: 1000; /* Ensure it is above other content */
        }

        #login-popup h2 {
            margin-bottom: 1rem;
            font-size: 1.25rem;
            color: #333;
        }

        #login-popup form {
            display: flex;
            flex-direction: column;
        }

        #login-popup input[type="text"],
        #login-popup input[type="password"] {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        #login-popup input[type="text"]:focus,
        #login-popup input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        #login-popup button {
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            font-size: 1rem;
        }

        #login-popup .submit-btn {
            background: #007bff;
            margin-top: 1rem;
        }

        #login-popup .cancel-btn {
            background: #f44336;
            margin-top: 0.5rem;
        }

        #login-popup .cancel-btn:hover {
            background: #d32f2f;
        }

        #login-popup .submit-btn:hover {
            background: #0056b3;
        }

        /* Overlay Styles */
        #overlay {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999; /* Ensure it is below the popup */
        }

        @media (max-width: 400px) {
            #login-popup {
                padding: 1rem;
            }

            #login-popup h2 {
                font-size: 1rem;
            }

            #login-popup input[type="text"],
            #login-popup input[type="password"] {
                padding: 0.5rem;
            }

            #login-popup button {
                padding: 0.5rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div id="data-container"></div>


    <fieldset>
        <?php
        if(isset($_SESSION["username"])){
          echo $schedule ;
        }else{
            echo $login;
        }
        
        ?>
        
        <div id="head">
            <h1>Automatic / Manual Audio PLayer </h1>
  
        </div>
      <input type="text" id="audio" placeholder="" readonly>

        <div class="button-row">
            <!-- <form action="" method="post"> -->
            <!-- <form action="../callbacks/fetch.php" method="post"> -->
        
    <button type="button" id="esc" name="esc">ESC</button>
            <!-- </form> -->
            <form action="">
                <button type="submit" id="left" name="left">LEFT1</button>
            </form>
            <form action="">
                <button type="submit" id="right" name="right">RIGHT</button>
            </form>
            <form action="">
                <button type="submit" id="inc" name="inc">INC</button>
            </form>
            <form action="">
                <button type="submit" id="dec" name="dec">DEC</button>
            </form>
            
            <form action="">
                <button type="submit" id="entprog" name="entprog">ENT <br> PROG</button>
            </form>
        </div>


    </fieldset>

    <!-- Settings Button -->
     <?php
     if(isset($_SESSION["username"])){
            echo $logout;

     }
     ?>
    
    <!-- Settings Panel -->
   

    <!-- Overlay for the Popup -->
    <div id="overlay"></div>

    <!-- Popup for Login Form -->
    <div id="login-popup">
        <h2>Login</h2>
        <form action="../callbacks/login.php" method="post">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" placeholder="Enter your username" required>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Enter your password" required>
            <button type="submit" name="submit" class="submit-btn">Login</button>
          
        </form>
        <form action="#">
        <button type="submit" class="cancel-btn">Cancel</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        // Event listener for the calendar button
        document.getElementById('calendar-btn')?.addEventListener('click', function () {
            document.getElementById('login-popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        });

        // // Event listener for the login button (ensure correct id)
        // document.getElementById('login-btn')?.addEventListener('click', function () {
        //     document.getElementById('login-popup').style.display = 'block';
        //     document.getElementById('overlay').style.display = 'block';
        // });

        // Event listener for the cancel button
        document.querySelector('.cancel-btn')?.addEventListener('click', function () {
            document.getElementById('login-popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        // Event listener for the overlay
        document.getElementById('overlay')?.addEventListener('click', function () {
            document.getElementById('login-popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        // Toggle settings panel
        document.getElementById('settings-btn')?.addEventListener('click', function () {
            var panel = document.getElementById('settings-panel');
            panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
        });

        // Change button color
        document.getElementById('button-color')?.addEventListener('input', function () {
            var color = this.value;
            document.querySelectorAll('.button-row button, .center-button button, #calendar-btn').forEach(function (button) {
                button.style.backgroundColor = color;
            });
        });

        // Change text color
        document.getElementById('text-color')?.addEventListener('input', function () {
            var color = this.value;
            document.querySelectorAll('#audio, legend, h1, .button-row button, .center-button button, #calendar-btn').forEach(function (element) {
                element.style.color = color;
            });
        });

        // Dark mode toggle
        document.getElementById('dark-mode')?.addEventListener('change', function () {
            if (this.checked) {
                document.body.style.backgroundColor = '#333';
                document.body.style.color = '#f0f2f5';
                document.querySelector('fieldset').style.backgroundColor = '#fff';
                document.querySelector('fieldset').style.borderColor = '#555';
                panel.style.color = "black";
            } else {
                document.body.style.backgroundColor = '#f0f2f5';
                document.body.style.color = '#333';
                document.querySelector('fieldset').style.backgroundColor = '#fff';
                document.querySelector('fieldset').style.borderColor = '#ccc';
            }
        });

        // Function to update time
        function updateTime() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            };
            const dateString = now.toLocaleString('en-US', options);
            document.getElementById('audio').value = dateString;
        }

        // Update the time immediately and every second
        updateTime();
        setInterval(updateTime, 1000);
    });
</script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->

</body>
</html>
