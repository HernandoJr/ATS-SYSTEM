<?php

function assignTimeslots()
{
    //include the db connection php file.
    include 'database_connection.php';
    include 'index.php';

    // Function to assign timeslots to subjects
    // Retrieve all subjects from the database
    $select_subjects_sql = "SELECT subjects.id, subjects.subject_description, subjects.subject_hours, timeslots.start_time, timeslots.end_time FROM subjects INNER JOIN timeslots ON subjects.timeslot_id = timeslots.id";
    $result_subjects = mysqli_query($conn, $select_subjects_sql);

    if ($result_subjects) {
        // Display the subjects in a table
        echo '<div class="container mt-4">';
        echo '<table class="table table-striped">';
        echo '<thead>
                <tr>
                    <th>Subject Description</th>
                    <th>Subject Hours</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>';
        echo '<tbody>';

        while ($row_subject = mysqli_fetch_assoc($result_subjects)) {
            $subject_description = $row_subject['subject_description'];
            $subject_hours = $row_subject['subject_hours'];
            $start_time = $row_subject['start_time'];
            $end_time = $row_subject['end_time'];

            echo '<tr>';
            echo '<td>' . $subject_description . '</td>';
            echo '<td>' . $subject_hours . '</td>';
            echo '<td>' . $start_time . '</td>';
            echo '<td>' . $end_time . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        echo "Timeslots assigned successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}

// Check if the button is clicked
if (isset($_POST['assign_timeslots'])) {
    assignTimeslots();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Assign Timeslots</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <form method="POST">
            <button type="submit" name="assign_timeslots" class="btn btn-primary">Assign Timeslots</button>
        </form>
    </div>
</body>

</html>
