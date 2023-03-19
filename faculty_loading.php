<?php
include 'database_connection.php';
include 'index.php';

if (isset($_POST['submit'])) {
    
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];
    $section_id = $_POST['section_id'];

    // Validate input data
    if (empty ($teacher_id) || empty($course_id) || empty($section_id)) {
        echo '<div class="alert alert-danger" role="alert">Please select all fields.</div>';
    } else {
        // Insert the data into the faculty_loading table
        $sql = "INSERT INTO faculty_loadings (teacher_id, course_id, section_id) VALUES ('$teacher_id', '$course_id', '$section_id')";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success" role="alert">Faculty loading added successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div>';
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
    <link rel="stylesheet" href="css/index.css">
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

    <title>ATS-SYSTEM</title>


</head>
<div class="container mt-3">

    <!-- Dropdown for selecting a teacher -->
    <div class="form-group">
        <label for="teacher_id">Teacher</label>
        <select class="form-control" id="teacher_id" name="teacher_id">
            <?php
            $sql = "SELECT * FROM teachers";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["teacher_id"] . '">' . $row["firstname"] . ' ' . $row["lastname"] . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <!-- Dropdown for selecting a course -->
    <form method="POST">
        <div class="form-group">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id">
                <?php
                $sql = "SELECT * FROM courses";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["course_id"] . '">' . $row["course_name"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dropdown for selecting a section -->
        <div class="form-group">
            <label for="section_id">Section</label>
            <select class="form-control" id="section_id" name="section_id">
                <?php
                $sql = "SELECT * FROM sections";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["section_id"] . '">' . $row["section_name"] . '</option>';
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