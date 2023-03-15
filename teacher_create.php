<?php

//include the db connetion php file.
include 'database_connection.php';
include 'index.php';

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Inserting data for teachers table
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $teacher_id = $_POST['teacher_id'];

    // Check if data already exists in the database
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $sql = "SELECT * FROM teachers WHERE teacher_id ='$teacher_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Data already exists in the database, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("teacher already exist!")';
        echo '</script>';
    } else {
        // Data does not exist in the database, insert the data into the table
        $sql = "INSERT INTO teachers (firstname, lastname, teacher_id) VALUES ('$firstname', '$lastname', '$teacher_id')";

        if (mysqli_query($conn, $sql)) {
            echo '<script type="text/javascript">';
            echo ' alert("New record added successfully!");';
            echo ' window.location.href = "teacher_list.php";';
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
    <link rel="stylesheet" href="css/teacher_form.css">
    <title>Index Page</title>

</head>

<body>

    <div class="container mt-3">

        <h3>Add Teacher</h3>

        <form method="post">
            <div class="mb-3 mt-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname"
                    required>
            </div>
            <div class="mb-3 mt-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname"
                    required>
            </div>
            <div class="mb-3">
                <label for="teacher_id" class="form-label">Teacher ID:</label>
                <input type="number" class="form-control" id="teacher_id" placeholder="Enter teacher id"
                    name="teacher_id" required>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="teacher_list.php" class="btn btn-danger" name="back">Back</a>
        </form>
    </div>

</body>

</html>