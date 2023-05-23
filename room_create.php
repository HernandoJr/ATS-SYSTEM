<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';

// check if the form is submitted
if (isset($_POST['submit'])) {

    // sanitize and get the form data
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $room_capacity = mysqli_real_escape_string($conn, $_POST['room_capacity']);

    // check if a record with the same room_id or room_name already exists
    $sql = "SELECT * FROM rooms WHERE room_id = '$room_id' OR room_name = '$room_name'";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("A room with the same room code and type already exists!");';
        echo ' window.location.href = "room_create.php";';
        echo '</script>';
        exit;
    } else {
        // insert the data into the table
        $sql= "INSERT INTO rooms (room_id, room_name, room_type, room_capacity) VALUES ('$room_id', '$room_name', '$room_type', '$room_capacity')";

        if (mysqli_query($conn, $sql)) {
            echo '<script type="text/javascript">';
            echo ' alert("New record added successfully!");';
            echo ' window.location.href = "room_list.php";';
            echo '</script>';
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
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
    <title>Add room </title>
</head>

<body>
    <div class="container mt-3">
    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">ADD ROOM</H1>

        <form method="post">

            <div class="mb-3">
                <label for="room_id">Room ID</label>
                <input type="text" class="form-control" id="room_id" name="room_id" placeholder="Enter Room ID">
            </div>

            <div class="mb-3">
                <label for="room_name">Room Name</label>
                <input type="text" class="form-control" id="room_name" name="room_name" placeholder="Enter Room Name">
            </div>

            <div class="mb-3 mt-3">
                <label for="room_type" class="form-label">Room Type</label>
                <select class="form-select" id="room_type" name="room_type" required>
                    <option value="">Select </option>
                    <option value="Lab">Lab</option>
                    <option value="Lec">Lec</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="room_capacity">Capacity</label>
                <input type="number" class="form-control" id="room_capacity" name="room_capacity"
                    placeholder="Enter Room Capacity">
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="room_list.php" class="btn btn-danger" name="back">Back</a>
        </form>
    </div>
</body>

</html>