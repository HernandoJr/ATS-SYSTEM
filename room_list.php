<?php
include 'database_connection.php';
include 'index.php';

// Delete section if delete_id is set in the URL parameters
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM rooms WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Rooms deleted successfully');</script>";
        echo "<script>window.location.href = 'room_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Execute search query if search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $query = "SELECT * FROM rooms WHERE room_id LIKE '%$search_term%' OR room_name LIKE '%$search_term%' OR room_type LIKE '%$search_term%'";
} else {
    $query = "SELECT * FROM rooms";
    $result = $conn->query($query);
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
    <link rel="stylesheet" href="css/rooms.css">

    <title>Room List</title>
</head>

<body>

    <div class="container">
        <h2>Room List</h2>

        <form method="POST">
            <div class="input-group mb-3">
                <input type="text" class="form-control rounded" placeholder="Search by Rooms ID/Name/Type"
                    name="search">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <table class="table table-bordered table table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Room Name</th>
                    <th>Room Type</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Execute search query if search form is submitted
                if (isset($_POST['search'])) {
                    $search_term = $_POST['search'];
                    $query = "SELECT * FROM rooms WHERE room_id LIKE '%$search_term%' OR room_name LIKE '%$search_term%' OR room_type LIKE '%$search_term%'";
                    $result = $conn->query($query);
                    if (!$result) {
                        die("Error executing search query: " . $conn->error);
                    }
                } else {
                    $query = "SELECT * FROM rooms";
                    $result = $conn->query($query);
                    if (!$result) {
                        die("Error executing query: " . $conn->error);
                    }
                }

                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row["room_name"] . "</td>";
                        echo "<td>" . $row["room_type"] . "</td>";
                        echo "<td>" . $row["room_capacity"] . "</td>";
                        echo "<td>";
                        echo "<a href='room_update.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Update<i class='fas fa-edit'></i></a>&nbsp";
                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?delete_id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this Room?')\">Delete<i class='fas fa-trash'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No rooms found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="room_create.php" class="btn btn-success"><i class='fas fa-user-plus'></i> Add Rooms</a>

    </div>

    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous"></script>
    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>

</body>

</html>
