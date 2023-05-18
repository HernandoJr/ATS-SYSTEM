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
$button_text = "Assign Timeslots";
if ($count == 0) {
    $button_disabled = "disabled";
    $button_text = "No Data";
}

// Check if the button was clicked
if (isset($_POST['assign_timeslots'])) {
    // Retrieve the data from the automated_schedule table
    $sql = "SELECT * FROM faculty_loadings";
    $result = mysqli_query($conn, $sql);

    // Define the available time range for the course schedule
    $start_time = strtotime("7:00am");
    $end_time = strtotime("7:00pm");

    // Initialize arrays to store assigned timeslots and days
    $assigned_timeslots = array();
    $assigned_days = array();

    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Retrieve the subject hours and validate if it's a numeric value
        $subject_hours = $row['subject_hours'];

        if (!is_numeric($subject_hours)) {
            continue; // Skip this row if subject hours is not numeric
        }

        // Calculate the number of timeslots needed for the subject
        $timeslots_needed = ceil($subject_hours);
        $day = $row['day'];

        $duration = $subject_hours * 3600; // Convert subject hours to seconds

        // Find available timeslots for the subject
        $available_timeslots = findAvailableTimeslots($timeslots_needed, $duration, $start_time, $end_time, $assigned_timeslots, $assigned_days, $day, $row['id']);

        // If enough timeslots are found, assign them to the automated_schedule table
        if (count($available_timeslots) >= $timeslots_needed) {
            for ($i = 0; $i < $timeslots_needed; $i++) {
                $start_time = date('H:i:s', $available_timeslots[$i]['start_time']);
                $end_time = date('H:i:s', $available_timeslots[$i]['end_time']);
                $day = $available_timeslots[$i]['day'];
                $sql = "UPDATE faculty_loadings SET start_time='$start_time', end_time='$end_time', day='$day' WHERE id=" . $row['id'];
                mysqli_query($conn, $sql);
            }
        } else {
            // Not enough timeslots available for the subject
            // You can handle this case as needed
               }
    }
}

function findAvailableTimeslots($timeslots_needed, $duration, $start_time, $end_time, $assigned_timeslots, $assigned_days, $day, $current_row_id) {
    global $conn;

    $current_time = $start_time;
    $available_timeslots = array();
    $current_time = intval($current_time);
    $duration = intval($duration);
    $end_time = intval($end_time);
    
    while (count($available_timeslots) < $timeslots_needed && $current_time + $duration <= $end_time) {
        $current_day = date('l', $current_time);

        if (!in_array($current_day, $assigned_days)) {
            $conflict = false;

            foreach ($assigned_timeslots as $timeslot) {
                if ($current_time >= $timeslot['start_time'] && $current_time < $timeslot['end_time']) {
                    $conflict = true;
                    break;
                }
            }

            if (!$conflict) {
$sql = "SELECT * FROM faculty_loadings WHERE start_time >= '$current_time' AND end_time <= '" . ($current_time + $duration) . "' AND day = '$current_day' AND id <> $current_row_id";
                $result = mysqli_query($conn, $sql);
                $rows = mysqli_num_rows($result);

                if ($rows == 0) {
                    $available_timeslots[] = array(
                        'start_time' => $current_time,
                        'end_time' => $current_time + $duration,
                        'day' => $current_day,
                    );

                    $assigned_timeslots[] = array(
                        'start_time' => $current_time,
                        'end_time' => $current_time + $duration,
                    );

                    $assigned_days[] = $current_day;
                }
            }
        }

        $current_time = strtotime('+1 hour', $current_time); // Move to the next hour
    }

    return $available_timeslots;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Automated_schedule</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Automating the assigning of timeslot, day and rooms</h1>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Course Year and Section</th>
                    <th>Subject Code</th>
                    <th>Subject Hours</th>
                    <th>Instructor</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Day</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve the data from the faculty_loading table in ascending order by course section and year
                $sql = "SELECT * FROM faculty_loadings ORDER BY course_year_section ASC";
                $result = mysqli_query($conn, $sql);

                // Loop through each row in the result set and display the data in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['course_year_section'] . "</td>";
                    echo "<td>" . $row['subject_code'] . "</td>";
                    echo "<td>" . $row['subject_hours'] . "</td>";
                    echo "<td>" . $row['teacher'] . "</td>";
                    echo "<td>" . date("g:i A", strtotime($row['start_time'])) . "</td>";
                    echo "<td>" . date("g:i A", strtotime($row['end_time'])) . "</td>";
                    echo "<td>" . $row['day'] . "</td>";
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
