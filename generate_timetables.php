<?php
include 'index.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedule Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-5">Schedule Generator</h1>

        <button id="generate-schedule-btn" class="btn btn-primary mb-3">Generate Schedule</button>

        <div id="schedule-table"></div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // When the "Generate Schedule" button is clicked
            $('#generate-schedule-btn').click(function() {
                // Send an AJAX request to generate the schedule
                $.ajax({
                    type: 'POST',
                    url: 'generate_schedule.php',
                    dataType: 'html',
                    success: function(response) {
                        // Display the schedule table
                        $('#schedule-table').html(response);
                    }
                });
            });
        });
    </script>

</body>
</html>
