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
    color: darkgreen;
    font-family: consolas ;
    text-align: center;
    font-size: 2em;
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

$sql = "SELECT DISTINCT course_year_section FROM faculty_loadings ORDER BY course_year_section";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    echo '<div class="container print-page">';
    echo '<table class="table mt-4 print-table table-bordered table table-hover">';
    echo '<thead class="fw-bolder bg-dark text-light"><tr><th>Course Year & Section</th><th>Subject Code</th><th>Subject Description</th><th>Subject Type</th><th>Units</th><th>Subject hours</th></th><th>Teacher</th><th>Start Time</th><th>End Time</th><th>Room</th><th>Day</th></tr></thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $course_year_section = $row['course_year_section'];
        $sql = "SELECT * FROM faculty_loadings WHERE course_year_section = '$course_year_section' ORDER BY course_year_section ASC";
        $scheduleResult = $conn->query($sql);

        if ($scheduleResult !== false && $scheduleResult->num_rows > 0) {
            echo '<tr>';
            echo '<td class="header_row" rowspan="' . $scheduleResult->num_rows . '">' . $course_year_section . '</td>';

            while ($scheduleRow = $scheduleResult->fetch_assoc()) {
                echo '<td>' . $scheduleRow['subject_code'] . '</td>';
                echo '<td>' . $scheduleRow['subject_description'] . '</td>';
                echo '<td>' . $scheduleRow['subject_type'] . '</td>';
                echo '<td>' . $scheduleRow['subject_units'] . '</td>';
                echo '<td>' . $scheduleRow['subject_hours'] . '</td>';
                echo '<td>' . $scheduleRow['teacher'] . '</td>';
          

                // Format the start time and end time in 12-hour format with AM/PM
                $start_time = date("h:i A", strtotime($scheduleRow['start_time']));
                $end_time = date("h:i A", strtotime($scheduleRow['end_time']));

                echo '<td>' . $start_time . '</td>';
                echo '<td>' . $end_time . '</td>';
                echo '<td>' . $scheduleRow['room_name'] . '</td>';
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
