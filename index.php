<?php

include 'database_connection.php';
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Logout function
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
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
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
    </script>
    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-8t+gWy0JhGjbOxbtu2QzKACoVrAJRz/iBRymx1Ht/W1hXxrFL05t8PChqoo3sLsP" crossorigin="anonymous">
    </script>

    <title>ATS-SYSTEM</title>


</head>

<body style="background-color:ghostwhite" class="d-flex flex-column min-vh-100" ;>
    <!--Nested Nav Bar -->
    <!-- RESPONSIVE NAV BAR STARTS HERE -->


    <nav class="navbar navbar-expand bg-light sticky-top">
  <ul class="navbar-nav">
    <a class="navbar-brand" href="dashboard.php">
      <img src="logos/logo.png" alt="ATS">
      <span class="navbar-brand-label fw-bolder fs-2 text-dark" style="margin-left:60px;font-family:monospace">ATS SYSTEM</span>
    </a>
  </ul>
</nav>

    <div class="container-fluid">
        <div class="d-flex">
            <div class="sidebar bg-white">
                <!-- Your sidebar content here -->
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="semester_list.php">Add Semester</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="teacher_list.php">Add Teacher</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="course_list.php">Add Course</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="section_list.php">Add Section</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="subject_list.php">Add Subject</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="room_list.php">Add Rooms</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-muted" href="faculty_loading_list.php">Faculty Loading</a>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link mar" href="update.php">Update Account</a>
                    </li>


                </ul>

                <div class="mt-5  m-5">

                    <form method="post">
                        <button type="submit" name="logout" class="btn btn-danger" margin>Logout</button>
                    </form>
                </div>

            </div>
            </script>


        </div>

    </div>
    </div>
    <!-- footer -->

    <footer class="footer bg-dark bg-gradient py-3 fixed-bottom mt-auto">

        <div class="container">
            <p class="text-muted">Copyright © 2023 Cavite State University CCAT Campus (Automated Timetable
                Scheduling System)
                <span class="float-end"><a href="dashboard.php">Back to top</a></span>
            </p>
        </div>

    </footer>


</body>

</html>