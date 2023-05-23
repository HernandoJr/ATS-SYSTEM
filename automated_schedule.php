<?php
include 'database_connection.php';
include 'index.php';

// Check the number of rows in the rooms table, course table
$sql = "SELECT COUNT(*) AS room_count FROM rooms";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$roomCount = $row['room_count'];

$sql = "SELECT COUNT(*) AS courses_count FROM courses";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$courses_count = $row['courses_count'];

if ($roomCount <10 || $courses_count <=1) {
    if($courses_count <=1){
        echo '<script>alert("Required number of course is 2");</script>';
        echo "<script>window.location.href = 'course_list.php';</script>";
        }
    else if($roomCount < 10 && $courses_count <=1){
        echo '<script>alert("[Required Course = 2||Required Rooms = 10]");</script>';
        echo "<script>window.location.href = 'dashboard.php';</script>";
    }
    else{
        echo '<script>alert("Need 10 rooms to automate schedule");</script>';
        echo "<script>window.location.href = 'room_list.php';</script>";
        }
} else {
    
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

// Function to check if there is a conflict in course_year_section
function isCourseYearSectionConflict($course_year_section, $day, $start_time, $end_time)
{
    global $conn;

    $sql = "SELECT * FROM faculty_loadings WHERE course_year_section = '$course_year_section' AND day = '$day' AND (start_time < '$end_time' AND end_time > '$start_time')";
    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result) > 0;
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
       // $timeslot_id = $timeslot_row['timeslot_id'];

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

                // Check if the teacher, room, and course year section are available at the selected day and timeslot
                if (isTeacherAvailable($course['teacher'], $day, $timeslot_row['start_time'], $timeslot_row['end_time']) &&
                    isRoomAvailable($room_name, $day, $timeslot_row['start_time'], $timeslot_row['end_time']) &&
                    !isCourseYearSectionConflict($course['course_year_section'], $day, $timeslot_row['start_time'], $timeslot_row['end_time'])) {
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

// Check if the faculty_loadings table is empty
$sql = "SELECT COUNT(*) AS count FROM faculty_loadings";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];

// SQL query to select data from the table where start_time is empty
$sql_start_time = "SELECT * FROM faculty_loadings WHERE start_time IS NULL";
$result_start_time = mysqli_query($conn, $sql_start_time);
$button_disabled = "";
if ($count == 0) {
    // The faculty_loadings table is empty
    $button_disabled = "disabled";
    $button_text = "Generate";
} elseif ($result_start_time->num_rows > 0) {
    // The start_time column is empty for some rows
    while ($row = mysqli_fetch_assoc($result_start_time)) {
        // Process each row of data
        $columnValue = $row["start_time"];

        // Retrieve the updated value from the database
        $select_sql = "SELECT start_time FROM faculty_loadings WHERE id = " . $row["id"];
        $result_updated_start_time = mysqli_query($conn, $select_sql);
        $updated_start_time = mysqli_fetch_assoc($result_updated_start_time)["start_time"];

        // Check if the start_time value is not null
        if ($updated_start_time !== null) {
            // Additional processing or output
            $button_text = "Regenerate";
        } else {
            $button_text = "Generate";
        }
    } 
} else {
    // The start_time column is not empty for any rows
    $button_text = "Regenerate";
   
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
            echo '<script type="text/javascript">';
            echo ' alert("Schedule is Generated Successfully without conflicts!");';
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
    
<h1 style="  text-shadow: 4px 2px 3px rgba(0, .5, 0, .80);" class="fw-bolder text-center text-warning mt-3 text-outline">AUTOMATED SCHEDULING</H1>

<div class="containe-fluid text-center "><form method="post">
<button type="submit" name="assign_timeslots" id="buttonGenerate" class="btn btn-primary mt-4" ' . $button_disabled . '>' . $button_text . '</button>
<button type="button" class=" mt-4 btn btn-danger" id="truncate">Delete Generated Schedule</button>
</form></div>

<table class="table mt-4 print-table table-bordered table table-hover table-sm">

    <thead class="thead-dark bg-success text-light fw-bolder text-light">               
       <tr>
                        <th>Time</th>'; // Empty cell for spacing
    
    // Loop through the days (Monday to Friday)
    $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday');

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
<div>
    </body>
    </html>';
} else {
   
    echo "<script>alert('No data available!\\nPlease add data to the faculty_loadings table.');</script>";
    echo "<script>window.location.href = 'faculty_loading_list.php';</script>";
}
}
?>

<!-- DELETE SCHED AJAX -->

<script>
    $(document).ready(function () {
        $('#truncate').click(function () {
            if (confirm("Are you sure you want to delete the generated schedule?")) {
                $.ajax({
                    url: "delete_generated_sched.php", // the PHP script that truncates the table
                    success: function (response) {
                        alert(response); // show the response message from the PHP script
                        location.reload(); // reload the page
                    }
                });
            }
        });
    });

</script>

<script>
$(document).ready(function () {
  $('#buttonGenerate').click(function () {
    if (confirm("Are you sure you want to generate the schedule?")) {
      $.ajax({
        url: "automated_schedule.php",
        success: function () {
            alert("Please wait for approximately 1 to 3 minutes while the schedule is being generated.");
          location.reload();
        },
        error: function (xhr, status, error) {
          alert("An error occurred while generating the schedule. Please try again later.");
          console.log(xhr.responseText);
        }
      });
    }
  });
});


</script>

</script>
