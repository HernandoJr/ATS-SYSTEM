<?php
include 'database_connection.php';

// Function to generate timeslots from 7 AM to 7 PM, Monday to Friday, with a 30-minute interval
function generate_timeslots() {
    $start_time = new DateTime('07:00');
    $end_time = new DateTime('19:00');
    $interval = new DateInterval('PT30M'); // 30-minute interval
    $timeslots = array();
    $current_time = clone $start_time;
    while ($current_time <= $end_time) {
        $day = $current_time->format('D');
        if ($day != 'Sat' && $day != 'Sun') {
            $timeslots[] = $current_time->format('H:i');
        }
        $current_time->add($interval);
    }
    return $timeslots;
}

// Execute search query if search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $query = "SELECT * FROM faculty_loadings WHERE teacher LIKE '%$search_term%' OR section_name LIKE '%$search_term%' OR course_name LIKE '%$search_term%' OR subject_description LIKE '%$search_term%'";
} else {
    $query = "SELECT fl.id, fl.sched_code, fl.teacher_name, s.subject_code, fl.subject_units, fl.subject_hours, fl.subject_description, fl.subject_type, fl.contact_hours, fl.course_name, fl.section_name, fl.section_year 
    FROM faculty_loadings fl
    JOIN subjects s ON fl.subject_description = s.subject_description
    JOIN subjects sd ON sd.subject_type = s.subject_type";
    $result = $conn->query($query);
}

?>

<!-- Output the table -->
<table>
    <thead>
        <tr>
            <th>Teacher Name</th>
            <th>Subject Code</th>
            <th>Subject Description</th>
            <th>Subject Units</th>
            <th>Subject Hours</th>
            <th>Course Name</th>
            <th>Section Name</th>
            <th>Year Section</th>
            <th>Assigned Timeslot</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<tbody>
    <?php
    while ($row = $result->fetch_assoc()) {
        $timeslots = generate_timeslots();
        $index = rand(0, count($timeslots) - 1); // randomly choose a timeslot from the array
        $sched_code = $timeslots[$index];}
    ?>
    <tr>
        <td><?php echo $row['teacher_name']; ?></td>
        <td><?php echo $row['subject_code']; ?></td>
        <td><?php echo $row['subject_description']; ?></td>
        <td><?php echo $row['subject_units']; ?></td>
        <td><?php echo $row['subject_hours']; ?></td>
        <td><?php echo $row['course_name']; ?></td>
        <td><?php echo $row['section_name']; ?></td>
        <td><?php echo $row['section_year']; ?></td>
        <td><?php echo $sched_code; ?></td>
        <td>
            <a href="faculty_loading_edit.php?update_id=<?php echo $row['id']; ?>">Edit</a>
            <a href="faculty_loading_list.php?delete_id=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
</tbody>
