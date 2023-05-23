<?php
include 'database_connection.php';
include 'index.php';

// Delete section if delete_id is set in the URL parameters
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM manual_generated_schedule WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data deleted successfully');</script>";
        echo "<script>window.location.href = 'manual_schedule_list.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Update section if update_id is set in the URL parameters
if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];
    $query = "SELECT * FROM manual_generated_schedule WHERE id='$id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

// Execute search query if search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $query = "SELECT * FROM manual_generated_schedule WHERE teacher LIKE '%$search_term%' OR section_name LIKE '%$search_term%' OR course_name LIKE '%$search_term%' OR subject_description LIKE '%$search_term%'";
} else {
    $query = "SELECT fl.id, fl.sched_code, fl.teacher_name, s.subject_code, fl.subject_units, fl.subject_hours, fl.subject_description, fl.subject_type, fl.contact_hours, fl.course_name, fl.section_name, fl.section_year 
    FROM manual_generated_schedule fl
    JOIN subjects s ON fl.subject_description = s.subject_description
    JOIN subjects sd ON sd.subject_type = s.subject_type";
$result = $conn->query($query);

}

// Update record if update form is submitted
if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $teacher_name = $_POST['teacher_name'];
    $subject_description = $_POST['subject_description'];
    $subject_units = $_POST['subject_units'];
    $subject_hours = $_POST['subject_hours'];
    $course_name = $_POST['course_name'];
    $section_name = $_POST['section_name'];
    $year_section = $_POST['year_section'];
   

    $sql = "UPDATE manual_generated_schedule SET teacher_name='$teacher_name', subject_description='$subject_description', subject_units='$subject_units', subject_hours='$subject_hours', course_name='$course_name', section_name='$section_name', section_year='$section_year' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location.href = 'manual_schedule_list.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>



<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CDN Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--External CSS-->
    <link rel="stylesheet" href="css/manual_schedule_list.css">
    <!-- CDN Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xm/1MSCs2sDx6kLZ6Qm84zE4U6mSWJXa3gfn+Or05YnSdrgHxOmkjIVtwZgMk50D" crossorigin="anonymous">
        </script>
    <!-- CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-PoX9L+uPbsAVCv+jcUscle6Udq7VrypQT8Uv7zsLAbB6C9fV0pG8yBlxkdgsHOD+" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-8t+gWy0JhGjbOxbtu2QzKACoVrAJRz/iBRymx1Ht/W1hXxrFL05t8PChqoo3sLsP" crossorigin="anonymous">
        </script>

</head>

<body>



    <div class="container">


    <h1 style="  text-shadow: 3px 2px 3px rgba(0, .5, 0, .80)" class="fw-bolder text-center text-warning mt-3 text-outline">MANUAL SCHEDULE LIST</H1>

        <form method="POST">
            <div class="input-group mb-3">

                <input type="text" class="form-control rounded" placeholder="Search by Teacher ID/Name" name="search">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-responsive">
        <table  style="vertical-align:middle" class="table  table-bordered table table-hover table-sm  text-center">
            <thead class="bg-success text-dark text-white">
                <tr class="text-sm">
                    <th >No.</th>
                    <th>Sched Code</th>
                    <th>Teacher Name</th>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Subject Type</th>
                    <th>Contact Hours</th>
                    <th>Units</th>
                    <th>Year & Section</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End TIme</th>
                    <th>Room</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php

                // Execute search query if search form is submitted
                if (isset($_POST['search'])) {
                    $search_term = $_POST['search'];
                    $query = "SELECT * FROM manual_generated_schedule WHERE teacher LIKE '%$search_term%' OR room_name LIKE '%$search_term%' OR course_name LIKE '%$search_term%'";
                    $result = $conn->query($query);
                    if (!$result) {
                        die("Error executing search query: " . $conn->error);
                    }
                } else {
                    $query = "SELECT * FROM manual_generated_schedule";
                    $result = $conn->query($query);
                    if (!$result) {
                        die("Error executing query: " . $conn->error);
                    }
                }
                ?>

                <?php

                if ($result->num_rows > 0) {

                    // output data of each row
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        // Loop through data and combine year and section columns
                        $section_year = $row["section_year"];
                        $section_name = $row["section_name"];
                        $course_name = $row["course_name"];

                        
                        if ($section_year == "1st") {
                            $course_year_section = $course_name  . " 101-" . $section_name;
                        } elseif ($section_year == "2nd") {
                            $course_year_section = $course_name . " 201-" . $section_name;
                        } elseif ($section_year == "3rd") {
                            $course_year_section = $course_name . " 301-" . $section_name;
                        } elseif ($section_year == "4th") {
                            $course_year_section = $course_name   . " 401-" . $section_name;
                        } else {
                            $course_year_section = $course_name . $section_year . $section_name;
                        }

                        // Update row in database with combined value
                        $id = $row["id"];
                        $sql = "UPDATE manual_generated_schedule SET course_year_section = '$course_year_section' WHERE id = '$id'";
                        $result2 = $conn->query($sql);


                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row["schedcode"] . "</td>";
                        echo "<td>" . $row["teacher"] . "</td>";
                        echo "<td>" . $row["subject_code"] . "</td>";
                        echo "<td>" . $row["subject_description"] . "</td>";
                        echo "<td>" . $row["subject_type"] . "</td>";
                        echo "<td>" . $row["subject_hours"] . "</td>";
                        echo "<td>" . $row["subject_units"] . "</td>";
                        echo "<td>" . $course_year_section . "</td>";
                        echo "<td>" . $row["day"] . "</td>";
                        echo "<td>" . $row["start_time"] . "</td>";
                        echo "<td>" . $row["end_time"] . "</td>";
                        echo "<td>" . $row["room_name"] . "</td>";

                        echo "<td>";
                        echo "<a href='manual_schedule_update.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Update<i class='fas fa-edit'></i></a><hr>";
                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?delete_id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this subject?')\">Delete<i class='fas fa-trash'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }

                } else {
                    echo "<tr><td colspan='5'>No manual_generated_schedule found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="manual_schedule.php" class="btn btn-success sm"><i class='fas fa-user-plus'></i>Assign timeslot</a>
        <button type="button" class="btn btn-danger" id="truncate-btn">Delete all the data in faculty loading table</button>
        
    </div> </div>

    <script>
        $(document).ready(function () {
            $('#truncate-btn').click(function () {
                if (confirm("Are you sure you want to truncate the table?")) {
                    $.ajax({
                        url: "truncate_table_manual_schedule.php", // the PHP script t hat truncates the table
                        success: function (response) {
                            alert(response); // show the response message from the PHP script
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>