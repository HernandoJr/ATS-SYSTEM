<?php
include 'database_connection.php';
include 'index.php';

// Delete semester if delete_id is set in the URL parameters
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM semesters WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Semester deleted successfully');</script>";
        echo "<script>window.location.href = 'semester_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
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
        integrity="sha384-8t+gWy0JhGjbOxbtu2QzKACoVrAJRz/iBRymx1Ht/W1hXxrFL05t8PChqoo3sLsP"
        crossorigin="anonymous"></script>


    <title>Semester List</title>

</head>

<body>

    <div class="container">
        <div class="container">

            <h2>Semester List</h2>

            <form method="POST" action="semester_list.php">
                <div class="input-group mb-3">

                    <input type="text" class="form-control rounded" placeholder="Search by semester name or ID" name="search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <table class="table table-bordered table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Semester ID</th>
                        <th>Semester Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Execute search query if search form is submitted
                    if (isset($_POST['search'])) {
                        $search_term = $_POST['search'];
                        $query = "SELECT * FROM semesters WHERE semester_name LIKE '%$search_term%' OR semester_id LIKE '%$search_term%'";
                        $result = $conn->query($query);
                        if (!$result) {
                            die("Error executing search query: " . $conn->error);
                        }
                    } else {
                        $query = "SELECT * FROM semesters";
                        $result = $conn->query($query);
                        if (!$result) {
                            die("Error executing query: " . $conn->error);
                        }
                    }

                    // Check if any rows were returned
                    if ($result->num_rows > 0) {
                        // output data of each row
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row["semester_id"] . "</td>";
                            echo "<td>" . $row["semester_name"] . "</td>";
                            echo "<td>" . $row["start_date"] . "</td>";
                            echo "<td>" . $row["end_date"] . "</td>";
                            echo "<td><a href='semester_update.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm me-1'>Update</a>";
                            echo "<a href='semester_list.php?delete_id=" . $row["id"] . "' class='btn btn-danger btn-sm me-1'>Delete</a></td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "No results found";
                    }
                    ?>
                </tbody>
            </table>

            <a href="semester_create.php" class="btn btn-success">Add Semester</a>

        </div>
    </div>

</body>

</html>