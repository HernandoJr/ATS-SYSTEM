<?php
    session_start();
    include("database_connection.php");



?>


<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CDN Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--External CSS-->
    <link rel="stylesheet" href="css/index.css">
    <title>Index Page</title>

</head>

<body>


    <!--Nested Nav Bar -->
    <!-- RESPONSIVE NAV BAR STARTS HERE -->

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">

            <ul class="navbar-nav">

                <a class="navbar-brand" href="index.php">
                    <img src="logos/logo.png" alt="ATS">
                </a>

            </ul>

        </div>

    </nav>
 
    <div class="container">
        <div class="d-flex">
            <div class="sidebar ">
                <!-- Your sidebar content here -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="teacher_list.php">Add Teacher</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Section</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Subject</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Subject Timing</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Rooms</a>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>
    </nav>
</body>

</html>


  