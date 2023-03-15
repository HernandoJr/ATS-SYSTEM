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

// Check if the semester ID is set
if (!isset($_GET['id'])) {
  header("Location: semester_list.php");
  exit();
}

// Get the semester ID from the URL
$semester_id = $_GET['id'];

// Delete the semester from the database
$sql = "DELETE FROM semesters WHERE id = $semester_id";

if (mysqli_query($conn, $sql)) {
  // Set a success message
  $_SESSION['success_message'] = "Semester deleted successfully.";
} else {
  // Set an error message
  $_SESSION['error_message'] = "Error deleting semester: " . mysqli_error($conn);
}

// Redirect to the semester list page
header("Location: semester_list.php");
exit();
?>
