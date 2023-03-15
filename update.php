<?php 

//include the db connection php file.
include 'database_connection.php';
include 'index.php';


// Fetching data from the database
if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM users WHERE id ='$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // If there was an error in the query, display an error message and exit
        echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . mysqli_error($conn) . '</div>';
        exit();
    }
}

// Updating data in the database
if (isset($_POST['update'])) {
    // First, retrieve the data from the form and sanitize it
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Then, check if the email already exists in the database
    $sql = "SELECT * FROM users WHERE email='$email' AND id!='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the email already exists, display an error message
        echo '<div class="alert alert-danger" role="alert">Email already exists!</div>';
    } else {
        // If the email does not exist, update the data in the database
        $sql = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Data updated successfully, display a success message
            echo '<div class="alert alert-success" role="alert">Record updated successfully!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating record: ' . mysqli_error($conn) . '</div>';
        }
    }

    // Fetch the updated data from the database and update the $row variable
    $sql = "SELECT * FROM users WHERE id ='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // If there was an error in the query, display an error message and exit
        echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . mysqli_error($conn) . '</div>';
        exit();
    }
}
?>

<div class="container my-5">
    <h1>Update User</h1>

    <!-- Display the form for updating user data -->
    <form method="post">
    <div class="form-group">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    </div>
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
    </div>
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>">
    </div>
    <button type="submit" class="btn btn-primary" name="update">Update</button>
</form>
</div>
<?php
// Close the database connection
mysqli_close($conn);
?>