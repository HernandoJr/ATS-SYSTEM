<?php
// Connect to the MySQL database
include 'database_connection.php';
include 'index.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Loop through all courses and sections
$courses_sql = "SELECT * FROM courses";
$courses_result = $conn->query($courses_sql);

if ($courses_result->num_rows > 0) {
    while($course_row = $courses_result->fetch_assoc()) {
        $sections_sql = "SELECT * FROM sections WHERE course_id = " . $course_row["id"];
        $sections_result = $conn->query($sections_sql);

        if ($sections_result->num_rows > 0) {
            while($section_row = $sections_result->fetch_assoc()) {
                // Select all subjects that need to be taught
                $subjects_sql = "SELECT * FROM subjects WHERE course_id = " . $course_row["id"] . " AND section_id = " . $section_row["id"];
                $subjects_result = $conn->query($subjects_sql);

                if ($subjects_result->num_rows > 0) {
                    while($subject_row = $subjects_result->fetch_assoc()) {
                        // Select a teacher who is available during the desired time slot and has not already been assigned to another subject during that time slot
                        $teacher_sql = "SELECT * FROM teachers WHERE NOT EXISTS (
                                            SELECT * FROM schedule
                                            WHERE teacher_id = teachers.id
                                            AND day = '" . $day . "'
                                            AND start_time = '" . $start_time . "'
                                            AND end_time = '" . $end_time . "'
                                        ) LIMIT 1";
                        $teacher_result = $conn->query($teacher_sql);

                        if ($teacher_result->num_rows > 0) {
                            $teacher_row = $teacher_result->fetch_assoc();
                            // Insert the teacher and subject into the schedule table for the appropriate time slot
                            $schedule_sql = "INSERT INTO schedule (teacher_id, subject_id, day, start_time, end_time)
                                             VALUES (" . $teacher_row["id"] . ", " . $subject_row["id"] . ", '" . $day . "', '" . $start_time . "', '" . $end_time . "')";
                            $conn->query($schedule_sql);
                        }
                    }
                }
            }
        }
    }
}

// Display the generated schedule in a timetable format using Bootstrap 5
// TODO: Implement timetable display

$conn
->close();

// Timetable display code here
?>
<!-- Include the Bootstrap 5 CSS and JS files -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

<!-- Create a table to display the schedule -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Time</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop through all time slots from 7 am to 5 pm with 30 minute intervals
        for ($hour = 7; $hour <= 17; $hour++) {
            for ($minute = 0; $minute <= 30; $minute += 30) {
                // Calculate the start time and end time for the current time slot
                $start_time = sprintf('%02d', $hour) . ':' . sprintf('%02d', $minute) . ':00';
                $end_time = sprintf('%02d', $hour) . ':' . sprintf('%02d', $minute + 30) . ':00';

                // Display the time slot in the first column of the table
                echo '<tr>';
                echo '<td>' . $start_time . ' - ' . $end_time . '</td>';

                // Loop through all days of the week
                $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
                foreach ($days as $day) {
                    // Select all entries in the schedule table that match the current day and time slot
                    $schedule_sql = "SELECT schedule.*, teachers.name, subjects.code
                                     FROM schedule
                                     JOIN teachers ON schedule.teacher_id = teachers.id
                                     JOIN subjects ON schedule.subject_id = subjects.id
                                     WHERE day = '" . $day . "' AND start_time = '" . $start_time . "' AND end_time = '" . $end_time . "'";
                    $schedule_result = $conn->query($schedule_sql);

                    // Display the teacher and subject for the current day and time slot
                    echo '<td>';
                    if ($schedule_result->num_rows > 0) {
                        while ($schedule_row = $schedule_result->fetch_assoc()) {
                            echo $schedule_row['name'] . ' - ' . $schedule_row['code'] . '<br>';
                        }
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>
