<?php
include 'database_connection.php';
//include 'index.php';

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

            // Retrieve a timeslot that matches the subject hours and subject type
            $timeslot_sql = "SELECT * FROM timeslots WHERE TIMEDIFF(end_time, start_time) = '$duration' AND subject_type IN (SELECT subject_type FROM subjects WHERE id = {$row['id']}) ORDER BY RAND() LIMIT 1";
            $timeslot_result = mysqli_query($conn, $timeslot_sql);

            // Check for SQL query error
            if ($timeslot_result) {
                $timeslot_row = mysqli_fetch_assoc($timeslot_result);

                // Randomly select a room that matches the room type
                $room_sql = "SELECT room_name, room_type FROM rooms WHERE room_type = '{$row['room_type']}' ORDER BY RAND() LIMIT 1";
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

                        // Check if the assigned timeslot, day, room name, and room type already exist in the database
                        $existing_sql = "SELECT * FROM faculty_loadings WHERE start_time = '{$timeslot_row['start_time']}' AND end_time = '{$timeslot_row['end_time']}' AND day = '$day' AND room_name = '$room_name' AND room_type = '$room_type'";
                        $existing_result = mysqli_query($conn, $existing_sql);

                        // Check for SQL query error
                        if ($existing_result) {
                            $existing_row_count = mysqli_num_rows($existing_result);

                            if ($existing_row_count > 0) {
                                // The combination already exists, so skip assigning and continue to the next row
                                continue;
                            } else {
                                // Update the faculty_loading row with the assigned timeslot, day, room name, and room type
                                $update_sql = "UPDATE faculty_loadings SET start_time = '{$timeslot_row['start_time']}', end_time = '{$timeslot_row['end_time']}', day = '$day', room_name = '$room_name', room_type = '$room_type' WHERE id = {$row['id']}";
                                mysqli_query($conn, $update_sql);
                            }
                        } else {
                            die('Error checking existing data: ' . mysqli_error($conn));
                        }
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

$result = $conn->query("SELECT day FROM available_days");
// Check if there are any days in the database
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Retrieve the day value
        $day = $row['day'];

        // Display the day value in the HTML table
        echo "<td>" . $day . "</td>";
    }
} else {
    echo "<tr><td colspan='5'>No days found</td></tr>";
}
?><!DOCTYPE html>
<html>
<head>
    <title>Course Timetable</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Course Timetable</h2>
    <table>
        <thead>
            <tr>
                <th>Time Slot</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve schedule data from your database or data source
            // Replace the example data with your actual data retrieval code

            // Example schedule data
            $scheduleData = [
                // Example schedule data for Monday
                [
                    'day' => 'Monday',
                    'time_slot' => '07:30 AM - 09:00 AM',
                    'course' => 'Math 101',
                    'instructor' => 'John Doe'
                ],
                [
                    'day' => 'Monday',
                    'time_slot' => '10:00 AM - 11:30 AM',
                    'course' => 'English 201',
                    'instructor' => 'Jane Smith'
                ],

                // Example schedule data for Tuesday
                [
                    'day' => 'Tuesday',
                    'time_slot' => '08:00 AM - 09:30 AM',
                    'course' => 'Science 301',
                    'instructor' => 'Michael Johnson'
                ],

                // Example schedule data for Wednesday
                [
                    'day' => 'Wednesday',
                    'time_slot' => '01:00 PM - 02:30 PM',
                    'course' => 'History 401',
                    'instructor' => 'Sarah Anderson'
                ],
            ];

            $start_time = strtotime('7:00 AM');
            $end_time = strtotime('7:00 PM');

            // Loop through each time slot
            while ($start_time < $end_time) {
                $time_slot = date('g:i A', $start_time);
                echo "<tr>";
                echo "<td>$time_slot</td>";

                // Loop through each day (Monday to Friday)
                for ($day = 1; $day <= 5; $day++) {
                    $current_day = date('l', $start_time);
                    $schedule = null;

                    // Find the schedule for the current day and time slot
                    foreach ($scheduleData as $data) {
                        if ($data['day'] === $current_day && $data['time_slot'] === $time_slot) {
                            $schedule = $data;
                            break;
                        }
                    }

                    // Output the schedule information if available
                    if ($schedule) {
                        $course = $schedule['course'];
                        $instructor = $schedule['instructor'];

                        echo "<td>$course<br>$instructor</td>";
                    } else if ($current_day === 'Monday') {
                        // Add an input field for the time slot in the Monday row
                        echo "<td><input type='text' name='timeslot' placeholder='Enter Timeslot'></td>";
                    } else {
                        echo "<td></td>";
                    }
                }

                echo "</tr>";
                $start_time = strtotime('+30 minutes', $start_time);
            }
            ?>
        </tbody>
    </table>
</body>
</html>

