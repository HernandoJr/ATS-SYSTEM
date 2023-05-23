<?php
include 'database_connection.php';
session_start();

// Check if the user is logged in


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>

    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
    <title>ATS-SYSTEM</title>


</head>


<body style="background-color: #d5fefd; background-image: linear-gradient(315deg, #d5fefd 0%, #fffcff 74%);" class="d-flex flex-column min-vh-100" ;>
    <!--Nested Nav Bar -->
    <!-- RESPONSIVE NAV BAR STARTS HERE -->

    <nav class="navbar navbar-expand bg-light sticky-top">
        <ul class="navbar-nav">
            <a class="navbar-brand" href="dashboard.php">
                <img src="logos/logo.png" alt="ATS">
                <span class="navbar-brand-label fw-bolder fs-2 text-dark"
                    style="margin-left:60px;font-family:monospace">ATS SYSTEM</span>

            </a>
        </ul>

        <div class=" bg-gray text-warning border ms-12  fw-bolder ">
            <?php

            if (isset($_SESSION['user_id'])) {
                // Fetch the user data from the database
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM users WHERE id='$user_id'";
                $result = mysqli_query($conn, $sql);
                $user_data = mysqli_fetch_assoc($result);

                // Display the user name
                $user_name = $user_data['name'];
                $welcome_message = "Welcome, $user_name!";

                if (!isset($_SESSION['welcome_alert_shown'])) {
                    echo "<script>alert('$welcome_message');</script>";
                    $_SESSION['welcome_alert_shown'] = true;
                }


            }

            ?>
        </div>

        <div class="navbar-nav ms-auto">
            <li class="nav-item dropdown">

                <div class="dropdown">
                    <button class="fw-bolder btn btn-danger  text-center text-light dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $user_data['name']; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="update.php">Update Account</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="post">
                                <button type="submit" name="logout" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>


        </div>
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
                        <a class="nav-link text-primary" href="faculty_loading_list.php">Faculty Loading</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-danger" href="#" id="scheduleDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Generate Schedule
                        </a>
                        <ul class="dropdown-menu " aria-labelledby="scheduleDropdown">
                            <a class="nav-link text-primary  fw-bolder text-center h5"
                                href="automated_schedule.php">Automated</a>
                    </li>
                    <hr class="dropdown-divider">
                    </li>
                    <a class="nav-link text-primary fw-bolder text-center h5" href="manual_schedule_list.php">Manual</a>
                </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-danger" href="#" id="scheduleDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        View Schedule
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="scheduleDropdown">
                        <li><a class="dropdown-item text-primary h5" href="view_room_schedule.php">View Room
                                Schedule</a></li>
                        <li><a class="dropdown-item text-primary h5" href="view_teacher_schedule.php">View Teacher
                                Schedule </a>
                        <li><a class="dropdown-item text-primary h5" href="view_section_schedule.php">View Section
                                Schedule </a>
                        </li>
                        <li>
                        </li>
                    </ul>
                </li>

                </ul>
            </div>
        </div>

    </div>
    </div>

    <!-- footer -->

    <!-- <footer class="footer bg-dark bg-gradient py-3  mt-auto">

        <div class="container">
            <p class="text-muted">Cavite State University CCAT Campus (Automated Timetable Scheduling System)
                <span class="float-end"><a href="dashboard.php">Back to top</a></span>
            </p>
        </div>

    </footer>-->


</body>

</html>