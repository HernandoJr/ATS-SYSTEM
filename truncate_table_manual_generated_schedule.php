<?php
include 'database_connection.php';

// Truncate the table
$sql = "TRUNCATE TABLE manual_generated_schedule"; // replace table_name with the name of the table you want to truncate
if ($conn->query($sql) === TRUE) {
    echo "Deleted successfully";

} else {
    echo "Error truncating table: " . $conn->$error;
}

$conn->close();
?>

