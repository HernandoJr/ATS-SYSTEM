<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';

// Fetching data from the database
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM sections WHERE id ='$id'";
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

    $section_id = mysqli_real_escape_string($conn, $_POST['section_id']);
    $section_name = mysqli_real_escape_string($conn, $_POST['section_name']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $section_year = mysqli_real_escape_string($conn, $_POST['section_year']);


    // Then, check if the section name, course and year already exists in the database
    $sql = "SELECT * FROM sections WHERE  section_name='$section_name' AND course_name='$course_name'AND section_year='$section_year' AND id!='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the section with the same name, course and year already exists, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("section with the same name, course and year already exists!")';
        echo '</script>';
    } else {
        // If the section with the same name, course and year does not exist, update the data in the database
        $sql = "UPDATE sections SET section_id='$section_id', section_name='$section_name', course_name='$course_name', section_year='$section_year' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display an alert message and redirect to section_list.php
            echo '<script type="text/javascript">';
            echo ' alert("Record updated successfully!");';
            echo ' window.location.href = "section_list.php";';
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

        <h3>Update Section</h3>



        <!-- Display the data of the selected section in the form fields -->
        <form method="POST">

            <div class="mb-3">

                <label for="section_id" class="form-label">section ID</label>
                <input type="text" class="form-control" id="section_id" name="section_id"
                    value="<?php echo $row['section_id']; ?>">
            </div>

            <div class="mb-3">

                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <div class="mb-3">

                    <label for="section_name" class="form-label">Section Name</label>
                    <select class="form-select" id="section_name" name="section_name">
                        <?php
                        // Define the allowed section names
                        $allowed_section_names = array('A', 'B', 'C', 'D', 'E', 'F');

                        // Loop through each allowed section name and create an option in the dropdown menu
                        foreach ($allowed_section_names as $section_name) {
                            $selected = ($section_name == $row['section_name']) ? 'selected' : '';
                            echo "<option value='$section_name' $selected>$section_name</option>";
                        }
                        ?>
                    </select>

                </div>

                <?php
                // Fetching data from the database to display the selected course_name
                if (isset($_GET['id'])) {

                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                    $sql = "SELECT * FROM sections WHERE id ='$id'";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $selected_course_name = $row['course_name']; // Retrieve the selected course_name from the database
                    } else {
                        // If there was an error in the query, display an error message and exit
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        exit();
                    }
                }

                ?>
                <!-- Display the data of the selected section in the form fields -->


                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <select class="form-control" id="course_name" name="course_name">
                        <?php
                        // Retrieve the list of courses from the database
                        $sql = "SELECT * FROM courses ORDER BY course_name ASC";
                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($course_row = mysqli_fetch_assoc($result)) {
                                $selected = ($course_row['course_name'] == $selected_course_name) ? "selected" : "";
                                echo "<option value=\"{$course_row['course_name']}\" $selected>{$course_row['course_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>






                <div class="mb-3">

                    <label for="section_year" class="form-label">Year</label>
                    <select class="form-select" id="section_year" name="section_year">
                        <?php
                        // Define the allowed section names
                        $allowed_section_year = array('1st', '2nd', '3rd', '4th');

                        // Loop through each allowed section name and create an option in the dropdown menu
                        foreach ($allowed_section_year as $section_year) {
                            $selected = ($section_year == $row['section_year']) ? 'selected' : '';
                            echo "<option value='$section_year' $selected>$section_year</option>";
                        }
                        ?>
                    </select>
                </div>


            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="section_list.php" class="btn btn-danger">Back</a>

        </form>

    </div>

    <!-- CDN Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-X9rjbZitmdP6ROkU6KFpP0o+IKwOmR1SHz0UUN/u0W8+k2l2QKLmYJlL3aWpKR8y" crossorigin="anonymous">
        </script>
</body>

</html>