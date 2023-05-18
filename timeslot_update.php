<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';

// check if the form is submitted
if (isset($_POST['submit'])) {

    // get the form data
    $start_time = date('h:i A', strtotime($_POST['start_time']));
    $end_time = date('h:i A', strtotime($_POST['end_time']));
    $day = $_POST['day'];

    // check if any of the fields are empty
    if (empty($start_time) || empty($end_time) || empty($day)) {
        echo '<script type="text/javascript">';
        echo ' alert("Please fill in all the fields!");';
        echo ' window.location.href = "timeslot_create.php";';
        echo '</script>';
        exit;
    }

    // check if a timeslot with the same day and overlapping time duration already exists
    $sql = "SELECT * FROM timeslots WHERE day='$day' AND (start_time <= '$end_time' AND end_time >= '$start_time')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("A timeslot with the same day and overlapping time duration already exists!");';
        echo ' window.location.href = "timeslot_create.php";';
        echo '</script>';
        exit;
    }

    // insert the data into the database
    $sql = "INSERT INTO timeslots (start_time, end_time, day) VALUES ('$start_time', '$end_time', '$day')";

    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">';
        echo ' alert("New timeslot added successfully!");';
        echo ' window.location.href = "timeslot_list.php";';
        echo '</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Function to update a timeslot
function updateTimeslot($timeslot_id, $start_time, $end_time, $day)
{
    // check if any of the fields are empty
    if (empty($start_time) || empty($end_time) || empty($day)) {
        echo '<script type="text/javascript">';
        echo ' alert("Please fill in all the fields!");';
        echo ' window.location.href = "timeslot_edit.php?id=' . $timeslot_id . '";';
        echo '</script>';
        exit;
    }

    // check if a timeslot with the same day and overlapping time duration already exists
    $sql = "SELECT * FROM timeslots WHERE day='$day' AND (start_time <= '$end_time' AND end_time >= '$start_time') AND id <> $timeslot_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("A timeslot with the same day and overlapping time duration already exists!");';
        echo ' window.location.href = "timeslot_edit.php?id=' . $timeslot_id . '";';
        echo '</script>';
        exit;
    }

    // update the timeslot in the database
    $sql = "UPDATE timeslots SET start_time='$start_time', end_time='$end_time', day='$day' WHERE id=$timeslot_id";

    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">';
        echo ' alert("Timeslot updated successfully!");';
        echo ' window.location.href = "timeslot_list.php";';
        echo '</script>';
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href="css/_form.css">
    <title>Add Timeslot</title>
</head>

<body>
    <div class="container mt-3">
        <h3>Add Timeslot</h3>

        <form method="POST" onsubmit="return validateForm();">
            <div class="mb-3">
                <label for="start_time">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>

            <div class="mb-3">
                <label for="end_time">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>

            <div class="mb-3">
                <label for="day">Day</label>
                <select class="form-control" id="day" name="day" required>
                    <option value="">Select a day</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="timeslot_list.php" class="btn btn-danger" name="back">Back</a>
        </form>
    </div>
</body>

<script>
    function validateForm() {
        var startTime = document.getElementById("start_time").value;
        var endTime = document.getElementById("end_time").value;

        // Convert start time and end time to Date objects
        var startDate = new Date("2000-01-01 " + startTime);
        var endDate = new Date("2000-01-01 " + endTime);

        // Calculate the time difference in minutes
        var diffMinutes = (endDate - startDate) / 1000 / 60;

        // Check if the duration is valid (1 hour, 1 hour and 30 minutes, or 3 hours)
        if (diffMinutes !== 60 && diffMinutes !== 90 && diffMinutes !== 180) {
            alert("The duration must be 1 hour, 1 hour and 30 minutes, or 3 hours");
            return false;
        }

        // Check if the start time is before 7 AM or after 6 PM
        var startHour = startDate.getHours();
        if (startHour < 7 || startHour > 18) {
            alert("Start time must be between 7 AM and 6 PM");
            return false;
        }

        // Check if the end time is before 6 AM or after 7 PM
        var endHour = endDate.getHours();
        if (endHour < 6 || endHour > 19) {
            alert("End time must be between 6 AM and 7 PM");
            return false;
        }

        return true;
    }
</script>


</html>
