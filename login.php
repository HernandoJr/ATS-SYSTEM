<!DOCTYPE html>
<?php 
include 'database_connection.php';
?>	
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	 <!-- CDN Bootstrap CSS -->
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
        </script>
    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
	<title>Login Page</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="css/login.css">

</head>
<script>
	$(document).ready(function(){
  $("forms").click(function(){
    $(this).hide();
  });
});
</script>


<body >

	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header bg-dark text-center">
						<h1 style="color:gold;font-family:tahoma;font-weight:bold" ;>LOGIN</h1>
					</div>
					<div class="card-body shadow-lg p-5 mb-2 bg-gray" >

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