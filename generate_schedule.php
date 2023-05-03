<?php

// Connect to the database
include 'database_connection.php';

//Get the list of subjects, teachers, and rooms from the faculty loading table
$faculty_load = array();
$query = "SELECT subject_code, teacher, course, year, section, room FROM faculty_loadings";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faculty_load[] = $row;
    }
}

// Extract unique subjects, teachers, and rooms from the faculty loading data
$subjects = array_unique(array_column($faculty_load, 'subject_code'));
$teachers = array_unique(array_column($faculty_load, 'teacher'));
$rooms = array_unique(array_column($faculty_load, 'room'));


// Define the genetic algorithm parameters
$population_size = 100;  // The number of schedules in each generation
$generations = 100;  // The number of generations to run the algorithm
$mutation_rate = 0.2;  // The probability of a mutation in a schedule
$crossover_rate = 0.8;  // The probability of a crossover between two schedules

// Generate the initial population of schedules
$population = array();
for ($i = 0; $i < $population_size; $i++) {
    $schedule = array();
    foreach ($subjects as $subject) {
        $classes = array_filter($faculty_load, function($row) use ($subject) {
            return $row['subject_code'] == $subject;
        });
        $teacher_indices = array_rand($teachers, count($classes));
        shuffle($teacher_indices);
        foreach ($classes as $i => $class) {
            $teacher_name = $teachers[$teacher_indices[$i]];
            $room_name = $class['room'];
            $schedule[] = array(
                "subject_description" => $class["course"],
                "subject_units" => "",
                "teacher_name" => $teacher_name,
                "room_name" => $room_name,
                "timeslot" => ""
            );
        }
    }
    
    $population[] = $schedule;
}

// Define the fitness function
function fitness($schedule) {
    // Calculate the fitness of a schedule based on the number of conflicts
    $conflicts = 0;
    foreach ($schedule as $i => $class1) {
        foreach ($schedule as $j => $class2) {
            if ($i != $j) {
                if ($class1["teacher_name"] == $class2["teacher_name"] && $class1["timeslot"] == $class2["timeslot"]) {
                    $conflicts++;
                }
                if ($class1["room_name"] == $class2["room_name"] && $class1["timeslot"] == $class2["timeslot"]) {
                    $conflicts++;
                }
            }
        }
    }
    return 1 / ($conflicts + 1);
}

// Define the selection function
function selection($population) {
    // Select the fittest schedules from the population
    $selected = array();
    $fitnesses = array_map("fitness", $population);
    for ($i = 0; $i < count($population); $i++) {
        $index1 = array_rand($fitnesses, 1);
        $index2 = array_rand($fitnesses, 1);
        if ($fitnesses[$index1] >= $fitnesses[$index2]) {
            $selected[] = $population[$index1];
        } else {
            $selected[] = $population[$index2];
        }
        }
        return $selected;
        }

        // Define the crossover function
function crossover($parent1, $parent2) {
    // Perform a crossover between two schedules
    $child = array();
    $num_classes = count($parent1);
    for ($i = 0; $i < $num_classes; $i++) {
    if (rand(0, 1) == 0) {
    $child[] = $parent1[$i];
    } else {
    $child[] = $parent2[$i];
    }
    }
    return $child;
    }
    
    // Define the mutation function
    function mutation($schedule) {
    // Perform a mutation on a schedule
    $num_classes = count($schedule);
    for ($i = 0; $i < $num_classes; $i++) {
    if (rand(0, 1) < $mutation_rate) {
    $schedule[$i]["timeslot"] = rand(1, 5);
    }
    }
    return $schedule;
    }
    
    // Run the genetic algorithm
    for ($generation = 0; $generation < $generations; $generation++) {
    // Select the fittest schedules from the population
    $selected = selection($population);
    // Perform crossovers between the selected schedules
    $children = array();
    for ($i = 0; $i < $population_size; $i++) {
    $parent1 = $selected[array_rand($selected)];
    $parent2 = $selected[array_rand($selected)];
    $child = crossover($parent1, $parent2);
    $children[] = $child;
    }
    // Mutate some of the schedules
    foreach ($children as &$schedule) {
    $schedule = mutation($schedule);
    }
    // Evaluate the fitness of the new population
    $fitnesses = array_map("fitness", $children);
    // Sort the new population by fitness
    array_multisort($fitnesses, SORT_DESC, $children);
    // Replace the old population with the new population
    $population = array_slice($children, 0, $population_size);
    }
    
    // Print the best schedule
    $best_schedule = $population[0];
    echo "<table>";
    echo "<tr><th>Subject</th><th>Units</th><th>Teacher</th><th>Room</th><th>Timeslot</th></tr>";
    foreach ($best_schedule as $class) {
    $subject_description = $class["subject_description"];
    $subject_units = $class["subject_units"];
    $teacher_name = $class["teacher_name"];
    $room_name = $class["room_name"];
    $timeslot = $class["timeslot"];
    echo "<tr><td>$subject_description</td><td>$subject_units</td><td>$teacher_name</td><td>$room_name</td><td>$timeslot</td></tr>";
    }
    echo "</table>";
    
    // Close the database connection
    $conn->close();
    
    ?>
    
    </body>
    </html>
