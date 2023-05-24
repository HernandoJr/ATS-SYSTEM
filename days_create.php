<?php
//include the db connection php file.
include 'database_connection.php';
include 'index.php';

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Inserting data for courses table
if (isset($_POST['submit'])) {
    $course_name = mysqli_real_escape_string($conn,$_POST['day']);
 

    // Check if data already exists in the database
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $sql = "SELECT * FROM available_days WHERE day ='$day'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Data already exists in the database, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("Day already exists!")';
        echo '</script>';
    } else {
        // Data does not exist in the database, insert the data into the table
        $sql = "INSERT INTO available_days (day) VALUES ('$day')";

        if (mysqli_query($conn, $sql)) {
            echo '<script type="text/javascript">';
            echo ' alert("New day has been added successfully!");';
            echo ' window.location.href = "days_list.php";';
            echo '</script>';
            exit; // Make sure to exit after the redirect

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }
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
</head>

<body>
    <title>Add Day</title>
    <div class="container mt-3">

    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">ADD DAY</H1>

        <form method="post">

        <div class="form-group mt-3">
            <label for="day" class="form-label">Day:</label>
            <select class="form-select" name="day" id="day" required>
                <option value="">Select a day</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>
        </div>

            
            <button type="submit" class="btn btn-primary mt-3" name="submit">Create</button>
            <a href="course_list.php" class="btn btn-danger mt-3" name="back">Back</a>

        </form>
    </div>

</body>

</html>