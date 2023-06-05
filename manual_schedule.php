<?php
include 'database_connection.php';
include 'index.php';


// Check the number of rows in the rooms table, course table
$sql = "SELECT COUNT(*) AS subject_count FROM subjects";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$subject_count = $row['subject_count'];

$sql = "SELECT COUNT(*) AS courses_count FROM courses";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$courses_count = $row['courses_count'];

$sql = "SELECT COUNT(*) AS section_count FROM sections";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$section_count = $row['section_count'];

$sql = "SELECT COUNT(*) AS teacher_count FROM teachers";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$teacher_count = $row['teacher_count'];


if ($teacher_count <= 0 || $courses_count <= 0 || $section_count <= 0 || $subject_count <= 0) {
    echo '<script>alert("Please make sure that you inserted data on the following table:\n 1. Teacher\n 2. Course \n 3. Section \n 4. Subject");</script>';
    echo "<script>window.location.href = 'course_list.php';</script>";
} else {

    $error = '';
    function check_teacher_load($teacher_id)
    {
        global $conn;
        $query = "SELECT COUNT(*) as count FROM manual_generated_schedule WHERE teacher=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $teacher_id);
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
        $teacher = $_POST['teacher'];
        $subjectDescription = $_POST['subject_description'];
        $courseName = $_POST['course_name'];
        $sectionName = $_POST['section_name'];
        $sectionYear = $_POST['section_year'];
        $room_name = $_POST['room_name'];
        $day = $_POST['day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        
        // Combine section_name, section_year, and course_name
        if ($sectionYear == "1st") {
            $course_year_section = $courseName . " 101-" . $sectionName;
        } elseif ($sectionYear == "2nd") {
            $course_year_section = $courseName . " 201-" . $sectionName;
        } elseif ($sectionYear == "3rd") {
            $course_year_section = $courseName . " 301-" . $sectionName;
        } elseif ($sectionYear == "4th") {
            $course_year_section = $courseName . " 401-" . $sectionName;
        } else {
            $course_year_section = $courseName . $sectionYear . $sectionName;
        }


        // Validate form fields (PDO)
        if (empty($teacher) || empty($subjectDescription) || empty($courseName) || empty($sectionName) || empty($sectionYear)) {
            $error = 'Please fill in all required fields.';
        } else {
            // Check teacher load>30 not inserting data anymore
            $teacher_load = check_teacher_load($teacher);
            if ($teacher_load >= 30) {
                $error = 'Teacher has already been assigned 7 subjects.';
                echo "<script>alert('$error');</script>";
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
                    $subjectCode = "";
                }

                // Check if the data already exists in the faculty_loading table
                $stmt = $conn->prepare("SELECT * FROM manual_generated_schedule WHERE teacher=? AND subject_description=? AND course_name=? AND section_name=? AND section_year=?");
                $stmt->bind_param("sssss", $teacher, $subjectDescription, $courseName, $sectionName, $sectionYear);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Data already exists, do nothing
                    echo "<script>alert('The subject was already assigned with the same teacher!');</script>";
                } else {
                    // Check if the subject and course_year_section combination already exists
                    $stmt_check_existence = $conn->prepare("SELECT * FROM faculty_loadings WHERE subject_description=? AND course_name=? AND section_name=? AND section_year=?");
                    $stmt_check_existence->bind_param("ssss", $subjectDescription, $courseName, $sectionName, $sectionYear);
                    $stmt_check_existence->execute();
                    $result_check_existence = $stmt_check_existence->get_result();
                
                    if ($result_check_existence->num_rows > 0) {
                        // Subject and course_year_section combination already exists, do not assign
                        echo "<script>alert('The subject and course section are already assigned!');</script>";
                    } else {
                        // Check for conflicts with day, room_name, start_time, and end_time
                        $stmt_check_conflicts = $conn->prepare("SELECT * FROM faculty_loadings WHERE teacher=? AND course_year_section=? AND day=? AND room_name=? AND ((start_time <= ? AND end_time > ?) OR (start_time < ? AND end_time >= ?))");
                        $stmt_check_conflicts->bind_param("ssssssss", $teacher, $course_year_section, $day, $room_name, $start_time, $start_time, $end_time, $end_time);
                        $stmt_check_conflicts->execute();
                        $result_check_conflicts = $stmt_check_conflicts->get_result();
                
                        if ($result_check_conflicts->num_rows > 0) {
                            // Conflict found, display error message
                            echo "<script>alert('There is a schedule conflict for the specified day, room, and time slot!');</script>";
                        } else {
                            // No conflicts, insert the data into the manual_generated_schedule table
                            $stmt_manual_generated_schedule = $conn->prepare("INSERT INTO manual_generated_schedule (teacher, subject_description, subject_code, subject_hours, subject_type, subject_units, course_name, section_name, section_year, course_year_section, room_name, day, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt_manual_generated_schedule->bind_param("ssssssssssssss", $teacher, $subjectDescription, $subjectCode, $subjectHours, $subjectType, $subjectUnits, $courseName, $sectionName, $sectionYear, $course_year_section, $room_name, $day, $start_time, $end_time);
                
                            try {
                                // Execute the prepared statement to insert into the manual_generated_schedule table
                                $stmt_manual_generated_schedule->execute();
                
                                // Get the last inserted ID from the manual_generated_schedule table
                                $last_inserted_id = $stmt_manual_generated_schedule->insert_id;
                
                                // Insert the same data into the faculty_loadings table
                                $stmt_faculty_loadings = $conn->prepare("INSERT INTO faculty_loadings (teacher, subject_description, subject_code, subject_hours, subject_type, subject_units, course_name, section_name, section_year, course_year_section, room_name, day, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                $stmt_faculty_loadings->bind_param("ssssssssssssss", $teacher, $subjectDescription, $subjectCode, $subjectHours, $subjectType, $subjectUnits, $courseName, $sectionName, $sectionYear, $course_year_section, $room_name, $day, $start_time, $end_time);
                    
                                // Execute the prepared statement to insert into the faculty_loadings table
                                $stmt_faculty_loadings->execute();
                
                                // Close the prepared statements
                                $stmt_manual_generated_schedule->close();
                                $stmt_faculty_loadings->close();
                
                                echo "<script>alert('Data added successfully');</script>";
                                echo "<script>window.location.href = 'manual_schedule_list.php';</script>";
                            } catch (Exception $e) {
                                $error = "Error adding data: " . $e->getMessage();
                            }
                        }
                    }
                }
            }
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
        <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)"
            class="fw-bolder text-center text-warning mt-3 text-outline">ADD MANUAL SCHEDULE</H1>
        <!-- Dropdown for selecting a teacher -->
        <div class="form-group">
            <label for="teacher">Teacher</label>
            <select class="form-control" id="teacher" name="teacher">
                <?php
                $sql = "SELECT * FROM teachers ORDER by firstname ASC";
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
            <label for="subject_description">Subject Description</label>
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