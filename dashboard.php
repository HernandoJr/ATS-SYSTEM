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

<!-- System Description-->
<div id="description_system"
    style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);background: radial-gradient(circle at 24.1% 68.8%, rgb(50, 50, 50) 0%, rgb(0, 0, 0) 99.4%);;font-size:1.2rem;"
    class="container-fluid p-3 text-center">
    <?php
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $user_data = mysqli_fetch_assoc($result);
    $user_name = $user_data['name'];
    echo "<h3 style='font-family:monospace;' class='fw-bolder text-warning'>Automated Timetable Scheduling System (ATS)</h3>";

    ?>
    <div class="mt-4">
        <ul class="list-unstyled text-white ">
            <em>
                Automated Timetable Scheduling System (ATS) is a web-based application developed for the Department
                of Computer Studies at Cavite State University CCAT Campus. Its main purpose is to automate the
                scheduling process, ensuring that schedules for teachers, students, and rooms are conflict-free. ATS
                considers various constraints such as the duration of each timeslot should be based on subject hours. It
                also assigns appropriate rooms for different subjects based on subject type and room type. By automating
                the scheduling process, ATS aims to generate an optimized schedule that maximizes efficiency, minimizes
                conflicts, and reduces the time required to create schedules.
            </em>
        </ul>
    </div>

    <button type="button" id="button_close" class="btn-close btn-close-white" data-bs-dismiss="alert"
        aria-label="Close"></button>
</div>




<div class="container-fluid">
    <div class="row justify-content-center" style="margin-right:0px;margin-left:190px;">
        <!-- TEACHER DASHBOARD -->
        <div class="col-5">
            <div class="dashboard hover-color">

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

                    <div class="card-body ">
                        <div class="label text-dark">Total Teachers</div>
                    </div>

                </div>

            </div>
        </div>



        <!--  COURSE DASHBOARD-->
        <div class="col-5">
            <div class="dashboard hover-color">

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
        </div>

        <!--  SECTION DASHBOARD-->
        <div class="col-5">
            <div class="dashboard hover-color">

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
        <div class="col-5">
            <div class="dashboard hover-color">

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
        </div>

        <!--  Rooms DASHBOARD-->
        <div class="col-5">
            <div class="dashboard hover-color">

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

        <!--  randomize DASHBOARD-->
        <div class="col-5">
            <div class="dashboard hover-color">

                <?php
                $query = "SELECT COUNT(start_time) AS total_sched FROM faculty_loadings WHERE start_time IS NOT NULL";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $total_sched = $row['total_sched'];
                } else {
                    $total_sched = "N/A";
                }
                ?>

                <img class="logo" src="logos/sched.png" alt="ATS">
                <div class="metric rounded-circle">

                    <div class="value">
                        <?php echo '<div class="display-2 fw-bolder text-dark">' . $total_sched . '</div>'; // Replace display-1 with the desired size class.?>
                    </div>

                    <div class="card-body">
                        <div class="label text-dark">Total Generated Schedules</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $(".btn-close").click(function () {
            $("#description_system").hide();
        });
    });
</script>

</body>

</html>