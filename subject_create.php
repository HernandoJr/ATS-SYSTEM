<?php
// include the database connection file

include 'database_connection.php';
include 'index.php';

// check if the form is submitted
if (isset($_POST['submit'])) {

    // get the form data
    $subject_code = $_POST['subject_code'];
    $subject_description = $_POST['subject_description'];
    $subject_type = $_POST['subject_type'];
    $subject_units = $_POST['subject_units'];
    $subject_hours = $_POST['subject_hours'];

// check if a record with the same subject code and type already exists
$sql = "SELECT * FROM subjects WHERE subject_code='$subject_code' AND subject_type='$subject_type' AND subject_description='$subject_description'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">';
        echo ' alert("Subject already exist!");';
        echo ' window.location.href = "subject_list.php";';
        echo '</script>';
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
        exit;
    }
} else {
    // No record found, perform the insert
    $sql = "INSERT INTO subjects (subject_code, subject_description, subject_type, subject_units, subject_hours) VALUES ('$subject_code', '$subject_description', '$subject_type', '$subject_units', '$subject_hours')";

    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">';
        echo ' alert("New record added successfully!");';
        echo ' window.location.href = "subject_list.php";';
        echo '</script>';
        exit;
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
        exit;
    }
}}

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
    <title>Add Subject </title>
</head>

<body>
    <div class="container mt-3">
    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">ADD SUBJECT</H1>

        <form method="post">

            <div class="mb-3">
                <label for="subject_code">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code"
                    placeholder="Enter Subject Code">
            </div>

            <div class="mb-3">
                <label for="subject_description">Subject Title</label>
                <input type="text" class="form-control" id="subject_description" name="subject_description"
                    placeholder="Enter Subject Description">
            </div>

            <div class="mb-3 mt-3">
                <label for="subject_type" class="form-label">Subject Type</label>
                <select class="form-select" id="subject_type" name="subject_type" required>
                    <option value="">Select </option>
                    <option value="Lab">Lab</option>
                    <option value="Lec">Lec</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="subject_units">Units</label>
                <input type="number" class="form-control" id="subject_units" name="subject_units"
                    placeholder="Enter number of Units">
            </div>

            <div class="mb-3 mt-3">
                <label for="subject_hours" class="form-label">Subject Hours</label>
                <select class="form-select" id="subject_hours" name="subject_hours" required>
                    <option value="">Select </option>
                    <option value="1">1 hour</option>
                    <option value="2">2 hours</option>
                    <option value="1.5">1 hour and 30 minutes</option>
                    <option value="3">3 hours</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="subject_list.php" class="btn btn-danger" name="back">Back</a>
        </form>
    </div>
</body>

</html>


