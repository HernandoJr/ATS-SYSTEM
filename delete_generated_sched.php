<?php
include 'database_connection.php';

    $query = "UPDATE faculty_loadings SET 
                room_name = NULL,
                room_type = NULL,
                start_time = NULL,
                end_time = NULL,
                day = NULL";
    echo"deleted successfully!";
    mysqli_query($conn, $query);

?>