<?php
// include the database connection file
include 'database_connection.php';
include 'index.php';

// Fetching data from the database
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM subjects WHERE id ='$id'";
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
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $subject_description = mysqli_real_escape_string($conn, $_POST['subject_description']);
    $subject_type = mysqli_real_escape_string($conn, $_POST['subject_type']);
    $subject_units = mysqli_real_escape_string($conn, $_POST['subject_units']);


    // Then, check if the subject code, description and type already exists in the database
    $sql = "SELECT * FROM subjects WHERE subject_code = '$subject_code' AND subject_description= '$subject_description' AND subject_type= '$subject_type'  AND id!='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the section with the same subject code, description and type already exists, display an error message
        echo '<script type="text/javascript">';
        echo ' alert("subject with the same subject code, description and type already exists!")';
        echo '</script>';
    } else {
        // If the section with the same subject code, description and type does not exist, update the data in the database
        $sql = "UPDATE subjects SET subject_code='$subject_code', subject_description='$subject_description', subject_type='$subject_type', subject_units='$subject_units' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display an alert message and redirect to subject_list.php
            echo '<script type="text/javascript">';
            echo ' alert("Record updated successfully!");';
            echo ' window.location.href = "subject_list.php";';
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

        <h3>Update Subject</h3>



        <!-- Display the data of the selected subject in the form fields -->
        <form method="POST">
        
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="mb-3">

                <label for="subject_code" class="form-label">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code"
                    value="<?php echo $row['subject_code']; ?>">
            </div>

            <div class="mb-3">

                <label for="subject_description" class="form-label">Subject Description</label>
                <input type="text" class="form-control" id="subject_description" name="subject_description"
                    value="<?php echo $row['subject_description']; ?>">
            </div>

            <div class="mb-3">

                <label for="subject_type" class="form-label">Subject Type</label>
                <select class="form-select" id="subject_type" name="subject_type">
                    <?php
                    // Define the allowed subject type
                    $allowed_subject_types = array('Lab', 'Lec');

                    // Loop through each allowed subjcet type and create an option in the dropdown menu
                    foreach ($allowed_subject_types as $subject_type) {
                        $selected = ($allowed_subject_types == $row['subject_type']) ? 'selected' : '';
                        echo "<option value='$subject_type' $selected>$subject_type</option>";
                    }
                    ?>
                </select>

            </div>

            <div class="mb-3">

                <label for="subject_units" class="form-label">Units</label>
                <input type="text" class="form-control" id="subject_units" name="subject_units"
                    value="<?php echo $row['subject_units']; ?>">

            </div>



            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="subject_list.php" class="btn btn-danger">Back</a>

        </form>

    </div>

    <!-- CDN Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-X9rjbZitmdP6ROkU6KFpP0o+IKwOmR1SHz0UUN/u0W8+k2l2QKLmYJlL3aWpKR8y" crossorigin="anonymous">
    </script>
</body>

</html>