<?php
include 'database_connection.php';
include 'index.php';

echo '
<!DOCTYPE html>
<html>

<head>
    <title>View Schedule</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <h1 style="  text-shadow: 4px 2px 3px rgba(0, .5, 0, .80);" class="fw-bolder text-center text-warning mt-3 text-outline">TEACHER SCHEDULES</H1>

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
    font-size: 2rem;
    vertical-align: middle;
}

.print-page {
    padding: 20px;
}

.print-table {
    width: 100%;
    border-collapse: collapse;
    page-break-before: always; /* Added property for separate pages */
}

.print-table:not(:first-of-type) {
   page-break-inside: avoid; /* Added property for subsequent tables */
}

.print-table thead th {
    font-weight: bold;
    background-color: #223e28;
    color: #fff;
}

.print-table tbody td {
    padding: 4px;
    
}

.print-table tbody tr:hover {
    background-color: #e0e0e1;
}

.print-btn {
    margin-top: 20px;
}

.header_row{
    color: darkgreen;
    text-align: center;
    vertical-align: middle;
    font-family:monospace;
    font-size:1.5rem;
    font-weight:bold;
}

.bg-dark {
    background-color: yellow;
}

.bg-green {
    background-color: green;
}
.room-label {
    font-size:2rem;
    text-align: center;
    margin-top: 20px;
    fomt-family:monospace;
    vertical-align:middle;

}

@media print {
    body {
        visibility: hidden;
    }

    .print-page {
        visibility: visible;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 20px;
        box-sizing: border-box;
        page-break-after: always;
   

    }

    .print-table thead th {
        padding: 2px;
        font-family: monospace;
        font-size:13px;
        font-weight: bolder;
        color: black;
        text-align:center;
        vertical-align:middle;
        border:3px solid green;
    }

    .print-table thead th:nth-child(1) {
        color:green;
    }
    .print-table thead th:nth-child(2) {
        color:green;
    }
    .print-table thead th:nth-child(3) {
        color:green;
    }
    .print-table thead th:nth-child(4) {
        color:green;
    }

    .print-table thead th:nth-child(5) {
        color:green;
    }
    .print-table thead th:nth-child(6) {
        color:green;
    }

    .print-table thead th:nth-child(7) {
        color:green;
    }
    .print-table thead th:nth-child(8) {
        color:green;
    }


    .print-table tbody td {
        padding: 4px;
        color: black;
        font-family:monospace;
        border:.5px solid ;
    }
    
    
}

</style>;

<script>
// Handle Ctrl+P key press event
document.addEventListener("keydown", function(event) {
    if (event.ctrlKey && event.key === "p" || "P") {
        event.preventDefault(); // Prevent default print action
        window.location.href = "view_teacher_generatePDF.php"; // Redirect to generatePDF.php
    }
});
</script>';


// Function to calculate the rowspan value for the day
function calculateRowspan($teacher, $day) {
    global $conn;
    // Query to count the number of rows for the teacher and day combination
    $countQuery = "SELECT COUNT(*) AS num_rows FROM faculty_loadings WHERE teacher = '$teacher' AND day = '$day'";
    $countResult = $conn->query($countQuery);

    if ($countResult !== false && $countResult->num_rows > 0) {
        $countRow = $countResult->fetch_assoc();
        return $countRow['num_rows'];
    }

    return 1; // Default rowspan value
}
$sql = "SELECT DISTINCT teacher FROM faculty_loadings ORDER BY teacher ASC";
$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    echo '<div class="container print-page">';


    while ($row = $result->fetch_assoc()) {
        $teacher = $row['teacher'];
        $sql = "SELECT * FROM faculty_loadings WHERE teacher = '$teacher' ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), start_time, end_time";
        $scheduleResult = $conn->query($sql);

        
if ($scheduleResult !== false && $scheduleResult->num_rows > 0) {
    echo '<table class="table mt-4 print-table table-bordered table table-hover">';
    echo '<thead class="fw-bolder bg-dark text-light"><tr><th>Teacher</th><th>Day</th><th>Subject Code</th><th>Subject Title</th><th>Subject Type</th></th><th>Room</th><th>Course Year & Section</th><th>Start_Time</th><th>End_Time</th></tr></thead>';
    echo '<tbody>';

    $firstRow = true; // Flag to check if it's the first row for the teacher
  // ...

$previousDay = ""; // Variable to store the previous day
$rowspan = 0; // Variable to store the rowspan value for the day

while ($scheduleRow = $scheduleResult->fetch_assoc()) {
    $day = $scheduleRow['day'];
    $bgColorClass = '';

    // Set background color class based on the day of the week
    if ($day == 'Monday') {
        $bgColorClass = 'table-primary';
    } elseif ($day == 'Tuesday') {
        $bgColorClass = 'table-warning';
    } elseif ($day == 'Wednesday') {
        $bgColorClass = 'table-info';
    } elseif ($day == 'Thursday') {
        $bgColorClass = 'table-danger';
    } elseif ($day == 'Friday') {
        $bgColorClass = 'table-secondary';
    } 

    echo '<tr class="' . $bgColorClass . '">';

    // Output teacher's name only for the first row
    if ($firstRow) {
        $firstRow = false;
        echo '<td class="header_row bg-light" rowspan="' . $scheduleResult->num_rows . '">' . $teacher . '</td>';
    }

    // Check if the current day is the same as the previous day
    if ($day != $previousDay) {
        // Calculate the rowspan value for the day
        $rowspan = calculateRowspan($teacher, $day);
        echo '<td class="header_row bg-light" rowspan="' . $rowspan . '">' . $day . '</td>';
    }

    // Output the remaining table cells
    echo '<td>' . $scheduleRow['subject_code'] . '</td>';
    echo '<td>' . $scheduleRow['subject_description'] . '</td>';
    echo '<td>' . $scheduleRow['subject_type'] . '</td>';
    echo '<td>' . $scheduleRow['room_name'] . '</td>';
    echo '<td>' . $scheduleRow['course_year_section'] . '</td>';

    // Format the start time and end time in 12-hour format with AM/PM
    $start_time = date("h:i A", strtotime($scheduleRow['start_time']));
    $end_time = date("h:i A", strtotime($scheduleRow['end_time']));

    echo '<td>' . $start_time . '</td>';
    echo '<td>' . $end_time . '</td>';

    echo '</tr>';

    // Update the previous day variable
    $previousDay = $day;

}
}
    }
}

