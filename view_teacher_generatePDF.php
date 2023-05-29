<?php
require_once 'TCPDF_TEMPLATE/TCPDF_TEMPLATE/TCPDF-main/tcpdf.php'; // Include TCPDF library

include 'database_connection.php';

// Start output buffering
ob_start();

// Generate PDF using TCPDF
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TuyPogi');
$pdf->SetTitle('Teacher Schedules');
$pdf->SetMargins(5, 5, 5);
$pdf->SetHeaderMargin(2);
$pdf->SetFooterMargin(5);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$html = '
<!DOCTYPE html>
<html>
<head>
    <title>View Schedule</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <style>
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: white;
        font-family: arial bold;
        background-color: darkgreen;
    }

    .table-bordered {
        border: 2px solid black;
    }

    .table-bordered th,
    .table-bordered td {
        border: 2px solid black;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
    }
    

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }
    

    .table-primary,
    .table-primary > th,
    .table-primary > td {
        background-color: #F3E8EA;
        color: black;
    }

    .table-warning,
    .table-warning > th,
    .table-warning > td {
        background-color: #ffc107;
        color: #212529;
    }

    .table-info,
    .table-info > th,
    .table-info > td {
        background-color:#D4FF5A;
        color: black;
    }

    .table-danger,
    .table-danger > th,
    .table-danger > td {
        background-color: #A0FCFF;
        color: black;
    }

    .table-secondary,
    .table-secondary > th,
    .table-secondary > td {
        background-color:#FF6E6E;
        ;
        color: black;
    }

    .bg-light {
        background-color: #FFC646 !important;
    }

    .fw-bolder {
        font-weight: bolder !important;
    }

    .text-center {
        text-align: center !important;
        color: black !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    .text-outline {
        -webkit-text-stroke-width: 1px;
        -webkit-text-stroke-color: rgba(0, 0, 0, 0.5);
        text-shadow: 5px 2px 3px rgba(0, .5, 0, .80);
    }

    .mt-4 {
        margin-top: 1.5rem !important;
    }

    .alert {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    /* Add vertical-align: middle to table cells */
    .table td,
    .table th {
        vertical-align: middle;
    }

    /* Separate page for each table */
    .table-container {
        page-break-after: always;
    }
    
    /* Change weight of subject_title column */
    .table td:nth-child(4),
    .table th:nth-child(4) {
        font-weight: bold;
    }

    
</style>



</head>
<body>
    <h1 style="text-align:center;font-weight:bold;font-size:2.9em;color:darkgreen;font-family:monospace;">TEACHER SCHEDULES</h1>
';
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
    $html .= '<div class="container">';

    while ($row = $result->fetch_assoc()) {
        $teacher = $row['teacher'];
        $sql = "SELECT * FROM faculty_loadings WHERE teacher = '$teacher' ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), start_time, end_time";
        $scheduleResult = $conn->query($sql);

        if ($scheduleResult !== false && $scheduleResult->num_rows > 0) {
            $html .= '<div class="table-container">'; // Add table container for separate page
            $html .= '<table class="table mt-4 table-bordered table-hover">';
            $html .= '<thead class="fw-bolder bg-dark text-light"><tr><th>Teacher</th><th>Day</th><th>Subject Code</th><th>Subject Title</th><th>Course Year & Section</th><th>Room</th><th>Start_Time</th><th>End_Time</th></tr></thead>';
            $html .= '<tbody>';

            $firstRow = true; // Flag to check if it's the first row for the course_year_section
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
                }elseif ($day == 'Friday') {
                    $bgColorClass = 'table-secondary';
                } 
            
                $html .= '<tr class="' . $bgColorClass . '">';

                // Output teacher only for the first row
                if ($firstRow) {
                    $firstRow = false;
                    $html .= '<td class="header_row bg-light" rowspan="' . $scheduleResult->num_rows . '">' . $teacher . '</td>';
                }
                // Check if the current day is the same as the previous day
                if ($day != $previousDay) {
                    // Calculate the rowspan value for the day
                    $rowspan = calculateRowspan($teacher, $day);
                    $html .= '<td class="header_row bg-light" rowspan="' . $rowspan . '">' . $day . '</td>';
                }

                $html .= '<td>' . $scheduleRow['subject_code'] . '</td>';
                $html .= '<td>' . $scheduleRow['subject_description'] . '</td>';
                $html .= '<td>' . $scheduleRow['course_year_section'] . '</td>';
                $html .= '<td>' . $scheduleRow['room_name'] . '</td>';
                // Format the start time and end time in 12-hour format with AM/PM
                $html .= '<td>' .  $start_time = date("h:i A", strtotime($scheduleRow['start_time'])). '</td>';
                $html .= '<td>' .  $end_time = date("h:i A", strtotime($scheduleRow['end_time'])). '</td>';
              
                $html .= '</tr>';
                $previousDay = $day;


                // Check if the table exceeds the page height and add a page break if necessary
                if ($pdf->GetY() >= $pdf->getPageHeight() - 100) {
                    $pdf->AddPage();
                }
            }

            $html .= '</tbody>';
            $html .= '</table>';

            $html .= '</div>'; // End of table container
        }

        $scheduleResult->free_result();
    }

    $html .= '</div>';
} else {
    $html .= '<div class="alert alert-info mt-4">No schedule found.</div>';
}

$html .= '
</body>
</html>
';

$pdf->writeHTML($html, true, false, true, false, ''); // Generate PDF from HTML content

$pdf->Output('teacher_schedules.pdf', 'I'); // Output PDF for printing

$conn->close();
ob_end_flush(); // Flush output buffer and turn off output buffering
?>