<?php

include 'database_connection.php';
include 'index.php';

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
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
    <link rel="stylesheet" href="css/dashboard.css">
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

    <title>Dashboard Page</title>


</head>

<body class="bg-light">
  
        <!-- TEACHER DASHBOARD -->
        <div class="dashboard p-3 col-auto ">

            <?php
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
            <div class="metric rounded-circle">

                <div class="value">
                    <?php echo '<div class="display-2 fw-bolder text-dark">' . $total_teachers . '</div>'; // Replace display-1 with the desired size class.?>
                </div>

                <div class="card-body">
                    <div class="label text-dark">Total Teachers</div>
                </div>

            </div>

        </div>

     
    
        <div class="d-flex flex-row">

        <!--  COURSE DASHBOARD-->
        <div class="dashboard p-5 col-3">

            <?php
            $query = "SELECT COUNT(*) AS total_course FROM courses";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $total_course = $row['total_course'];
            } else {
                $total_course = "N/A";
            }
            ?>

            <img class="logo" src="logos/course.png" alt="ATS">
            <div class="metric rounded-circle">

                <div class="value">
                    <?php echo '<div class="display-2 fw-bolder text-dark">' . $total_course . '</div>'; // Replace display-1 with the desired size class.?>
                </div>

                <div class="card-body">
                    <div class="label text-dark">Total Course</div>
                </div>

            </div>

        </div>

        <!--  SECTION DASHBOARD-->
        <div class="dashboard p-5 col-5">

            <?php
            $query = "SELECT COUNT(*) AS total_section FROM sections";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $total_section = $row['total_section'];
            } else {
                $total_section = "N/A";
            }
            ?>

            <img class="logo" src="logos/section.png" alt="ATS">
            <div class="metric rounded-circle">

                <div class="value">
                    <?php echo '<div class="display-2 fw-bolder text-dark">' . $total_section . '</div>'; // Replace display-1 with the desired size class.?>
                </div>

                <div class="card-body">
                    <div class="label text-dark">Total Section</div>
                </div>

            </div>

        </div>
        </div>
        
        <!--  SUBJECT DASHBOARD-->

        <div class="d-flex flex-row">
        <div class="dashboard p-5 col-3">

            <?php
            $query = "SELECT COUNT(*) AS total_subject FROM subjects";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $total_subject = $row['total_subject'];
            } else {
                $total_subject = "N/A";
            }
            ?>

            <img class="logo" src="logos/subjects.png" alt="ATS">
            <div class="metric rounded-circle">

                <div class="value">
                    <?php echo '<div class="display-2 fw-bolder text-dark">' . $total_subject . '</div>'; // Replace display-1 with the desired size class.?>
                </div>

                <div class="card-body">
                    <div class="label text-dark">Total Subjects</div>
                </div>

            </div>

        </div>
        
            
        <!--  Rooms DASHBOARD-->
        <div class="dashboard p-5 col-5">

            <?php
            $query = "SELECT COUNT(*) AS total_rooms FROM rooms";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $total_rooms = $row['total_rooms'];
            } else {
                $total_rooms = "N/A";
            }
            ?>

            <img class="logo" src="logos/rooms.png" alt="ATS">
            <div class="metric rounded-circle">

                <div class="value">
                    <?php echo '<div class="display-2 fw-bolder text-dark">' . $total_rooms . '</div>'; // Replace display-1 with the desired size class.?>
                </div>

                <div class="card-body">
                    <div class="label text-dark">Total Rooms</div>
                </div>

            </div>

        </div>
        </div>
    
</body>

</html>