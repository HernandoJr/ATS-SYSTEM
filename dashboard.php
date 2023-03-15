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

    <title>Index Page</title>


</head>

<body>
    <!--Nested Nav Bar -->
    <!-- RESPONSIVE NAV BAR STARTS HERE -->

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">


            <ul class="navbar-nav">

                <a class="navbar-brand" href="dashboard.php">
                    <img src="logos/logo.png" alt="ATS">
                </a>

            </ul>
    
                </ul>
            </li>
        </ul>

        </div>

    </nav>

    <div class="dashboard">

        <?php

        //dashboard code here
        include("database_connection.php");


        $query = "SELECT COUNT(*) AS total_teachers FROM teachers";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $total_teachers = $row['total_teachers'];
        } else {
            $total_teachers = "N/A";
        }
        ?>

        <img class="logo" src="logos/teacher.png" alt="ATS">
        <div class="metric">
            <div class="value">
                <?php echo $total_teachers; ?>
            </div>
            <div class="label">Total Teachers</div>
            <div class="card-body">

            </div>
        </div>
    </div>


    <div class="container">
        <div class="d-flex">
            <div class="sidebar ">
                <!-- Your sidebar content here -->
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="semester_list.php">Add Semester</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="teacher_list.php">Add Teacher</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Course</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Section</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Timeslot</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Rooms</a>
                  
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="update.php">Update Account</a>
                  
                    </li>

                </ul>
                <div class="m-5">
                    <form method="post">
                        <button type="submit" name="logout" class="btn btn-danger" margin>Logout</button>
                    </form>
                </div>

            </div>
        </div>

        <!-- footer -->
        <footer class="footer bg-dark py-3 fixed-bottom">
            <div class="container">
                <p class="text-muted">Copyright © 2023 Cavite State University CCAT Campus (Automated Timetable
                    Scheduling System)

                    <span class="float-end"><a href="#">Back to top</a></span>
                </p>
            </div>
    </div>
    </footer>
</body>

</html>