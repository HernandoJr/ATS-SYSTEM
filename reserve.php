<?php
include 'database_connection.php';
include 'index.php';

// Function to check if a teacher is available at the given day and time
function isTeacherAvailable($teacher, $day, $start_time, $end_time)
{
    global $conn;
$room_type = getRoomTypeForSubjectType($subject_type);
assignTimeslots($courses, $room_type);
    $sql = "SELECT * FROM faculty_loadings WHERE teacher = '$teacher' AND day = '$day' AND (start_time < '$end_time' AND end_time > '$start_time')";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result) == 0;
}
// Function to check if a room is available at the given day and time
function isRoomAvailable($room_name, $day, $start_time, $end_time)
{
    global $conn;

    $sql = "SELECT * FROM faculty_loadings WHERE room_name = '$room_name' AND day = '$day' AND (start_time < '$end_time' AND end_time > '$start_time')";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result) == 0;
}
// Function to get the room type for a given subject type
function getRoomTypeForSubjectType($subject_type)
{
    if ($subject_type == 'lab') {
        return 'lab';
    } elseif ($subject_type == 'lec') {
        return 'lec';
    }
    // Add more conditions if needed for other subject types

    return null; // Return null if no matching room type found
}

// Function to get the list of available rooms for a given subject type
function getAvailableRoomsForSubjectType($subject_type)
{
    global $conn;

    $room_type = getRoomTypeForSubjectType($subject_type);

    if ($room_type) {
        $sql = "SELECT * FROM rooms WHERE room_type = '$room_type'";
        $result = mysqli_query($conn, $sql);

        $available_rooms = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $available_rooms[] = $row['room_name'];
        }

        return $available_rooms;
    }

    return null; // Return null if no matching room type found
}

// Function to check if there is a conflict in course_year_section
function isCourseYearSectionConflict($course_year_section, $day, $start_time, $end_time)
{
    global $conn;

    $sql = "SELECT * FROM faculty_loadings WHERE course_year_section = '$course_year_section' AND day = '$day' AND (start_time < '$end_time' AND end_time > '$start_time')";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result) > 0;
}
// Function to assign timeslots to courses using backtracking$room_type = getRoomTypeForSubjectType($subject_type);
assignTimeslots($courses, $room_type);
function assignTimeslots($courses, $room_type)
{
    global $conn;

    // Base case: If all courses have been assigned timeslots, return true
    if (empty($courses)) {
        return true;
    }

    // Select the first course from the list
    $course = array_shift($courses);
    $subjectHours = $course['subject_hours'];

    // Retrieve a timeslot with the corresponding duration
    $duration = '';
    if ($subjectHours == 1) {
        $duration = "01:00:00";
    } elseif ($subjectHours == 1.5) {
        $duration = "01:30:00";
    } elseif ($subjectHours == 2) {
        $duration = "02:00:00";
    } elseif ($subjectHours == 3) {
        $duration = "03:00:00";
    }

    // Retrieve available timeslots with the same duration
    $timeslot_sql = "SELECT * FROM timeslots WHERE TIMEDIFF(end_time, start_time) = '$duration'";
    $timeslot_result = mysqli_query($conn, $timeslot_sql);

    // Check for SQL query error
    if (!$timeslot_result) {
        die('Error retrieving timeslots: ' . mysqli_error($conn));
    }

    // Loop through each available timeslot
    while ($timeslot_row = mysqli_fetch_assoc($timeslot_result)) {
        // Randomly select a room and retrieve its name and type
        $room_sql = "SELECT room_name, room_type FROM rooms WHERE room_type = '$room_type' ORDER BY RAND()";
        $room_result = mysqli_query($conn, $room_sql);

        // Check for SQL query error
        if (!$room_result) {
            die('Error retrieving rooms: ' . mysqli_error($conn));
        }

        // Loop through each available room
        while ($room_row = mysqli_fetch_assoc($room_result)) {
            $room_name = $room_row['room_name'];

            // Randomly select a day from available_days
            $day_sql = "SELECT day FROM available_days ORDER BY RAND()";
            $day_result = mysqli_query($conn, $day_sql);

            // Check for SQL query error
            if (!$day_result) {
                die('Error retrieving days: ' . mysqli_error($conn));
            }

            // Loop through each available day
            while ($day_row = mysqli_fetch_assoc($day_result)) {
                $day = $day_row['day'];

                // Check if the teacher, room, and course year section are available at the selected day and timeslot
                if (isTeacherAvailable($course['teacher'], $day, $timeslot_row['start_time'], $timeslot_row['end_time']) &&
                    isRoomAvailable($room_name, $day, $timeslot_row['start_time'], $timeslot_row['end_time']) &&
                    !isCourseYearSectionConflict($course['course_year_section'], $day, $timeslot_row['start_time'], $timeslot_row['end_time'])) {
                    // Assign the timeslot, day, room name, and room type to the course
                    $update_sql = "UPDATE faculty_loadings SET start_time = '{$timeslot_row['start_time']}', end_time = '{$timeslot_row['end_time']}', day = '$day', room_name = '$room_name', room_type = '$room_type' WHERE course_code = '{$course['course_code']}'";
                    $update_result = mysqli_query($conn, $update_sql);

                    // Check for SQL query error
                    if (!$update_result) {
                        die('Error updating faculty loadings: ' . mysqli_error($conn));
                    }

                    // Recursively assign timeslots to the remaining courses
                    if (assignTimeslots($courses, $room_type)) {
                        return true;
                    }

                    // If the assignment was unsuccessful, undo the assignment
                    $undo_sql = "UPDATE faculty_loadings SET start_time = NULL, end_time = NULL, day = NULL, room_name = NULL, room_type = NULL WHERE course_code = '{$course['course_code']}'";
                    $undo_result = mysqli_query($conn, $undo_sql);

                    // Check for SQL query error
                    if (!$undo_result) {
                        die('Error undoing faculty loadings update: ' . mysqli_error($conn));
                    }
                }
            }
        }
    }

    // If no valid assignment is possible, return false
    return false;
}


