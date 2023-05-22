<?php
include 'database_connection.php';
include 'index.php';



// Function to check if a teacher is available at the given day and time
function isTeacherAvailable($teacher, $day, $start_time, $end_time)
{
    global $conn;

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

// Function to assign timeslots to courses using backtracking
function assignTimeslots($courses)
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
        $timeslot_id = $timeslot_row['timeslot_id'];

        // Randomly select a room and retrieve its name and type
        $room_sql = "SELECT room_name, room_type FROM rooms ORDER BY RAND()";
        $room_result = mysqli_query($conn, $room_sql);

        // Check for SQL query error
        if (!$room_result) {
            die('Error retrieving rooms: ' . mysqli_error($conn));
        }

        // Loop through each available room
        while ($room_row = mysqli_fetch_assoc($room_result)) {
            $room_name = $room_row['room_name'];
            $room_type = $room_row['room_type'];

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

                // Check if the teacher and room are available at the selected day and timeslot
                if (isTeacherAvailable($course['teacher'], $day, $timeslot_row['start_time'], $timeslot_row['end_time']) &&
                    isRoomAvailable($room_name, $day, $timeslot_row['start_time'], $timeslot_row['end_time'])) {
                    // Assign the timeslot, day, room name, and room type to the course
                    $update_sql = "UPDATE faculty_loadings SET start_time = '{$timeslot_row['start_time']}', end_time = '{$timeslot_row['end_time']}', day = '$day', room_name = '$room_name', room_type = '$room_type' WHERE id = {$course['id']}";
                    mysqli_query($conn, $update_sql);

                    // Recursively assign timeslots to the remaining courses
                    $success = assignTimeslots($courses);

                    // If a valid assignment is found for all courses, return true
                    if ($success) {
                        return true;
                    }

                    // If the assignment was not successful, backtrack by resetting the timeslot, day, room name, and room type
                    $update_sql = "UPDATE faculty_loadings SET start_time = NULL, end_time = NULL, day = NULL, room_name = NULL, room_type = NULL WHERE id = {$course['id']}";
                    mysqli_query($conn, $update_sql);
                }
            }
        }
    }

    // If no valid assignment is found, return false
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
        background-color:white;
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
    
    <h1 class="mt-5">RANDOMIZE PLOTTING OF SCHEDULE</h1>
    <table class="table mt-4 print-table table-bordered table table-hover table-sm">

    <thead class="thead-dark bg-dark text-light">               
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
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js"></script>
    </body>
    </html>';
} else {
    echo "No data available in the faculty_loading table.";
}
?>
