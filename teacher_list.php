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
    <title>Index Page</title>

</head>

<body>


    <div class="container">
        <div class="container">
            <h2>Teacher List</h2>

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
               
               $query = "SELECT * FROM teachers";
               $result = $conn->query($query);
           

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["teacher_id"] . "</td>";
                        echo "<td>" . $row["firstname"] . "</td>";
                        echo "<td>" . $row["lastname"] . "</td>";
                        echo "<td>
                        <a href='teacher_update.php?id=".$row["id"]."' class='btn btn-primary btn-sm'>Update<i class='fas fa-edit'></i></a>
                        <a href='".$_SERVER['PHP_SELF']."?delete_id=".$row["id"]."' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this teacher?')\">Delete<i class='fas fa-trash'></i></a>
                        </td>"; // Add this Delete button
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>0 results</td></tr>";
                }

           
                ?>

                </tbody>
            </table>
            <a href='teacher_create.php' class='btn-success btn-lg'>Add new teacher</a>

        </div>

</body>

</html>