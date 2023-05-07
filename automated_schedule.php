<?php

include 'database_connection.php';


// Function to assign random timeslot based on subject hours
function assignTimeslot($subject_hours) {
    $timeslots = array("MWF 7:00-7:30 AM", "MWF 7:30-8:00 AM", "MWF 8:00-8:30 AM", "MWF 8:30-9:00 AM", "MWF 9:00-9:30 AM", "MWF 9:30-10:00 AM", "MWF 10:00-10:30 AM", "MWF 10:30-11:00 AM", "MWF 11:00-11:30 AM", "MWF 11:30-12:00 PM", "MWF 12:00-12:30 PM", "MWF 12:30-1:00 PM", "MWF 1:00-1:30 PM", "MWF 1:30-2:00 PM", "MWF 2:00-2:30 PM", "MWF 2:30-3:00 PM", "MWF 3:00-3:30 PM", "MWF 3:30-4:00 PM", "MWF 4:00-4:30 PM", "MWF 4:30-5:00 PM", "TTH 7:00-7:30 AM", "TTH 7:30-8:00 AM", "TTH 8:00-8:30 AM", "TTH 8:30-9:00 AM", "TTH 9:00-9:30 AM", "TTH 9:30-10:00 AM", "TTH 10:00-10:30 AM", "TTH 10:30-11:00 AM", "TTH 11:00-11:30 AM", "TTH 11:30-12:00 PM", "TTH 12:00-12:30 PM", "TTH 12:30-1:00 PM", "TTH 1:00-1:30 PM", "TTH 1:30-2:00 PM", "TTH 2:00-2:30 PM", "TTH 2:30-3:00 PM", "TTH 3:00-3:30 PM", "TTH 3:30-4:00 PM", "TTH 4:00-4:30 PM", "TTH 4:30-5:00 PM");
    $timeslot_count = count($timeslots);
    
    // Determine the number of timeslots needed based on subject hours
    if ($subject_hours == 1) {
        $num_timeslots = 2;
    } elseif ($subject_hours == 1.5) {
        $num_timeslots = 3;
    } elseif ($subject_hours == 3) {
        $num_timeslots = 6;
    }
    
    // Choose a random starting timeslot
    $start_index = array_rand($timeslots, 1);
    $end_index = $start_index + $num_timeslots - 1;
    
    // Check if chosen timeslot is within available time range
$start_time = substr($timeslots[$start_index], -11, 5);
$end_time = substr($timeslots[$end_index], -5);
if ($start_time < '07:00' || $end_time > '19:00') {
// Timeslot is outside available range, try again
assignTimeslot($subject_hours);
} else {
// Timeslot is valid, return the chosen timeslots
return array_slice($timeslots, $start_index, $num_timeslots);
}
}

// Function to save schedule to the appropriate table based on course and year
function saveSchedule($course, $year, $schedule) {
$table_name = $course . $year;
global $conn;
$sql = "INSERT INTO " . $table_name . " (schedule) VALUES ('" . $schedule . "')";
if (mysqli_query($conn, $sql)) {
echo "Schedule saved successfully!";
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

// Sample usage
$subject_hours = 3;
$timeslots = assignTimeslot($subject_hours);
$course = 'BSCS';
$year = '4th Year';
$schedule = implode(',', $timeslots);
saveSchedule($course, $year, $schedule);

mysqli_close($conn);

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
    <!--External CSS-->
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
    </script>
    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-8t+gWy0JhGjbOxbtu2QzKACoVrAJRz/iBRymx1Ht/W1hXxrFL05t8PChqoo3sLsP" crossorigin="anonymous">
    </script>
</head>

<body>

<table class="table table-bordered table-striped weight-20px">
  <thead>
    <tr>
      <th></th>
      <th>Monday</th>
      <th>Tuesday</th>
      <th>Wednesday</th>
      <th>Thursday</th>
      <th>Friday</th>
    </tr>
  </thead>
  <tbody>
    <?php
      // Generate rows for each 30-minute interval from 7:00am to 7:00pm
      $start_time = strtotime('7:00am');
      $end_time = strtotime('7:00pm');
      $current_time = $start_time;
      while ($current_time <= $end_time) {
        echo '<tr>';
        echo '<th>' . date('g:i A', $current_time) . '</th>';
        for ($i = 0; $i < 5; $i++) {
          echo '<td></td>';
        }
        echo '</tr>';
        $current_time = strtotime('+30 minutes', $current_time);
      }
    ?>
  </tbody>
</table>



</body>
</html>

