<?php
include 'database_connection.php';
include 'index.php';

// Function to check if a teacher is available at the given day and time
function isTeacherAvailable($teacher, $day, $start_time, $end_time)
{
    global $conn;

    $sql = "SELECT * FROM faculty_loadings WHERE teacher = ? AND day = ? AND (start_time < ? AND end_time > ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $teacher, $day, $end_time, $start_time);
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_num_rows($result) == 0;
}

// Function to check if a room is available at the given day and time
function isRoomAvailable($room_name, $day, $start_time, $end_time)
{
    global $conn;

    $sql = "SELECT * FROM faculty_loadings WHERE room_name = ? AND day = ? AND (start_time < ? AND end_time > ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $room_name, $day, $end_time, $start_time);
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_num_rows($result) == 0;
}

// Function to check if there is a conflict in course_year_section
function isCourseYearSectionConflict($course_year_section, $day, $start_time, $end_time)
{
    global $conn;

    $sql = "SELECT * FROM faculty_loadings WHERE course_year_section = ? AND day = ? AND (start_time < ? AND end_time > ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $course_year_section, $day, $end_time, $start_time);
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_num_rows($result) > 0;
}

$error = '';

function check_teacher_load($teacher)
{
    global $conn;
    $query = "SELECT COUNT(*) as count FROM faculty_loadings WHERE teacher=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $teacher);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    $count = $row['count'];
    return $count;
}

if (isset($_POST['submit'])) {
    $teacher = mysqli_real_escape_string($conn, $_POST['teacher']);
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $courseName = mysqli_real_escape_string($conn, $_POST['course_name']);
    $sectionName = mysqli_real_escape_string($conn, $_POST['section_name']);
    $sectionYear = mysqli_real_escape_string($conn, $_POST['section_year']);
    $roomName = mysqli_real_escape_string($conn, $_POST['room_name']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $startTime = mysqli_real_escape_string($conn, $_POST['start_time']);
    $endTime = mysqli_real_escape_string($conn, $_POST['end_time']);

    // Check if the teacher has reached the maximum load
    $teacherLoad = check_teacher_load($teacher);
    if ($teacherLoad >= 30) {
        $error = "Teacher has reached the maximum load.";
    } else {
    // Check if the timeslot is available for the teacher, room, and course year section
    $isTeacherAvailable = isTeacherAvailable($teacher, $day, $startTime, $endTime);
    $isRoomAvailable = isRoomAvailable($roomName, $day, $startTime, $endTime);
    $isCourseYearSectionConflict = isCourseYearSectionConflict("$courseName $sectionYear $sectionName", $day, $startTime, $endTime);

    if ($isTeacherAvailable && $isRoomAvailable && !$isCourseYearSectionConflict) {
        // Insert the schedule into the database
        $query = "INSERT INTO faculty_loadings (teacher, subject_code, course_name, section_name, section_year, room_name, day, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssss", $teacher,$subject_code, $courseName, $sectionName, $sectionYear, $roomName, $day, $startTime, $endTime);
        $stmt->execute();
        $stmt->close();

        echo "Schedule added successfully.";
    } else {
        $error  = "There is a schedule conflict. Check for the schedule of Teacher, Course Section and Room availability in view schedule page.";
    }
}

// Display the error message if there is any
if (!empty($error)) {
    echo $error;
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
        <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)"
            class="fw-bolder text-center text-warning mt-3 text-outline">ADD MANUAL SCHEDULE</H1>
        <!-- Dropdown for selecting a teacher -->
        <div class="form-group">
            <label for="teacher">Teacher</label>
            <select class="form-control" id="teacher" name="teacher">
                <?php
                $sql = "SELECT * FROM teachers";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['firstname'] . ' ' . $row['lastname'] . '"' . $selected . '>' . $row['firstname'] . ' ' . $row['lastname'] . '</option>';
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

        <!-- Form for selecting a subject -->
        <div class="form-group">
            <label for="subject_code">Subject Code and Title</label>
            <select class="form-control" id="subject_code" name="subject_code">
                <?php
                $sql = "SELECT subject_description, subject_code FROM subjects";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["subject_description"] .  $row["subject_code"] .'">' . "[". $row["subject_code"] ."]  "."[". $row["subject_description"] ."]".'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dropdown for selecting a section -->
        <div class="form-group">
            <label for="section_name">Section</label>
            <select class="form-control" id="section_name" name="section_name">
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
                $year_choices = ['1st', '2nd', '3rd', '4th'];
                foreach ($year_choices as $year) {
                    echo '<option value="' . $year . '">' . $year . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="day">Day</label>
            <select class="form-control" id="day" name="day">
                <?php
                $sql = "SELECT * FROM available_days";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["day"] . '">' . $row["day"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dropdown for selecting a room -->
        <div class="form-group">
            <label for="room_name">Room</label>
            <select class="form-control" id="room_name" name="room_name">
                <?php
                $sql = "SELECT * FROM rooms";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["room_name"] . '">' . $row["room_name"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dropdown for selecting a start time -->
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <select class="form-control" id="start_time" name="start_time">
                <?php
                $sql = "SELECT start_time FROM timeslots";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $start_time = date("h:i A", strtotime($row["start_time"]));
                        echo '<option value="' . $row["start_time"] . '">' . $start_time . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dropdown for selecting a start time -->
        <div class="form-group">
            <label for="end_time">End Time</label>
            <select class="form-control" id="end_time" name="end_time">
                <?php
                $sql = "SELECT end_time FROM timeslots";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $end_time = date("h:i A", strtotime($row["end_time"]));
                        echo '<option value="' . $row["end_time"] . '">' . $end_time . '</option>';
                    }
                }
                ?>
            </select>
        </div>


        <div class="mt-3">
            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="manual_schedule_list.php" class="btn btn-danger" name="back">Back</a>
        </div>
    </div>

</form>
</body>

</html>