// Check if the faculty_loading table is empty
$sql = "SELECT COUNT(*) AS count FROM faculty_loadings";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];

// Set the button state based on whether the faculty_loading table is empty or not
$button_disabled = "";
$button_text = "Randomize the schedule";
if ($count == 0) {
    $button_disabled = "disabled";
    $button_text = "No Data";
}

// Check if the button was clicked
if (isset($_POST['assign_timeslots'])) {
     
    // Retrieve the data from the faculty_loading table
    $sql = "SELECT * FROM faculty_loadings";
    $result = mysqli_query($conn, $sql);

    // Check for SQL query error
    if ($result) {
        // Store the courses in an array
        $courses = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }

        // Call the backtrack function to assign timeslots to the courses
        $success = assignTimeslots($courses);

        if ($success) {
            echo "Timeslots assigned successfully.";
        } else {
            echo "Unable to assign timeslots without conflicts.";
        }
    } else {
        die('Error retrieving faculty_loadings data: ' . mysqli_error($conn));
    }
}



// Check if the faculty_loading table is not empty
if ($count > 0) {
    // Display the timetable
    echo '
    <!DOCTYPE html>
    <html>
    <head>
    
        <title>Faculty Loading System</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
 
    <style>
    .table-bordered {
        border:.2rem solid;
        text-align:center;
        vertical-align:middle;

    }

    @media print {
        body {
            visibility: hidden;
    
        .print-page {
            visibility: visible;
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            padding: 20mm;
            box-sizing: border-box;
            page-break-after: always;
        }
    }
</style>
<div class="container print-page ">
    
    <h1 class="mt-5 bg-dark text-center text-light">AUTOMATED SCHEDULE</h1>
    <table class="table mt-4 print-table table-bordered table table-hover table-sm">

    <thead class="thead-dark bg-success text-light fw-bolder text-light">               
       <tr>
                        <th>Time</th>'; // Empty cell for spacing
    
    // Loop through the days (Monday to Friday)
    $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');

    foreach ($days as $day) {
        echo "<th>{$day}</th>";
    }
    
    echo '</tr>
            </thead>
            <tbody>';

    // Loop through the time slots
    $start_time = strtotime('07:00:00');
    $end_time = strtotime('19:00:00');

    while ($start_time < $end_time) {
        $end_time_formatted = date('h:i A', strtotime('+30 minutes', $start_time));
        echo "<tr>";
        echo "<th>" . date('h:i A', $start_time) . " - " . $end_time_formatted . "</th>";
    
        // Loop through the days (Monday to Friday)
        foreach ($days as $day) {
            echo '<td>';

            // Retrieve the data from the faculty_loading table for the current day and time interval
            $sql = "SELECT * FROM faculty_loadings WHERE day = '$day' AND start_time <= '" . date('H:i:s', $start_time) . "' AND end_time > '" . date('H:i:s', $start_time) . "'";
            $result = mysqli_query($conn, $sql);

            // Check for SQL query error
            if ($result) {
                $combined_data = '';
                while ($row = mysqli_fetch_assoc($result)) {
                    $combined_data .= '<div class="text-center">' . $row['teacher'] . '<br>' . $row['subject_code'] . '<br>' . $row['course_year_section'] . '<br>' . $row['room_name'] . '<br><br></div>';
                }
                echo $combined_data;
            } else {
                die('Error retrieving faculty_loadings data: ' . mysqli_error($conn));
            }

            echo '</td>';
        }

        echo '</tr>';

        $start_time = strtotime('+30 minutes', $start_time);
    }

    echo '</tbody>
        </table>

        <form method="post">
        <button type="submit" name="assign_timeslots" class="btn btn-primary mt-4" ' . $button_disabled . '>' . $button_text . '</button>
        <button class="btn btn-danger mt-4" onclick="window.print()">Print</button>

        </form>
    </

div>
    </body>
    </html>';
} else {
    echo "No data available.";
}
?>