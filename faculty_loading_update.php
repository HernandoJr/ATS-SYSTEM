<?php
include 'database_connection.php';
include 'index.php';

if (isset($_POST['submit'])) {

    $teacher = $_POST['teacher'];
    $subject_description = $_POST['subject_description'];
    $course_name = $_POST['course_name'];
    $section_name = $_POST['section_name'];
    $section_year = $_POST['section_year'];



    // Get the subject units from the database
    $sql = "SELECT subject_units FROM subjects WHERE subject_description = '$subject_description'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $subject_units = $row['subject_units'];
    } else {
        $subject_units = "";
    }

    // Update the data in the faculty_loading table
    $id = $_POST['id'];
    $sql = "UPDATE faculty_loadings SET teacher='$teacher', subject_description='$subject_description', subject_units='$subject_units', course_name='$course_name', section_name='$section_name', section_year='$section_year' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data updated successfully');</script>";
        echo "<script>window.location.href = 'faculty_loading_list.php';</script>";
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div>';
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

<body>
    <!-- Your HTML code for the page goes here -->
    <div class="container">

        <h2>Update Faculty Loading</h2>

        <?php
        // Retrieve the data of the selected faculty loading record
        $id = $_GET['id'];
        $sql = "SELECT * FROM faculty_loadings WHERE id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form method="post">

            
                <div class="form-group">
                    <label for="teacher">Teacher:</label>
                    <input type="text" class="form-control" id="teacher" name="teacher"
                        value="<?php echo $row['teacher']; ?>">
                </div>
                <div class="form-group">
                    <label for="subject_description">Subject Description:</label>
                    <input type="text" class="form-control" id="subject_description" name="subject_description"
                        value="<?php echo $row['subject_description']; ?>">
                </div>
                <div class="form-group">
                    <label for="course_name">Course Name:</label>
                    <input type="text" class="form-control" id="course_name" name="course_name"
                        value="<?php echo $row['course_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="section_name">Section Name:</label>
                    <input type="text" class="form-control" id="section_name" name="section_name"
                        value="<?php echo $row['section_name']; ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="section_year">Section Year:</label>
                    <input type="text" class="form-control" id="section_year" name="section_year"
                        value="<?php echo $row['section_year']; ?>">
                </div>

                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-danger" href="faculty_loading_list.php">Back</a>
            </form>

            <?php
        } else {
            echo '<div class="alert alert-danger" role="alert">No record found.</div>';
        }
        ?>
    </div>
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
        </script>
</body>

</html>