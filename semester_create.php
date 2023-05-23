<?php
// include the database connection file

include 'database_connection.php';
include 'index.php';

// check if the form is submitted
if (isset($_POST['submit'])) {

    // get the form data
    $semester_id = mysqli_real_escape_string($conn,$_POST['semester_id']);
    $semester_name = mysqli_real_escape_string($conn,$_POST['semester_name']);
    $start_year = mysqli_real_escape_string($conn,$_POST['start_year']);
    $end_year = mysqli_real_escape_string($conn,$_POST['end_year']);

    // check if a record with the same semester name, start date, and end date already exists
    $sql = "SELECT * FROM semesters WHERE semester_name = '$semester_name' AND start_year = '$start_year' AND end_year = '$end_year'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("A semester with the same name and date range already exists!");';
        echo ' window.location.href = "semester_create.php";';
        echo '</script>';
        exit;
    }

    // insert the data into the database
    $sql = "INSERT INTO semesters (semester_id, semester_name, start_year, end_year) VALUES ('$semester_id', '$semester_name', '$start_year', '$end_year')";

    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">';
        echo ' alert("New record added successfully!");';
        echo ' window.location.href = "semester_list.php";';
        echo '</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href="css/_form.css">
    <title>Add Semester </title>
</head>

<body>
    <div class="container mt-3">
    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">ADD SEMESTER</H1>

    <form method="post">
        <div class="mb-3">
            <label for="semester_id">Semester ID:</label>
            <input type="text" class="form-control" id="semester_id" name="semester_id" placeholder="Enter Semester ID">
        </div>

        <div class="mb-3 mt-3">
            <label for="semester_name" class="form-label">Name</label>
            <select class="form-select" id="semester_name" name="semester_name" required>
                <option value="">Select</option>
                <option value="1st SEM">1st SEM</option>
                <option value="2nd Sem">2nd Sem</option>
                <option value="Midyear">Midyear</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="start_year" class="form-label">Start Year:</label>
            <input type="number" class="form-control" id="start_year" name="start_year" min="2022" max="2099" required>
        </div>

        <div class="mb-3">
            <label for="end_year" class="form-label">End Year:</label>
            <input type="number" class="form-control" id="end_year" name="end_year" min="2023" max="2099" required>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Create</button>
        <a href="semester_list.php" class="btn btn-danger" name="back">Back</a>
    </form>
</div>

</body>

</html>