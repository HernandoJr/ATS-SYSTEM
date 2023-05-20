<?php
include 'database_connection.php';
include 'index.php';

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
        // Loop through each row in the result set and assign a timeslot based on subject hours
        while ($row = mysqli_fetch_assoc($result)) {
            $subjectHours = $row['subject_hours'];

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

            // Check if there is a matching timeslot in the database with the same duration
            $timeslot_sql = "SELECT * FROM timeslots WHERE TIMEDIFF(end_time, start_time) = '$duration' ORDER BY RAND() LIMIT 1";
            $timeslot_result = mysqli_query($conn, $timeslot_sql);

            // Check for SQL query error
            if ($timeslot_result) {
                $timeslot_row = mysqli_fetch_assoc($timeslot_result);

                // Randomly select a room and retrieve its name and type
                $room_sql = "SELECT room_name, room_type FROM rooms ORDER BY RAND() LIMIT 1";
                $room_result = mysqli_query($conn, $room_sql);

                // Check for SQL query error
                if ($room_result) {
                    $room_row = mysqli_fetch_assoc($room_result);
                    $room_name = $room_row['room_name'];
                    $room_type = $room_row['room_type'];

                    // Randomly select a day from available_days
                    $day_sql = "SELECT day FROM available_days ORDER BY RAND() LIMIT 1";
                    $day_result = mysqli_query($conn, $day_sql);

                    // Check for SQL query error
                    if ($day_result) {
                        $day_row = mysqli_fetch_assoc($day_result);
                        $day = $day_row['day'];

                        // Update the faculty_loading row with the assigned timeslot, day, room name, and room type
                        $update_sql = "UPDATE faculty_loadings SET start_time = '{$timeslot_row['start_time']}', end_time = '{$timeslot_row['end_time']}', day = '$day', room_name = '$room_name', room_type = '$room_type' WHERE id = {$row['id']}";
                        mysqli_query($conn, $update_sql);
                    } else {
                        die('Error retrieving day: ' . mysqli_error($conn));
                    }
                } else {
                    die('Error retrieving room: ' . mysqli_error($conn));
                }
            } else {
                die('Error retrieving timeslot: ' . mysqli_error($conn));
            }
        }
    } else {
        die('Error retrieving faculty_loadings data: ' . mysqli_error($conn));
    }
}

// Check if the faculty_loading table is not empty
if ($count > 0) {
    
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Faculty Loading System</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
      
if ($count > 0) {
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
    
    <h1 class="mt-5">Assigning a Random Timeslot, Day, Room</h1>
    <table class="table mt-4 print-table table-bordered table table-hover table-sm">

    <thead class="thead-dark bg-dark text-light">                 
       <tr>
                        <th></th>'; // Empty cell for spacing
    
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

