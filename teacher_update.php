<?php

//include the db connetion php file.
include 'database_connection.php';
include 'index.php';

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetching data from the database
if (isset($_GET['id'])) {
    $teacher_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM teachers WHERE id ='$teacher_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // If there was an error in the query, display an error message and exit
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit();
    }
}

// Updating data in the database
if (isset($_POST['update'])) {
    // First, retrieve the data from the form and sanitize it
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);

    // Then, check if the teacher_id already exists in the database
    $sql = "SELECT * FROM teachers WHERE firstname = '$firstname' AND lastname = '$lastname' OR teacher_id='$teacher_id'";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {
        // If the teacher_id already exists, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("Teacher ID already exists!")';
        echo '</script>';
    } else {
        // If the teacher_id does not exist, update the data in the database
        $sql = "UPDATE teachers SET firstname='$firstname', lastname='$lastname', teacher_id='$teacher_id' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display an alert message and redirect to teacher_list.php
            echo '<script type="text/javascript">';
            echo ' alert("Record updated successfully!");';
            echo ' window.location.href = "teacher_list.php";';
            echo '</script>';
            exit; // Make sure to exit after the redirect
        } else {
            echo "Error updating record: " . mysqli_error($conn);
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
        integrity="sha384-8t+gWy0JhGjbOxbtu2QzKACoVrAJRz/iBRymx1Ht/W1hXxrFL05t8PChqoo3sLsP"
        crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-3">

    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">UPDATE TEACHER INFORMATION</H1>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3 mt-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname"
                    value="<?php echo $row['firstname']; ?>" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname"
                    value="<?php echo $row['lastname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="teacher_id" class="form-label">Teacher ID:</label>
                <input type="number" class="form-control" id="teacher_id" placeholder="Enter teacher id"
                    name="teacher_id" value="<?php echo $row['teacher_id']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="update">Update</button>
            <a href="teacher_list.php" class="btn btn-danger" name="back">Back</a>

</body>

</html>