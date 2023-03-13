<?php
// Include the database connection file
include 'database_connection.php';
include 'index.php';

// Start a new session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Check if the teacher ID is set
if (!isset($_GET['id'])) {
  header("Location: teacher_list.php");
  exit();
}

// Get the teacher ID from the URL
$teacher_id = $_GET['id'];

// Delete the teacher from the database
$sql = "DELETE FROM teachers WHERE teacher_id = $teacher_id";

if (mysqli_query($conn, $sql)) {
  // Set a success message
  $_SESSION['success_message'] = "Teacher deleted successfully.";
} else {
  // Set an error message
  $_SESSION['error_message'] = "Error deleting teacher: " . mysqli_error($conn);
}

// Redirect to the teacher list page
header("Location: teacher_list.php");
exit();
?>
