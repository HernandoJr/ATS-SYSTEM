<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login Page</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="css/login.css">

</head>

<body>

	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header bg-dark text-center">
						<h1 style="color:gold;font-family:tahoma;font-weight:bold" ;>LOGIN</h1>
					</div>
					<div class="card-body shadow-lg p-5 mb-2 bg-gray">

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
							$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
							$result = mysqli_query($connection, $query);

							if (mysqli_num_rows($result) == 1) {
								// User is authenticated, set session variables and redirect to dashboard
								$user = mysqli_fetch_assoc($result);
								$_SESSION['user_id'] = $user['id'];
								$_SESSION['username'] = $user['username'];
								header("Location: dashboard.php");
								exit;
							} else {
								// User is not authenticated, redirect back to login with error message
								$_SESSION['error'] = "Incorrect email or password";
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

						<form style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" ;
							method="POST">
							<div class="form-group mb-2">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" placeholder="Enter email"
									required>
							</div>

							<div class="form-group mb-2">
								<label for="password">Password</label>
								<input type="password" class="form-control" name="password" placeholder="Enter password"
									required>
							</div>

							<div class="form-group mb-3">
								<button type="submit" name="login" class="btn btn-primary">Login</button>
								<p class="text-center">Don't have an account? <a href="register.php">Register here</a></p>

							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>