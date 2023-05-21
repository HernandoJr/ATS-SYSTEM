<?php
include 'database_connection.php';
include 'index.php';

echo '
<!DOCTYPE html>
<html>
<head>
    <title>Faculty Loading System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">

<style>
.table-bordered {
    border: .2rem solid;
    text-align: center;
    vertical-align: middle;
}

.header_row{
    color:darkgreen;
    font-family: consolas ;
    text-align: center;
    font-size: 3rem;
    vertical-align: middle;
}



@media print {
    body {
        visibility: hidden;
    }

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
</style>';

$sql = "SELECT DISTINCT room_name FROM faculty_loadings";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    echo '<div class="container print-page">';
    echo '<table class="table mt-4 print-table table-bordered table table-hover">';
    echo '<thead class="fw-bolder bg-dark text-light"><tr><th>Room</th><th>Teacher</th><th>Subject Code</th><th>Subject Description</th><th>Subject Type</th><th>Units</th><th>Subject_hours</th><th>Course Year & Section</th><th>Start_Time</th><th>End_Time</th><th>Day</th></tr></thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $room_name = $row['room_name'];
        $sql = "SELECT * FROM faculty_loadings WHERE room_name = '$room_name' ORDER BY day, start_time, end_time";
        $scheduleResult = $conn->query($sql);

        if ($scheduleResult !== false && $scheduleResult->num_rows > 0) {
            echo '<tr>';
            echo '<td class="header_row" rowspan="' . $scheduleResult->num_rows . '">' . $room_name . '</td>';

            while ($scheduleRow = $scheduleResult->fetch_assoc()) {
                echo '<td>' . $scheduleRow['teacher'] . '</td>';
                echo '<td>' . $scheduleRow['subject_code'] . '</td>';
                echo '<td>' . $scheduleRow['subject_description'] . '</td>';
                echo '<td>' . $scheduleRow['subject_type'] . '</td>';
                echo '<td>' . $scheduleRow['subject_units'] . '</td>';
                echo '<td>' . $scheduleRow['subject_hours'] . '</td>';
                echo '<td>' . $scheduleRow['course_year_section'] . '</td>';

                // Format the start time and end time in 12-hour format with AM/PM
                $start_time = date("h:i A", strtotime($scheduleRow['start_time']));
                $end_time = date("h:i A", strtotime($scheduleRow['end_time']));

                echo '<td>' . $start_time . '</td>';
                echo '<td>' . $end_time . '</td>';

                echo '<td>' . $scheduleRow['day'] . '</td>';
                echo '</tr>';
            }
        }
    }
    
    echo '</tbody><button class="btn btn-danger mt-4" onclick="window.print()">Print</button></table></div>';
    
} else {
    echo 'No rooms found.';
}
?>
