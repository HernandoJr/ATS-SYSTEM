    <?php
    include 'database_connection.php';
    include 'index.php';

    $error = '';
    function check_teacher_load($teacher_id) {
        global $conn;
        $query = "SELECT COUNT(*) as count FROM faculty_loadings WHERE teacher=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }
    
    

    if (isset($_POST['submit'])) {
        $teacher = $_POST['teacher'];
        $subjectDescription = $_POST['subject_description'];
        $courseName = $_POST['course_name'];
        $sectionName = $_POST['section_name'];
        $sectionYear = $_POST['section_year'];

        // Validate form fields (PDO)
        if (empty($teacher) || empty($subjectDescription) || empty($courseName) || empty($sectionName) || empty($sectionYear)) {
            $error = 'Please fill in all required fields.';
        } else {
            // Check teacher load
            $teacher_load = check_teacher_load($teacher);
            if ($teacher_load >= 5) {
                $error = 'Teacher has already been assigned 5 subjects.';
            } else {
                
            // Get the subject units from the database
            $stmt = $conn->prepare("SELECT subject_units, subject_type, subject_hours, subject_code FROM subjects WHERE subject_description = ?");
            $stmt->bind_param("s", $subjectDescription);
            $stmt->execute();
            $result = $stmt->get_result();
            

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $subjectUnits = $row['subject_units'];
                $subjectType = $row['subject_type'];
                $subjectHours = $row['subject_hours'];
                $subjectCode = $row['subject_code'];
            } else {
                $subjectUnits = "";
                $subjectType = "";
                $subjectHours = "";
                $subject_code = "";
            }}

            // Check if the data already exists in the faculty_loading table
            $stmt = $conn->prepare("SELECT * FROM faculty_loadings WHERE teacher=? AND subject_description=? AND course_name=? AND section_name=? AND section_year=?");
            $stmt->bind_param("sssss", $teacher, $subjectDescription, $courseName, $sectionName, $sectionYear);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Data already exists, do nothing
                echo "<script>alert('Data already exist!');</script>";
            } else {
                // Data does not exist, insert the data into the faculty_loading table
                $stmt = $conn->prepare("INSERT INTO faculty_loadings (teacher, subject_description, subject_code, subject_hours, subject_type, subject_units, course_name, section_name, section_year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssss", $teacher, $subjectDescription, $subjectCode, $subjectHours, $subjectType, $subjectUnits, $courseName, $sectionName, $sectionYear);

                try {
                    $stmt->execute();
                    echo "<script>alert('Data added successfully');</script>";
                    echo "<script>window.location.href = 'faculty_loading_list.php';</script>";
                } catch (Exception $error) {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . $error->getMessage() . '</div>';
                }
            }
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
        <link rel="stylesheet" href="css/index.css">
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

        <title>ATS-SYSTEM</title>


    </head>



    <form method="POST">


        <div class="container mt-3">
            <!-- Dropdown for selecting a teacher -->
            <div class="form-group">
                <label for="teacher">Teacher</label>
                <select class="form-control" id="teacher" name="teacher">
                    <?php
                    $sql = "SELECT * FROM teachers";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["firstname"] . '' . $row["lastname"] . '">' . $row["firstname"] . ' ' . $row["lastname"] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Dropdown for selecting a course -->
            <div class="form-group">
                <label for="course_name">Course</label>
                <select class="form-control" id="course_name" name="course_name">
                    <?php
                    $sql = "SELECT * FROM courses";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["course_name"] . '">' . $row["course_name"] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>



            <!-- Form for selecting a subject -->

            <div class="form-group">
                <label for="subject_description">Subject Description</label>
                <select class="form-control" id="subject_description" name="subject_description">
                    <?php
                    $sql = "SELECT * FROM subjects";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["subject_description"] . '">' . $row["subject_description"] . '</option>';
                        }
                    }
                    ?>
                </select>


            </div>
            <!-- Dropdown for selecting a section -->
            <div class="form-group">
                <label for="section_name">Section</label>
                <select class="form-control" id="section_name" name="section_name">
                    <?php
                    $sql = "SELECT * FROM sections";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["section_name"] . '">' . $row["section_name"] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Dropdown for selecting a section year -->
            <div class="form-group">
                <label for="section_year">Year</label>
                <select class="form-control" id="section_year" name="section_year">
                    <?php
                    $year_choices = ['1st', '2nd', '3rd', '4th'];
                    foreach ($year_choices as $year) {
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    }
                    ?>
                </select>
            </div>


            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <a href="faculty_loading_list.php" class="btn btn-danger" name="back">Back</a>

        </div>
        </body>
    </form>

    </html>