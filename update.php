<?php
// Start the session at the beginning of the file
include 'index.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Include the database connection file
include 'database_connection.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the form data
    if (empty($name) || empty($email)) {
        $error_message = 'Please fill in all the fields';
    } else {
        // Check if the email is already in use
        $user_id = $_SESSION['user_id'];
        $sql_check_email = "SELECT * FROM users WHERE email='$email' AND id!='$user_id'";
        $result_check_email = mysqli_query($conn, $sql_check_email);

        if (mysqli_num_rows($result_check_email) > 0) {
            $error_message = 'Email address is already in use by another user';
        } else {
            // Update the user data in the database
            $user_id = $_SESSION['user_id'];
            $sql = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$user_id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $success_message = 'User data updated successfully';
            } else {
                $error_message = 'Error updating user data: ' . mysqli_error($conn);
            }
        }
    }
    if (isset($success_message)) {
        // Redirect to the dashboard page after showing the alert box
        echo "<script>alert('$success_message'); window.location.href='dashboard.php';</script>";
        exit();
    }
}

// Fetch the user data from the database
$user_id = $_SESSION['user_id'];
$sql_fetch_user_data = "SELECT * FROM users WHERE id='$user_id'";
$result_fetch_user_data = mysqli_query($conn, $sql_fetch_user_data);
$row_fetch_user_data = mysqli_fetch_assoc($result_fetch_user_data);

// Assign the user data to variables for displaying in the form
$name = $row_fetch_user_data['name'];
$email = $row_fetch_user_data['email'];
$password = $row_fetch_user_data['password'];
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
    <link rel="stylesheet" href="css/index.css">
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
    </script>
    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
    <title>ATS-SYSTEM</title>


</head>


<body>


    <div class="container">

        <h1>Update User Account</h1>

        <?php if (isset($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="post">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data['name']; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo $user_data['email']; ?>">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password"
                    value="<?php echo $user_data['password']; ?>">
            </div>
            <!-- Form inputs go here -->
            <div class="form-group mt-3">
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-danger" onclick="window.history.back()">Back</button>
            </div>
        </form>


    </div>
</body>

</html>
<?php
// Close the database connection
mysqli_close($conn);
?>
<!-- End of code -->