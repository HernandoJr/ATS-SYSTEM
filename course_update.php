<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';

// Fetching data from the database
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM courses WHERE id ='$id'";
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

    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $slots = mysqli_real_escape_string($conn, $_POST['slots']);

    // Then, check if the Course name, start date and end date already exists in the database
    $sql = "SELECT * FROM courses WHERE course_id='$course_id' AND course_name='$course_name' AND slots='$slots' AND id!='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the Course with the same name, start date and end date already exists, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("Course with the same name, start date and end date already exists!")';
        echo '</script>';
    } else {
        // If the Course with the same name, start date and end date does not exist, update the data in the database
        $sql = "UPDATE courses SET course_id='$course_id', course_name='$course_name', slots ='$slots' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display an alert message and redirect to Course_list.php
            echo '<script type="text/javascript">';
            echo ' alert("Record updated successfully!");';
            echo ' window.location.href = "course_list.php";';
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
    <link rel="stylesheet" href="css/course.css">
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
    <div class="container mt-3">

        <h3>Update Course</h3>



        <!-- Display the data of the selected Course in the form fields -->
        <form method="POST" action="">

            <div class="mb-3">
                <label for="course_id" class="form-label">Course ID</label>
                <input type="number" class="form-control" id="course_id" name="course_id"
                    value="<?php echo $row['course_id']; ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="mb-3">
                <label for="course_name" class="form-label">Course ID</label>
                <input type="text" class="form-control" id="course_name" name="course_name"
                    value="<?php echo $row['course_name']; ?>">
            </div>
            <div class="mb-3">
                <label for="slots" class="form-label">Course Slots</label>
                <input type="number" class="form-control" id="slots" name="slots"
                    value="<?php echo $row['slots']; ?>">
            </div>

                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="course_list.php" class="btn btn-danger">Back</a>
        </form>

    </div>

  
</body>

</html>