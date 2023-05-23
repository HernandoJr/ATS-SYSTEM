
<?php
//UPDATING CONFLICT
include 'database_connection.php';

$error = '';

if (isset($_POST['submit'])) {
    $teacher = $_POST['teacher'];
    $subjectDescription = $_POST['subject_description'];
    $courseName = $_POST['course_name'];
    $sectionName = $_POST['section_name'];
    $sectionYear = $_POST['section_year'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $day = $_POST['day'];
    $room_name = $_POST['room_name'];
    $id = $_POST['id'];



        // Check if the data already exists in the manual_generated_schedule table except for the current ID
        $stmt = $conn->prepare("SELECT * FROM manual_generated_schedule WHERE start_time =? AND end_time=? AND day=? AND room_name=? AND id!=?");
        $stmt->bind_param("ssssi", $startTime, $endTime, $day, $room_name, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Data already exists, do nothing
            echo "<script>alert('Data already exist!');</script>";
        } else {
            // Data does not exist, update the data in the manual_generated_schedule table
            $stmt = $conn->prepare("UPDATE manual_generated_schedule SET teacher=?, subject_description=?, subject_code=?, subject_hours=?, subject_type=?, subject_units=?, course_name=?, section_name=?, section_year=?, start_time=?, end_time=?, day=?, room_name=? WHERE id=?");
            $stmt->bind_param("sssssssssssssi", $teacher, $subjectDescription, $subjectCode, $subjectHours, $subjectType, $subjectUnits, $courseName, $sectionName, $sectionYear, $startTime, $endTime, $day, $room_name, $id);

            try {
                $stmt->execute();
                echo "<script>alert('Data updated successfully');</script>";
                echo "<script>window.location.href = 'manual_schedule_list.php';</script>";
            } catch (Exception $e) {
                $error = "Error updating data: " . $e->getMessage();
            }
        }
    }

// Get the data of the selected ID from the manual_generated_schedule table
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM manual_generated_schedule WHERE id = ?");
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
        $startTime = $row['start_time'];
        $endTime = $row['end_time'];
        $day = $row['day'];
        $room_name = $row['room_name'];
    } else {
        $error = "No data found with ID: " . $id;
    }
}
// Display error message if there's any
if (!empty($error)) {
    echo "<script>alert('$error');</script>";
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
    <link rel="stylesheet" href="css/faculty_loadings.css">
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
    <div class="container">
    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">UPDATE MANUAL SCHEDULE DETAILS</H1>
        <!-- HTML form to update the data -->
        <form method="POST">
            <div class="mb-3">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="teacher" class="form-label">Teacher:</label>
                <input type="text" name="teacher" id="teacher" class="form-control" value="<?php echo $teacher; ?>"
                    required>
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

            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time:</label>
                <input type="time" name="start_time" id="start_time" class="form-control"
                    value="<?php echo $startTime; ?>" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time:</label>
                <input type="time" name="end_time" id="end_time" class="form-control" value="<?php echo $endTime; ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="day" class="form-label">Day:</label>
                <select name="day" id="day" class="form-select" required>
                    <option value="" disabled selected>Select day</option>
                    <option value="Monday" <?php if ($day == "Monday")
                        echo "selected"; ?>>Monday</option>
                    <option value="Tuesday" <?php if ($day == "Tuesday")
                        echo "selected"; ?>>Tuesday</option>
                    <option value="Wednesday" <?php if ($day == "Wednesday")
                        echo "selected"; ?>>Wednesday</option>
                    <option value="Thursday" <?php if ($day == "Thursday")
                        echo "selected"; ?>>Thursday</option>
                    <optionvalue="Friday" <?php if ($day == "Friday")
                        echo "selected"; ?>>Friday</option>
                        <option value="Saturday" <?php if ($day == "Saturday")
                            echo "selected"; ?>>Saturday</option>
                        <option value="Sunday" <?php if ($day == "Sunday")
                            echo "selected"; ?>>Sunday</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="room_name" class="form-label">Section Name:</label>
                <select class="form-select" id="room_name" name="room_name">
                    <?php
                    $stmt = $conn->prepare("SELECT room_name FROM rooms");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row['room_name'] == $room_name) ? "selected" : "";
                        echo '<option value="' . $row['room_name'] . '"' . $selected . '>' . $row['room_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <button type="submit" name="submit" class="btn btn-success">Update</button>
                <a href="manual_schedule_list.php" class="btn btn-danger">Cancel</a>
            </div>

        </form>
        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $teacher = $_POST['teacher'];
            $subjectDescription = $_POST['subject_description'];
            $courseName = $_POST['course_name'];
            $sectionName = $_POST['section_name'];
            $sectionYear = $_POST['section_year'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $day = $_POST['day'];

            
                //  // Check if the data already exists in the manual_generated_schedule table/AVOID DUPLICATION OF TIMESLOT
        $stmt = $conn->prepare("SELECT * FROM manual_generated_schedule WHERE room_name = ? AND day = ? AND ((start_time <= ? AND end_time > ?) OR (start_time >= ? AND start_time < ?))");
        $stmt->bind_param("ssssss", $room_name, $day, $endTime, $startTime, $startTime, $endTime);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Data already exists, do nothing
            echo "<script>alert('Data already exist!');</script>";
        } else {
            // Data does not exist, insert the data into the faculty_loading table
           // Update the existing record
            $stmt = $conn->prepare("UPDATE classes SET teacher=?, subject_description=?, course_name=?, section_name=?, section_year=?, start_time=?, end_time=?, day=? WHERE id=?");
            $stmt->bind_param("ssssisssi", $teacher, $subjectDescription, $courseName, $sectionName, $sectionYear, $startTime, $endTime, $day, $id);
            $stmt->execute();
            $stmt->close();
            try {
                $stmt->execute();
                echo "<script>alert('Data added successfully');</script>";
                echo "<script>window.location.href = 'manual_schedule_list.php';</script>";
            } catch (Exception $error) {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $error->getMessage() . '</div>';
            }
        }
    }

         
        ?>
    </div>
</body>

</html>

