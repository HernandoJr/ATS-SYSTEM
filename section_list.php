<?php
include 'database_connection.php';
include 'index.php';


// Delete section if delete_id is set in the URL parameters
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM sections WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('section deleted successfully');</script>";
        echo "<script>window.location.href = 'section_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Execute search query if search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $query = "SELECT * FROM sections WHERE section_name LIKE '%$search_term%' OR section_id LIKE '%$search_term%'";
    $result = $conn->query($query);
} else {
    $query = "SELECT * FROM sections";
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
    <link rel="stylesheet" href="css/sections.css">
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
        <div class="container">


        <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">SECTION LIST</H1>

            <form method="POST">
                <div class="input-group mb-3">

                    <input type="text" class="form-control rounded" placeholder="Search by section_name or section_id"
                        name="search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <a href="section_create.php" class="btn btn-success mb-3"><i class='fas fa-user-plus'></i> Add section</a>

            <table class="table table-bordered table-hover text-center" style="border:1px solid black">
                <thead class="bg-warning">
                    <tr>
                        <th>No.</th>
                        <th>Section ID</th>
                        <th>Section Name</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody style="font-size:1.2rem;font-family:monospace">

                    <?php
                    // Execute search query if search form is submitted
                    if (isset($_POST['search'])) {
                        $search_term = $_POST['search'];
                        $query = "SELECT * FROM sections WHERE section_name LIKE '%$search_term%' OR section_id LIKE '%$search_term%'";
                        $result = $conn->query($query);
                        if (!$result) {
                            die("Error executing search query: " . $conn->error);
                        }
                    } else {
                        $query = "SELECT * FROM sections";
                        $result = $conn->query($query);
                        if (!$result) {
                            die("Error executing query: " . $conn->error);
                        }
                    }
                    ?>

                    <?php
                    if ($result->num_rows > 0) {
                        // output data of each row
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row["section_id"] . "</td>";
                            echo "<td>" . $row["section_name"] . "</td>";
                            echo "<td>";
                            echo "<a href='section_update.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Update<i class='fas fa-edit'></i></a>&nbsp";
                            echo "<a href='" . $_SERVER['PHP_SELF'] . "?delete_id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this section?')\">Delete<i class='fas fa-trash'></i></a>";
                            echo "</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No sections found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>


        </div>
    </div>

</body>

</html>