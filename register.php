<?php

include 'database_connection.php';

$message = '';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $message = "This email is already in use.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "User created successfully!";
            header("location: login.php");
        } else {
            $message = "Error: " . mysqli_error($conn);
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark size text-center">
                        <h1 style="color:gold;font-family:tahoma;font-weight:bold" ;>REGISTER</h1>
                    </div>
                    <div class="card-body shadow-lg p-5 mb-2 bg-white">
                        <?php if ($message != ''): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $message ?>
                            </div>
                        <?php endif; ?>
                        <form style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" ;
                            method="POST">
                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-success" name="register">Register</button>
                            <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>

                        </form>

</body>

</html>