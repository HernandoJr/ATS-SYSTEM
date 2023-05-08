<?php

include 'database_connection.php';
include 'index.php';

// Define the available time range for the course schedule
$start_time = strtotime("7:00am");
$end_time = strtotime("7:00pm");   
$timeslot_duration = 60 * 60; // 1 hour in seconds

// Check if the faculty_loading table is empty
$sql = "SELECT COUNT(*) AS count FROM faculty_loadings";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];

// Set the button state based on whether the faculty_loading table is empty or not
$button_disabled = "";
$button_text = "Assign Timeslots";
if ($count == 0) {
    $button_disabled = "disabled";
    $button_text = "No Data";
}

// Check if the button was clicked
if (isset($_POST['assign_timeslots'])) {
    // Retrieve the data from the faculty_loading table
    $sql = "SELECT * FROM faculty_loadings";
    $result = mysqli_query($conn, $sql);

  // Loop through each row in the result set
while ($row = mysqli_fetch_assoc($result)) {
  // Calculate the number of timeslots needed for the subject
  $subject_hours = $row['subject_hours'];
  $timeslots_needed = 0;
  if ($subject_hours == 1) {
      $timeslots_needed = 1;
  } else if ($subject_hours == 1.5) {
      $timeslots_needed = 2;
  } else if ($subject_hours == 3) {
      $timeslots_needed = 3;
  }
  // Generate a random timeslot within the available time rangea
  $available_timeslots = array();
  $current_time = $start_time;
  while ($current_time < $end_time) {
      $timeslot_start = date("g:i A", $current_time);
      $timeslot_end = date("g:i A", $current_time + $timeslot_duration);
      $available_timeslots[] = "$timeslot_start - $timeslot_end";
      $current_time += $timeslot_duration;
  }
  // Shuffle the array of available timeslots to randomize the selection
  shuffle($available_timeslots);
 // Get the first and last timeslots from the selected timeslots
$first_timeslot = explode(" - ", $selected_timeslots[0]);
$last_timeslot = explode(" - ", $selected_timeslots[$timeslots_needed - 1]);

// Extract the start and end times from the first and last timeslots
$start = date("H:i:s", strtotime($first_timeslot[0]));
$end = date("H:i:s", strtotime($last_timeslot[1]));

  // Get the faculty name, subject name, and section from the row
  $teacher = $row['teacher'];
  $subject_description = $row['subject_description'];
  $section_name = $row['section_name'];
  $day = $row['day'];
  $start = $row['start_time'];
  $end = $row['end_time'];

  // Insert the data into the faculty_loadings table
  $sql = "INSERT INTO faculty_loadings (teacher, subject_description, section_name, day, start_time, end_time) VALUES ('$teacher', '$subject_description', '$section_name', '$day', '$start', '$end')";
  mysqli_query($conn, $sql);

  // Update the faculty_loading table to indicate that the timeslots have been assigned
  $sql = "UPDATE faculty_loadings SET timeslots_assigned = 1 WHERE schedcode = '{$row['schedcode']}'";
  mysqli_query($conn, $sql);
}

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

     
  <div class="container">
  <h1>AUTOMATE ASSIGNING OF TIMESLOTS</h1>
	<form method="POST">
		<button class="btn btn-success" type="submit" name="assign_timeslots" <?php echo $button_disabled; ?>><?php echo $button_text; ?></button>
	</form>
  </div>

</body>
</html>



