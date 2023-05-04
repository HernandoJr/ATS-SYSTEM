<?php
// include the database connection file

include 'database_connection.php';
include 'index.php';

// check if the form is submitted
if (isset($_POST['submit'])) {

    // get the form data
    $section_id = $_POST['section_id'];
    $section_name = $_POST['section_name'];


    // check if a record with the same section name, start date, and end date already exists
    $sql = "SELECT * FROM sections WHERE section_name = '$section_name' AND section_id = '$section_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("A section with the same name and course");';
        echo ' window.location.href = "section_create.php";';
        echo '</script>';
        exit;
    }

    // insert the data into the database
    $sql = "INSERT INTO sections (section_id, section_name) VALUES ('$section_id', '$section_name')";

    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">';
        echo ' alert("New record added successfully!");';
        echo ' window.location.href = "section_list.php";';
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

<body>
    <div class="container mt-3">
        <h3>Add Section</h3>
        <form method="post">

            <div class="form-group mb-3">
                <label for="section_id">Section ID:</label>
                <input type="text" class="form-control" id="section_id" name="section_id"
                    placeholder="Enter section ID">
            </div>

            <div class="mb-3 mt-3">
                <label for="section_name" class="form-label"> Section Name</label>
                <select class="form-select" id="section_name" name="section_name" required>
                    <option value="">Select </option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="section_list.php" class="btn btn-danger" name="back">Back</a>
        </form>

    </div>

</body>

</html>