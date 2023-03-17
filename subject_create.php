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

    // check if a record with the same subject_code date already exists
    $sql = "SELECT * FROM subjects WHERE  subject_description='$subject_description' AND subject_type='$subject_type' AND id!='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("A Subject with the same subject code and type  already exists!");';
        echo ' window.location.href = "subject_create.php";';
        echo '</script>';
        exit;
    }

    // insert the data into the database
    $sql = "INSERT INTO subjects (subject_code, subject_description, subject_type, subject_units) VALUES ('$subject_code', '$subject_description', '$subject_type', '$subject_units')";

    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">';
        echo ' alert("New record added successfully!");';
        echo ' window.location.href = "subject_list.php";';
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
    <title>Add Subject </title>
</head>

<body>
    <div class="container mt-3">
        <h3>Add Subject</h3>

        <form method="post">

            <div class="mb-3">
                <label for="subject_code">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code"
                    placeholder="Enter Subject Code">
            </div>

            <div class="mb-3">
                <label for="subject_description">Subject Description</label>
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
            
            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="subject_list.php" class="btn btn-danger" name="back">Back</a>
        </form>
    </div>
</body>

</html>