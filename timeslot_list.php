<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';
// Fetch the time slots from the database and order them by timeslot_id
$result = $conn->query("SELECT start_time, end_time, duration, timeslot_id_based_on_duration FROM timeslots ORDER BY timeslot_id_based_on_duration ASC, start_time ASC, end_time ASC, duration ASC");

// Check if there are any time slots in the database
while ($row = $result->fetch_assoc()) {
    // Determine AM or PM based on the hour value
    $start_time = date('h:i A', strtotime($row['start_time']));
    $end_time = date('h:i A', strtotime($row['end_time']));
    
    $timeSlots[] = array(
        'start_time' => $start_time,
        'end_time' => $end_time,
        'duration' => $row['duration'],
        'timeslot_id' => $row['timeslot_id_based_on_duration']
    );
}


?>
<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CDN Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- External CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
    </script>
    <!-- CDN jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

<div class="container">
  <h4 class="mt-4 fw-bold text-center bg-warning">
    <p class="lead fw-bold">TIMESLOT ID IS BASED ON THE FOLLOWING: [1 = 1 HOUR] [4 = 1 HOUR AND 30 MINUTES] [2 = 2 HOURS] [3 = 3 HOURS]</p>
  </h4>
  <table class="table mt-4 table-bordered table table-hover text-center">
                <thead>
                    
                    <tr>
                        <th>No.</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Timeslot ID</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    if (!empty($timeSlots)) {
        $counter = 1;
        foreach ($timeSlots as $slot) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>";
            echo "<td>" . $slot['start_time'] . "</td>";
            echo "<td>" . $slot['end_time'] . "</td>";
            echo "<td>" . $slot['timeslot_id'] . "</td>";
            echo "</td>";
            echo "</tr>";
            $counter++;
        }
    } else {
        echo "<tr><td colspan='6'>No time slots found</td></tr>";
    }
    ?>
</tbody>

            </table>

        </div>
    </div>

</body>

</html>
