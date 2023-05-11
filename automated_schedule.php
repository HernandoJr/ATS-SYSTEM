<?php
include 'database_connection.php';
include 'index.php';

// Define the available time range for the course schedule
$start_time = strtotime("7:00am");
$end_time = strtotime("7:00pm");

$timeslot_durations = array(3600, 7200, 10800); // 1 hour, 2 hours, and 3 hours in seconds

// Check if the faculty_loading table is empty
$sql = "SELECT COUNT(*) AS count FROM faculty_loadings";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];

// Set the button state based on whether the faculty_loading table is empty or not
$button_disabled = "";
$button_text = "Assign Timeslots";
if ($count == 0) {
    $button_disabled = "disabled";
    $button_text = "No Data";
}

// Check if the button was clicked
if (isset($_POST['assign_timeslots'])) {
    // Retrieve the data from the faculty_loading table
    $sql = "SELECT * FROM faculty_loadings";
    $result = mysqli_query($conn, $sql);

    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Calculate the number of timeslots needed for the subject
        $subject_hours = $row['subject_hours'];
        $timeslots_needed = 0;
        if ($subject_hours == 1) {
            $timeslots_needed = 1;
            $duration = $timeslot_durations[0];
        } else if ($subject_hours == 1.5) {
            $timeslots_needed = 1;
            $duration = $timeslot_durations[0] + 1800; // Add 30 minutes to the duration of the 1-hour timeslot
        } else if ($subject_hours == 2) {
            $timeslots_needed = 1;
            $duration = $timeslot_durations[1];
        } else if ($subject_hours == 3) {
            $timeslots_needed = 1;
            $duration = $timeslot_durations[2];
        } else if ($subject_hours > 3) {
            $timeslots_needed = ceil($subject_hours / 3);
            $duration = $timeslot_durations[2];
        }

        // Define the available time range for the course schedule
        $current_time = strtotime('7:00 AM');
        $end_time = strtotime("7:00pm");
        $available_timeslots = array();

        while ($current_time < $end_time && $current_time < $end_time) {
            // Check if the current time is equal or greater than 7 AM
            if ($current_time< $start_time) {
                $current_time = strtotime('+1 hour', $start_time); // Move the current time to the next hour
                continue;
                }
                        // Check if the current time + duration is less than or equal to the end time
        if ($current_time + $duration > $end_time) {
            break; // No more available timeslots
        }

        // Check if the current time is not in conflict with the existing timeslots
        $conflict = false;
        foreach ($available_timeslots as $timeslot) {
            if ($current_time >= $timeslot['start_time'] && $current_time < $timeslot['end_time']) {
                $conflict = true;
                break;
            }
        }

        if (!$conflict) {
            // Add the current timeslot to the available timeslots
            $available_timeslots[] = array(
                'start_time' => $current_time,
                'end_time' => $current_time + $duration,
            );
        }

        $current_time = strtotime('+1 hour', $current_time); // Move the current time to the next hour
    }

    // If enough timeslots are found, assign them to the faculty_loadings table
    if (count($available_timeslots) >= $timeslots_needed) {
        for ($i = 0; $i < $timeslots_needed; $i++) {
            $start_time = date('H:i:s', $available_timeslots[$i]['start_time']);
            $end_time = date('H:i:s', $available_timeslots[$i]['end_time']);
            $sql = "UPDATE faculty_loadings SET start_time='$start_time', end_time='$end_time' WHERE id=" . $row['id'];
            mysqli_query($conn, $sql);
        }
    }
}
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Faculty Loading System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Automating the assigning of timeslot and rooms</h1>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Section</th>
                    <th>Subject Hours</th>
                    <th>Instructor</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Day</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve the data from the faculty_loading table
                $sql = "SELECT * FROM faculty_loadings";
                $result = mysqli_query($conn, $sql);

                // Define the available days for the course schedule
                $available_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

                // Loop through each row in the result set and display the data in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['subject_code'] . "</td>";
                    echo "<td>" . $row['course_year_section'] . "</td>";
                    echo "<td>" . $row['subject_hours'] . "</td>";
                    echo "<td>" . $row['teacher'] . "</td>";
                    echo "<td>" . date("g:i A", strtotime($row['start_time'])) . "</td>";
                    echo "<td>" . date("g:i A", strtotime($row['end_time'])) . "</td>";
                    // Assign a random day for each timeslot
                    $start_time = strtotime($row['start_time']);
                    $duration = strtotime($row['end_time']) - strtotime($row['start_time']);
                    $day = $available_days[array_rand($available_days)];
                    echo "<td>" . $day . "</td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <form method="post">
            <button type="submit" name="assign_timeslots" class="btn btn-primary mt-4" <?php echo $button_disabled; ?>><?php echo $button_text; ?></button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js"></script>
</body>

</html>