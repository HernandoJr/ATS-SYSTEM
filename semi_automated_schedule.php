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
            } elseif ($subjectHours == 3) {
                $duration = "03:00:00";
            }

            $day = $row['day'];

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

                    // Update the faculty_loading row with the assigned timeslot, room name, and room type
                    $update_sql = "UPDATE faculty_loadings SET start_time = '{$timeslot_row['start_time']}', end_time = '{$timeslot_row['end_time']}', day = '{$timeslot_row['day']}', room_name = '$room_name', room_type = '$room_type' WHERE id = {$row['id']}";
                    mysqli_query($conn, $update_sql);
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Loading System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Assigning a Random Timeslot, Day, Room</h1>
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
                    <th>Room Name</th>
                    <th>Room Type</th>
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
                    echo "<td>" . $row['room_name'] . "</td>";
                    echo "<td>" . $row['room_type'] . "</td>";
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
