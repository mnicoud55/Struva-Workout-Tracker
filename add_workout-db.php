<?php

function addWorkout($data){
    global $db;

    $query = "INSERT INTO Workout VALUES (((SELECT COUNT(WorkoutID)+1 FROM Workout), :duration, :notes, :date, :privacy, :userID)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":duration", $data['duration']);
    $statement->bindValue(":notes", $data['notes']);
    $statement->bindValue(":date", $data['date']);
    $statement->bindValue(":privacy", $data['privacy']);
    $statement->bindValue(":userID", $data['userID']); // Assuming 'userId' is the name attribute in your form

    $db->beginTransaction(); // Start transaction
    try {
        $statement->execute();
        $db->commit(); // Commit transaction
    } catch (Exception $e) {
        $db->rollBack(); // Rollback transaction on error
        // Handle exception (e.g., log the error)
    }
    
    $statement->closeCursor();
}

function getWorkoutID($userID) {
    global $db;

    $query = "SELECT WorkoutID FROM Workout WHERE UserID = :userID ORDER BY WorkoutID DESC LIMIT 1";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if ($result) {
        return $result['WorkoutID'];
    } else {
        return null; // Or handle the case where there's no workout
    }
}


function addCircuitTraining($data) {
    // Function to add Circuit Training workout
    // ...
    global $db; 

}

function addCycling($data) {
    // Function to add Cycling workout
    // ...
}

function addFlexibilityTraining($data) {
    // Function to add Flexibility Training workout
    // ...
}

function addHiking($data, $workoutID) {
    global $db;

    $query = "INSERT INTO Hiking VALUES (:workoutID, :trailName, :hikingDistance, :hikingPace, :elevationChange)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":trailName", $data['trailName']);
    $statement->bindValue(":hikingDistance", $data['hikingDistance']);
    $statement->bindValue(":hikingPace", $data['hikingPace']);
    $statement->bindValue(":elevationChange", $data['elevationChange']);

    $statement->execute();
    
    $statement->closeCursor();
}


function addPlayingASport($data) {
    // Function to add Playing a Sport workout
    // ...
}

function addRun($data) {
    // Function to add Running workout
    // ...
}

function addStrengthTraining($data) {
    // Function to add Strength Training workout
    // ...
}

function addSwim($data) {
    // Function to add Swimming workout
    // ...
}

function addWaterSports($data) {
    // Function to add Water Sports workout
    // ...
}

?>