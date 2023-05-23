<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';

// Fetching data from the database
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM semesters WHERE id ='$id'";
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
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $semester_id = mysqli_real_escape_string($conn, $_POST['semester_id']);
    $semester_name = mysqli_real_escape_string($conn, $_POST['semester_name']);
    $start_year = mysqli_real_escape_string($conn, $_POST['start_year']);
    $end_year = mysqli_real_escape_string($conn, $_POST['end_year']);

    // Then, check if the semester name, start date and end date already exists in the database
    $sql = "SELECT * FROM semesters WHERE semester_id='$semester_id'  AND semester_name='$semester_name' AND start_year='$start_year' AND end_year='$end_year' AND id!='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the semester with the same name, start date and end date already exists, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("Semester with the same name, start date and end date already exists!")';
        echo '</script>';
    } else {
        // If the semester with the same name, start date and end date does not exist, update the data in the database
        $sql = "UPDATE semesters SET semester_id='$semester_id', semester_name='$semester_name', start_year ='$start_year', end_year='$end_year' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display an alert message and redirect to semester_list.php
            echo '<script type="text/javascript">';
            echo ' alert("Record updated successfully!");';
            echo ' window.location.href = "semester_list.php";';
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
        integrity="sha384-8t+gWy0JhGjbOxbtu2QzKACoVrAJRz/iBRymx1Ht/W1hXxrFL05t8PChqoo3sLsP"
        crossorigin="anonymous"></script>

</head>

<body>
    <div class="container mt-3">

        <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)"
            class="fw-bolder text-center text-warning mt-3 text-outline">UPDATE SEMESTER DETAILS</H1>



        <!-- Display the data of the selected semester in the form fields -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="semester_id" class="form-label">Semester ID</label>
                <input type="text" class="form-control" id="semester_id" name="semester_id"
                    value="<?php echo $row['semester_id']; ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="semester_name" class="form-label">Semester Name</label>
                <select class="form-select" id="semester_name" name="semester_name">
                    <?php
                    // Define the allowed semester names
                    $allowed_semester_names = array('1st Sem', '2nd Sem', 'Midyear');

                    // Loop through each allowed semester name and create an option in the dropdown menu
                    foreach ($allowed_semester_names as $semester_name) {
                        $selected = ($semester_name == $row['semester_name']) ? 'selected' : '';
                        echo "<option value='$semester_name' $selected>$semester_name</option>";
                    }
                    ?>
                </select>

            </div>
            <div class="mb-3">
                <label for="start_year" class="form-label">Start Year</label>
                <input type="number" class="form-control" id="start_year" name="start_year"
                    value="<?php echo $row['start_year']; ?>" min="2022" max="2099" required>
            </div>
            <div class="mb-3">
                <label for="end_year" class="form-label">End Year</label>
                <input type="number" class="form-control" id="end_year" name="end_year"
                    value="<?php echo $row['end_year']; ?>" min="2022" max="2099" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="semester_list.php" class="btn btn-danger">Back</a>
        </form>

    </div>

    <!-- CDN Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-X9rjbZitmdP6ROkU6KFpP0o+IKwOmR1SHz0UUN/u0W8+k2l2QKLmYJlL3aWpKR8y"
        crossorigin="anonymous"></script>
</body>

</html>