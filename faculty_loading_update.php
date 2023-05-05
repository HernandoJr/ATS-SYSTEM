<?php
include 'database_connection.php';
include 'index.php';
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
            $subjectHours = $row['subject_hours'];
            $subjectCode = $row['subject_code'];
        } else {
            $subjectUnits = "";
            $subjectType = "";
            $subjectHours = "";
            $subject_code = "";
        }

        // Update the data in the faculty_loading table
        $stmt = $conn->prepare("UPDATE faculty_loadings SET teacher=?, subject_description=?, subject_code=?, subject_hours=?, subject_type=?, subject_units=?, course_name=?, section_name=?, section_year=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $teacher, $subjectDescription, $subjectCode, $subjectHours, $subjectType, $subjectUnits, $courseName, $sectionName, $sectionYear, $id);

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
        $error = 'Invalid data.';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Faculty Loading</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <head>
            
        <h1>Edit Faculty Loading</h1>

            <?php
            // Show error message if there is any
            if (!empty($error)) {
                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
            ?>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                
            <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="teacher" class="form-label">Teacher</label>
                    <input type="text" class="form-control" id="teacher" name="teacher" value="<?php echo $teacher; ?>">
                </div>

                <div class="mb-3">
                    <label for="subject_description" class="form-label">Subject Description:</label>
                    <select name="subject_description" id="subject_description" class="form-select" required>
                        <option value="" disabled selected>Select subject description</option>
                        <?php
                        $stmt = $conn->prepare("SELECT subject_description FROM subjects");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            if ($row['subject_description'] == $subjectDescription) {
                                echo "<option value='" . $row['subject_description'] . "' selected>" . $row['subject_description'] . "</option>";
                            } else {
                                echo "<option value='" . $row['subject_description'] . "'>" . $row['subject_description'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name:</label>
                    <select class="form-select" id="course_name" name="course_name">
                        <?php
                        $stmt = $conn->prepare("SELECT course_name FROM courses");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row['course_name'] == $sectionName) ? "selected" : "";
                            echo '<option value="' . $row['course_name'] . '"' . $selected . '>' . $row['course_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="section-name" class="form-label">Section Name:</label>
                    <select class="form-select" id="section-name" name="section_name">
                        <?php
                        $stmt = $conn->prepare("SELECT section_name FROM sections");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row['section_name'] == $sectionName) ? "selected" : "";
                            echo '<option value="' . $row['section_name'] . '"' . $selected . '>' . $row['section_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="section-year" class="form-label">Section Year:</label>
                    <select class="form-select" id="section-year" name="section_year">
                        <?php
                        $years = array("1st", "2nd", "3rd", "4th");

                        foreach ($years as $year) {
                            $selected = ($year == $sectionYear) ? "selected" : "";
                            echo '<option value="' . $year . '"' . $selected . '>' . $year . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-success">Update</button>
                <a href="faculty_loading_list.php" class="btn btn-danger">Cancel</a>
            </form>

            <!-- Include Bootstrap JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>