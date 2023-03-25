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
    $subject_description = $_POST['subject_description'];
    $subject_type = $_POST['subject_type'];
    $course_name = $_POST['course_name'];

    $section_name = $_POST['section_name'];

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
    <title>ATS-SYSTEM</title>
    <div class="container mt-3">

        <h3>Faculty Loading</h3>

        <form method="post">
            <div class="container mt-3">

                <!-- Dropdown for selecting a teacher -->
                <div class="form-group">
                    <label for="teacher">Teacher</label>
                    <select class="form-control" id="teacher" name="teacher">
                        <?php
                        $sql = "SELECT firstname, lastname FROM teachers";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["firstname"] . ' ' . $row["lastname"] . '">' . $row["firstname"] . ' ' . $row["lastname"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Dropdown for selecting a course -->
                <form method="POST">
                    <div class="form-group">
                        <label for="course_name">Course</label>
                        <select class="form-control" id="course_name" name="course_name">
                            <?php
                            $sql = "SELECT * FROM courses";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["course_name"] . '">' . $row["course_name"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Dropdown for selecting a section -->
                    <div class="form-group">
                        <label for="subject_description">Subject</label>
                        <select class="form-control" id="subject_description" name="subject_description">
                            <?php
                            $sql = "SELECT * FROM subjects";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["subject_description"] . '">' . $row["subject_description"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>


                    <!-- Dropdown for selecting a section -->
                    <div class="form-group">
                        <label for="section_year">Year</label>
                        <select class="form-control" id="section_year" name="section_year">
                            <?php
                            $sql = "SELECT * FROM sections";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["section_year"] . '">' . $row["section_year"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>



                    <button type="submit" class="btn btn-primary" name="submit">Create</button>
                    <a href="faculty_loading_list.php" class="btn btn-danger" name="back">Back</a>

                </form>
            </div>

</body>

</html>