<?php
include 'database_connection.php';
include 'index.php';

// Get the start and end dates of the current week
$week_start = date('Y-m-d', strtotime('this week'));
$week_end = date('Y-m-d', strtotime('this week +6 days'));

// Generate time slots
$time_slots = array();
$start_time = strtotime('7:00am');
$end_time = strtotime('5:00pm - 30 minutes');
while ($start_time <= $end_time) {
    $time_slots[] = date('h:i A', $start_time);
    $start_time += 1800; // add 30 minutes
}


// Insert time slots and days of the week into the timetable table
foreach ($time_slots as $time_slot) {
$sql = "SELECT * FROM timetable WHERE time_slot BETWEEN '$week_start 07:00:00' AND '$week_end 16:30:00'";
    $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CDN Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--External CSS-->
    <link rel="stylesheet" href="css/index.css">
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
        </script>
    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
    <title>ATS-SYSTEM</title>
</head>

<body>
    <div class="container">
        <h1>Timetable</h1>
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
                // Retrieve timetable data from database
                $sql = "SELECT * FROM timetable WHERE time_slot BETWEEN '$week_start 07:00:00' AND '$week_end 17:00:00'";
                $result = $conn->query($sql);

                // Loop through each row of timetable data and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['time_slot'] . "</td>";
                    echo "<td>" . $row['monday'] . "</td>";
                    echo "<td>" . $row['tuesday'] . "</td>";
                    echo "<td>" . $row['wednesday'] . "</td>";
                    echo "<td>" . $row['thursday'] . "</td>";
                    echo "<td>" . $row['friday'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>