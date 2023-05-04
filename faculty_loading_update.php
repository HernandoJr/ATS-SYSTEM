<?php
include 'database_connection.php';

$error = '';

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $teacher = $_POST['teacher'];
    $subjectDescription = $_POST['subject_description'];
    $courseName = $_POST['course_name'];
    $sectionName = $_POST['section_name'];
    $sectionYear = $_POST['section_year'];

    // Validate form fields
    if (empty($teacher) || empty($subjectDescription) || empty($courseName) || empty($sectionName) || empty($sectionYear)) {
        $error = 'Please fill in all required fields.';
    } else {
        // Get the subject units from the database
        $stmt = $conn->prepare("SELECT subject_units, subject_type, subject_hours, subject_code FROM subjects WHERE subject_description = ?");
        $stmt->bind_param("s", $subjectDescription);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $subjectUnits = $row['subject_units'];
            $subjectType = $row['subject_type'];
            $subjectHours = $row ['subject_hours'];
            $subjectCode = $row ['subject_code'];
        } else {
            $subjectUnits = "";
            $subjectType = "";
            $subjectHours ="";
            $subject_code ="";
        }

        // Update the data in the faculty_loading table
        $stmt = $conn->prepare("UPDATE faculty_loadings SET teacher=?, subject_description=?, subject_code=?, subject_hours=?, subject_type=?, subject_units=?, course_name=?, section_name=?, section_year=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $teacher, $subjectDescription, $subjectCode, $subjectHours,  $subjectType, $subjectUnits, $courseName, $sectionName, $sectionYear, $id);

        try {
            $stmt->execute();
            echo "<script>alert('Data updated successfully');</script>";
            echo "<script>window.location.href = 'faculty_loading_list.php';</script>";
        } catch (Exception $error) {
            echo '<div class="alert alert-danger" role="alert">Error: ' . $error->getMessage() . '</div>';
        }
    }
} else {
    // Get the data to pre-populate the form
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM faculty_loadings WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $teacher = $row['teacher'];
        $subjectDescription = $row['subject_description'];
        $courseName = $row['course_name'];
        $sectionName = $row['section_name'];
        $sectionYear = $row['section_year'];
    } else {
        $error = 'Data not found';
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
  <label for="id">Subject:</label>
  <select class="form-control" id="id" name="id">
<?PHP
      // Retrieve the list of subjects from the SQL table
      $query = "SELECT * FROM subjects";
      $result = mysqli_query($conn, $query);

      // Loop through the results and create an option for each subject
      while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($row['id'] == $subject_id) ? "selected" : "";
        echo "<option value='{$row['id']}' $selected>{$row['subject_description']}</option>";
      }

    ?>
  </select>
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