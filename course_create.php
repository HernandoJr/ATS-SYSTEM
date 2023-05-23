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
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $slots = $_POST['slots'];

    // Check if data already exists in the database
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $sql = "SELECT * FROM courses WHERE course_id ='$course_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Data already exists in the database, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("Course already exists!")';
        echo '</script>';
    } else {
        // Data does not exist in the database, insert the data into the table
        $sql = "INSERT INTO courses (course_id, course_name, slots) VALUES ('$course_id', '$course_name', '$slots')";

        if (mysqli_query($conn, $sql)) {
            echo '<script type="text/javascript">';
            echo ' alert("New record added successfully!");';
            echo ' window.location.href = "course_list.php";';
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
    <title>Add Course</title>
    <div class="container mt-3">

    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">ADD COURSE</H1>

        <form method="post">

            <div class="mb-3">
                <label for="course_id" class="form-label">Course ID:</label>
                <input type="number" class="form-control" id="course_id" placeholder="Enter Course id"
                    name="course_id" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="course_name" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="course_name" placeholder="Enter Course name"
                    name="course_name" required>
            </div>

            <div class="mb-3">
                <label for="slots" class="form-label">Slots</label>
                <input type="number" class="form-control" id="slots" placeholder="Slots"
                    name="slots" required>
            </div>
            
            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="course_list.php" class="btn btn-danger" name="back">Back</a>

        </form>
    </div>

</body>

</html>