
<?php
include 'database_connection.php';
session_start();

// Check if user is not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// Logout function
if(isset($_POST['logout'])){
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

                <div style="display: flex; align-items: center; margin-left:85em;">
                    <form method="post">
                        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                    </form>
                </div>

                    
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

                <h2>Dashboard</h2>
                <div class="metric">
                    <div class="value"><?php echo $total_teachers; ?></div>
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

    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D"
    crossorigin="anonymous"></script>

</body>

</html>
