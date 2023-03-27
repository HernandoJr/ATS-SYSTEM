<?php
include 'database_connection.php';
include 'index.php';

if (isset($_POST['submit'])) {

    $teacher = $_POST['teacher'];
    $subject_description = $_POST['subject_description'];
    $subject_units = $_POST['subject_units'];
    $course_name = $_POST['course_name'];
    $section_name = $_POST['section_name'];
    $section_year = $_POST['section_year'];

    // Validate input data
    if (empty($teacher) || empty($subject_description) || empty($course_name) || empty($section_name) || empty($section_year) || empty($subject_units)) {
        echo '<div class="alert alert-danger" role="alert">Please select all fields.</div>';
    } else {
        // Insert the data into the faculty_loading table
        list($firstname, $lastname) = explode(' ', $teacher);
        $sql = "UPDATE faculty_loadings SET teacher='$teacher', course_name='$course_name', slots ='$slots' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display an alert message and redirect to Course_list.php
            echo '<script type="text/javascript">';
            echo ' alert("Record updated successfully!");';
            echo ' window.location.href = "course_list.php";';
            echo '</script>';
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



<form method="POST">

    <div class="container mt-3">

        <!-- Dropdown for selecting a teacher -->
        <div class="form-group">
            <label for="teacher">Teacher</label>
            <select class="form-control" id="teacher" name="teacher">
                <?php
                $sql = "SELECT * FROM teachers";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["firstname"] . '' . $row["lastname"] . '">' . $row["firstname"] . ' ' . $row["lastname"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dropdown for selecting a course -->
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

        <!-- Dropdown for selecting a subject -->
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

        <!-- Dropdown for selecting a subject -->
        <div class="form-group">
            <label for="subject_units">Units</label>
            <select class="form-control" id="subject_select" name="subject_units">
                <?php
                $sql = "SELECT * FROM subjects";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["subject_id"] . '" data-units="' . $row["subject_units"] . '">' . $row["subject_description"] . '</option>';
                    }
                }
                ?>
            </select>
            <input class="form-control" id="subject_units" name="subject_units" type="text" readonly>
        </div>

        <script>
            const subjectSelect = document.getElementById('subject_select');
            const subjectUnitsInput = document.getElementById('subject_units');

            subjectSelect.addEventListener('change', () => {
                const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
                subjectUnitsInput.value = selectedOption.getAttribute('data-units');
            });
        </script>



        <!-- Dropdown for selecting a section -->
        <div class="form-group">
            <label for="section_name">Section</label>
            <select class="form-control" id="section_name" name="section_name" ></select>
                 value="<?php echo $row['course_id']; ?>"
                <?php
                $sql = "SELECT * FROM sections";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["section_name"] . '">' . $row["section_name"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dropdown for selecting a section year -->
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