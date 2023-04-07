<?php 
include 'database_connection.php';

// Retrieve all faculty loadings and sort them by course name in ascending order
$query = "SELECT * FROM generated_schedules ORDER BY course_name ASC";
$result = $conn->query($query);
$generated_schedules = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $generated_schedules[] = $row;
    }
}

// Create a list of available timeslots for each day
$days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
$timeslots = array();
foreach ($days as $day) {
    $timeslots[$day] = array();
    for ($hour = 7; $hour <= 19; $hour++) {
        $timeslots[$day][$hour] = true;
    }
}

// Assign timeslots to faculty loadings
$schedule = array();
foreach ($generated_schedules as $faculty_loading) {
    $teacher = $faculty_loading['teacher'];
    $subject_code = $faculty_loading['subject_code'];
    $subject_type = $faculty_loading['subject_type'];
    $room = $faculty_loading['room'];
    $day = $faculty_loading['day'];

    // Check if the teacher is already assigned to another subject at the same day and timeslot
    $conflict = false;
    for ($hour = $faculty_loading['start_time']; $hour <= $faculty_loading['end_time']; $hour++) {
        if (!$timeslots[$day][$hour]) {
            $conflict = true;
            break;
        }
    }
    if ($conflict) {
        continue;
    }

    // Assign timeslots to the subject
    if ($subject_type == 'Lecture') {
        $timeslot = null;
        for ($hour = 7; $hour <= 19; $hour++) {
            if ($timeslots[$day][$hour]) {
                $timeslot = $hour;
                break;
            }
        }
        if ($timeslot !== null) {
            $schedule[] = array(
                'teacher' => $teacher,
                'subject_code' => $subject_code,
                'course_name' => $faculty_loading['course_name'],
                'subject_type' => $subject_type,
                'room' => $room,
                'day' => $day,
                'start_time' => $timeslot,
                'end_time' => $timeslot + 1
            );
            $timeslots[$day][$timeslot] = false;
        }
    } else if ($subject_type == 'Laboratory') {
        $start_time = $faculty_loading['start_time'];
        $end_time = $faculty_loading['end_time'];
        // Check if the laboratory subject can be assigned to a specific timeslot
        $available_timeslots = array();
        for ($hour = $start_time; $hour <= $end_time; $hour++) {
            if ($timeslots[$day][$hour]) {
                $available_timeslots[] = $hour;
            }
        }
        if (count($available_timeslots) == ($end_time - $start_time + 1)) {
            $timeslot = $start_time;
            foreach ($available_timeslots as $available_timeslot) {
                if ($available_timeslot != $timeslot) {
                    break;
                }
                $timeslot++;
            }
            $schedule[] = array(
                'teacher' => $teacher,
                'subject_code' => $subject_code,
                'course_name' => $faculty_loading['course_name'],
                'subject_type'=>$subject_type,
                'room' => $room,
                'day' => $day,
                'start_time' => $start_time,
                'end_time' => $end_time
                );
                for ($hour = $start_time; $hour <= $end_time; $hour++) {
                $timeslots[$day][$hour] = false;
                }
                }
                }
                }
                
                // Print the schedule
               // Print the schedule
echo '<table>';
echo '<tr><th>Teacher</th><th>Subject Code</th><th>Course Name</th><th>Subject Type</th><th>Room</th><th>Day</th><th>Start Time</th><th>End Time</th></tr>';
foreach ($schedule as $schedule_item) {
    echo '<tr>';
    echo '<td>' . $schedule_item['teacher'] . '</td>';
    echo '<td>' . $schedule_item['subject_code'] . '</td>';
    echo '<td>' . $schedule_item['course_name'] . '</td>';
    echo '<td>' . $schedule_item['subject_type'] . '</td>';
    echo '<td>' . $schedule_item['room'] . '</td>';
    echo '<td>' . $schedule_item['day'] . '</td>';
    echo '<td>' . $schedule_item['start_time'] . ':00</td>';
    echo '<td>' . ($schedule_item['end_time'] - 1) . ':59</td>';
    echo '</tr>';
}
echo '</table>';

                
                // Close database connection
                $conn->close();
                ?>
