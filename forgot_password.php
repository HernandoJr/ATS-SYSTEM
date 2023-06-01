<?php
session_start();
include 'database_connection.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];

    // Generate a new password
    $newPassword = generateRandomPassword();

    // Update the password in the database
    $connection = mysqli_connect("localhost", "root", "", "ats_db");
    $query = "UPDATE users SET password='$newPassword' WHERE email='$email'";
    mysqli_query($connection, $query);

    // Show the new password to the user
    $_SESSION['success'] = "Your new password is: $newPassword";
    header("Location: login.php");
    exit;
}

// Function to generate a random password
function generateRandomPassword($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    $charactersLength = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }

    return $password;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
		
		.container {
			padding: 40px;
		}

		.card {
			background-color: #f0f0f0;
			border: none;
			border-radius: 10px;
			box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.2);
		}

		.card-header {
			background-color:black;
			border: none;
		}

		.card-body {
			background-color:floralwhite;
		}

		.form-control {
			background-color: #f0f0f0;
			border: none;
			border-radius: 10px;
			box-shadow: inset 3px 3px 7px rgba(0, 0, 0, 0.3), inset -3px -3px 7px rgba(255, 255, 255, 0.3);
			padding: 10px 15px;
		}

		.btn-success {
			background-color: #4bb543;
			border: none;
			border-radius: 10px;
			box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.1);
			padding: 10px 15px;
		}

		.btn-success:hover {
			background-color: #3e923f;
		}

		a {
			color: #4bb543;
		}
	</style>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 style="color:gold;font-family:tahoma;font-weight:bold">FORGOT PASSWORD</h1>
                    </div>
                    <div class="card-body shadow-lg p-5 mb-2 bg-gray">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }

                        if (isset($_SESSION['success'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" method="POST">
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="reset_password" class="btn btn-success">Reset Password</button>
                                <p class="text-center"><a href="login.php">Back to Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>