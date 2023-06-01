<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- CDN Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- CDN Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous"></script>
	<!-- CDN jquery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
		integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
	<title>Login Page</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="css/login.css">

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
			box-shadow: inset 3px 3px 7px rgba(0, 0, 0, .2), inset -3px -3px 7px rgba(255, 255, 255, 0.3);
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

</head>

<body>

	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header text-center">
						<h1 style="color:gold;font-family:tahoma;font-weight:bold">LOGIN</h1>
					</div>
					<div class="card-body">

						<?php
						session_start();

						// Check if user is already logged in
						if (isset($_SESSION['user_id'])) {
							header("Location: dashboard.php");
							exit;
						}

						// Check if form is submitted
						if (isset($_POST['login'])) {

							// Get user credentials
							$email = $_POST['email'];
							$password = $_POST['password'];

							// Check user credentials in database
							$connection = mysqli_connect("localhost", "root", "", "ats_db");

							// Get the user's login_attempts and last_failed_login from the database
							$query = "SELECT * FROM users WHERE email='$email'";
							$result = mysqli_query($connection, $query);
							$user = mysqli_fetch_assoc($result);
							$loginAttempts = $user['login_attempts'];
							$lastFailedLogin = $user['last_failed_login'];

							// Check if the user is currently blocked
							if ($loginAttempts >= 3 && time() - strtotime($lastFailedLogin) < 150) {
								$secondsRemaining = 150 - (time() - strtotime($lastFailedLogin));
								$minutesRemaining = ceil($secondsRemaining / 60);

								// User is blocked, display error message with remaining time
								$_SESSION['error'] = "You have exceeded the maximum login attempts. Please try again after $minutesRemaining minutes.";
								header("Location: login.php");
								exit;
							}

							$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
							$result = mysqli_query($connection, $query);

							if (mysqli_num_rows($result) == 1) {
								// User is authenticated, reset login attempts and set session variables
								$query = "UPDATE users SET login_attempts = 0, last_failed_login = NULL WHERE email='$email'";
								mysqli_query($connection, $query);

								$user = mysqli_fetch_assoc($result);
								$_SESSION['user_id'] = $user['id'];
								$_SESSION['username'] = $user['username'];
								header("Location: dashboard.php");
								exit;
							} else {
								// User is not authenticated, increment login attempts and update last failed login timestamp
								$loginAttempts++;
								$lastFailedLogin = date("Y-m-d H:i:s");
								$query = "UPDATE users SET login_attempts = $loginAttempts, last_failed_login = '$lastFailedLogin' WHERE email='$email'";
								mysqli_query($connection, $query);

								// Check if the user has exceeded login attempts
								if ($loginAttempts >= 3) {
									$_SESSION['error'] = "You have exceeded the maximum login attempts. Please try again after 5 minutes.";
								} else {
									$_SESSION['error'] = "Incorrect email or password";
								}
								header("Location: login.php");
								exit;
							}
						}

						if (isset($_SESSION['error'])) {
							echo '
							<div class="alert alert-danger">' . $_SESSION['error'] . '</div>
							';
							unset($_SESSION['error']);
						}

						if (isset($_SESSION['success'])) {
							echo '
							<div class="alert alert-success">' . $_SESSION['success'] . '</div>
							';
							unset($_SESSION['success']);
						}
						?>

						<form style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"
							method="POST">
							<div class="form-group mb-2">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" placeholder="Enter email" required>
							</div>

							<div class="form-group mb-2">
								<label for="password">Password</label>
								<input type="password" class="form-control" name="password" placeholder="Enter password"
									required>
							</div>

							<div class="form-group mb-3">
								<button type="submit" name="login" class="btn btn-success">Login</button>
								<p class="text-center">Don't have an account? <a href="register.php">Register here</a></p>
								<p class="text-center"><a href="forgot_password.php">Forgot Password?</a></p>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
