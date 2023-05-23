<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';

// Fetching data from the database
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM rooms WHERE id ='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // If there was an error in the query, display an error message and exit
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit();
    }
}

// Updating data in the database
if (isset($_POST['update'])) {
    // First, retrieve the data from the form and sanitize it
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $room_capacity = mysqli_real_escape_string($conn, $_POST['room_capacity']);


    // Then, check if the Room code and name already exists in the database
    $sql = "SELECT * FROM rooms WHERE room_id = '$room_id' AND room_name= '$room_name' AND id!='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the room with the same room id and name already exists, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("Room with the same room id and name already exists!")';
        echo '</script>';
    } else {
        // If the room with the same room id and name does not exist, update the data in the database
        $sql = "UPDATE rooms SET room_id='$room_id', room_name='$room_name', room_type='$room_type', room_capacity='$room_capacity' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display an alert message and redirect to room_list.php
            echo '<script type="text/javascript">';
            echo ' alert("Record updated successfully!");';
            echo ' window.location.href = "room_list.php";';
            echo '</script>';
            exit; // Make sure to exit after the redirect
        } else {
            echo "Error updating record: " . mysqli_error($conn);
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
    <div class="container mt-3">

    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">UPDATE ROOM DETAILS</H1>



        <!-- Display the data of the selected Room in the form fields -->
        <form method="POST">
        
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="mb-3">

                <label for="room_id" class="form-label">Room ID</label>
                <input type="text" class="form-control" id="room_id" name="room_id"
                    value="<?php echo $row['room_id']; ?>">
            </div>

            <div class="mb-3">

                <label for="room_name" class="form-label">Room Name</label>
                <input type="text" class="form-control" id="room_name" name="room_name"
                    value="<?php echo $row['room_name']; ?>">
            </div>

            <div class="mb-3">

                <label for="room_type" class="form-label">Room Type</label>
                <select class="form-select" id="room_type" name="room_type">
                    <?php
                    // Define the allowed Room type
                    $allowed_room_types = array('Lab', 'Lec');

                    // Loop through each allowed subjcet type and create an option in the dropdown menu
                    foreach ($allowed_room_types as $room_type) {
                        $selected = ($allowed_room_types == $row['room_type']) ? 'selected' : '';
                        echo "<option value='$room_type' $selected>$room_type</option>";
                    }
                    ?>
                </select>

            </div>

            <div class="mb-3">

                <label for="room_capacity" class="form-label">room_capacity</label>
                <input type="text" class="form-control" id="room_capacity" name="room_capacity"
                    value="<?php echo $row['room_capacity']; ?>">

            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="room_list.php" class="btn btn-danger">Back</a>

        </form>

    </div>

    <!-- CDN Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-X9rjbZitmdP6ROkU6KFpP0o+IKwOmR1SHz0UUN/u0W8+k2l2QKLmYJlL3aWpKR8y" crossorigin="anonymous">
    </script>
</body>

</html>