<?php
include 'database_connection.php';
include 'index.php';

// Delete section if delete_id is set in the URL parameters
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM faculty_loadings WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Subject deleted successfully');</script>";
        echo "<script>window.location.href = 'faculty_loading_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Update section if update_id is set in the URL parameters
if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];
    $query = "SELECT * FROM faculty_loadings WHERE id='$id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

// Execute search query if search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $query = "SELECT * FROM faculty_loadings WHERE teacher_name LIKE '%$search_term%' OR section_name LIKE '%$search_term%' OR course_name LIKE '%$search_term%' OR subject_description LIKE '%$search_term%'";
} else {
    $query = "SELECT * FROM faculty_loadings";
    $result = $conn->query($query);
}

// Update record if update form is submitted
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $teacher_name = $_POST['teacher_name'];
    $subject_description = $_POST['subject_description'];
    $subject_units = $_POST['subject_units'];
    $course_name = $_POST['course_name'];
    $section_name = $_POST['section_name'];
    $year = $_POST['year'];

    $sql = "UPDATE faculty_loadings SET teacher_name='$teacher_name', subject_description='$subject_description', subject_units='$subject_units', course_name='$course_name', section_name='$section_name', year='$year' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location.href = 'faculty_loading_list.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
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
    <link rel="stylesheet" href="css/faculty_loadings.css">
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


        <h2>Faculty Loading List</h2>

        <form method="POST">
            <div class="input-group mb-3">

                <input type="text" class="form-control rounded" placeholder="Search by Teacher ID/Name" name="search">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>


        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Teacher Name</th>
                    <th>Subject Description</th>
                    <th>Units</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Year</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                <?php
                // Execute search query if search form is submitted
                if (isset($_POST['search'])) {
                    $search_term = $_POST['search'];
                    $query = "SELECT * FROM faculty_loadings WHERE teacher_name LIKE '%$search_term%' OR section_name LIKE '%$search_term%' OR course_name LIKE '%$search_term%'";
                    $result = $conn->query($query);
                    if (!$result) {
                        die("Error executing search query: " . $conn->error);
                    }
                } else {
                    $query = "SELECT * FROM faculty_loadings";
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
                        echo "<td>" . $row["teacher"] . "</td>";
                        echo "<td>" . $row["subject_description"] . "</td>";
                        echo "<td>" . $row["subject_units"] . "</td>";
                        echo "<td>" . $row["course_name"] . "</td>";
                        echo "<td>" . $row["section_name"] . "</td>";
                        echo "<td>" . $row["section_year"] . "</td>";
                        echo "<td>";
                        echo "<a href='faculty_loading_update.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Update<i class='fas fa-edit'></i></a>&nbsp";
                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?delete_id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this subject?')\">Delete<i class='fas fa-trash'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No faculty_loadings found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="faculty_loading.php" class="btn btn-success"><i class='fas fa-user-plus'></i>Assign subject</a>

    </div>


</body>

</html>