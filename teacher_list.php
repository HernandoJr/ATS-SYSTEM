<?php 
include 'database_connection.php';
include 'index.php';

// Delete teacher if delete_id is set in the URL parameters
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM teachers WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher deleted successfully');</script>";
        echo "<script>window.location.href = 'teacher_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Execute search query if search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $query = "SELECT * FROM teachers WHERE firstname LIKE '%$search_term%' OR lastname LIKE '%$search_term%'";
    $result = $conn->query($query);
} else {
    $query = "SELECT * FROM teachers";
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
    <link rel="stylesheet" href="css/teacher_form.css">
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qI5N5m1n5QlSvZPmRlMlrLHhYiGXy3bqxCX4mtE5ZRtgr5Q5Z5S0C5fRi+KLkDlO" crossorigin="anonymous"></script>

    <title>Index Page</title>

</head>

<body>



    <div class="container">
        <div class="container">


            <h2>Teacher List</h2>   

            <form method="POST">
                <div class="input-group mb-3">
      
                    <input type="text" class="form-control rounded"  placeholder="Search by firstname or lastname" name="search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            

            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Teacher ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // output data of each row
                        $i = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row["teacher_id"] . "</td>";
                            echo "<td>" . $row["firstname"] . "</td>";
                            echo "<td>" . $row["lastname"] . "</td>";
                        echo "<td>";
                            echo "<a href='teacher_update.php?id=".$row["id"]."' class='btn btn-primary btn-sm'>Update<i class='fas fa-edit'></i></a>&nbsp";
                            echo "<a href='".$_SERVER['PHP_SELF']."?delete_id=".$row["id"]."' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this teacher?')\">Delete<i class='fas fa-trash'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No teachers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="teacher_create.php" class="btn btn-success"><i class='fas fa-user-plus'></i> Add Teacher</a>

    </div>
</div>

</body>
</html>