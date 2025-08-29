<?php

function addWorkout($data){
    global $db;

    // __________________________________
    // Running auto-increment code here temporarily
    $stmt = $db->query("SELECT MAX(WorkoutID) AS maxID FROM Workout");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $nextWorkoutID = ($row['maxID'] !== null) ? $row['maxID'] + 1 : 1;  // start at 1 if table empty
    $query = "INSERT INTO Workout (WorkoutID, Duration, Notes, Date, Privacy, UserID) VALUES (:workoutID, :duration, :notes, :date, :privacy, :userID)";
    $statement = $db->prepare($query); 

    // Bind values
    $statement->bindValue(":workoutID", $nextWorkoutID);
    $statement->bindValue(":duration", $data['duration']);
    $statement->bindValue(":notes", $data['notes']);
    $statement->bindValue(":date", $data['date']);
    $statement->bindValue(":privacy", $data['privacy']);
    $statement->bindValue(":userID", $data['userID']);
    // ________________________________________________
    
    /*
    $query = "INSERT INTO Workout (Duration, Notes, Date, Privacy, UserID) VALUES (:duration, :notes, :date, :privacy, :userID)";
    $statement = $db->prepare($query); 

    // Bind values
    $statement->bindValue(":duration", $data['duration']);
    $statement->bindValue(":notes", $data['notes']);
    $statement->bindValue(":date", $data['date']);
    $statement->bindValue(":privacy", $data['privacy']);
    $statement->bindValue(":userID", $data['userID']);
*/
    // Execute and get the last inserted ID
    $statement->execute();
    $workoutID = $db->lastInsertId();
    $statement->closeCursor();

    return $nextWorkoutID; // Return the newly created WorkoutID
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


function addCircuitTraining($data, $workoutID) {
    // Function to add Circuit Training workout
    // ...
    global $db;

    $query = "INSERT INTO Circuit_Training VALUES (:workoutID, :numCircuits)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":numCircuits", $data['numCircuits']);

    $statement->execute();
    
    $statement->closeCursor();

}

function addCircuitExercise($data, $workoutID, $exerciseName, $amount, $repsOrSeconds, $sets) {
    global $db; 
    $query = "INSERT INTO Circuit_Exercise VALUES (:workoutID, :exerciseName, :amount, :repsOrSeconds,:sets)";
    $statement = $db->prepare($query); 
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":exerciseName", $exerciseName);
    $statement->bindValue(":amount", $amount);
    $statement->bindValue(":repsOrSeconds", $repsOrSeconds);
    $statement->bindValue(":sets", $sets);

    $statement->execute();
    
    $statement->closeCursor();
}

function addCycling($data, $workoutID) {
    // Function to add Cycling workout
    // ...
    global $db;

    $query = "INSERT INTO Cycling VALUES (:workoutID, :pace, :distance)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":pace", $data['pace']);
    $statement->bindValue(":distance", $data['distance']);

    $statement->execute();
    
    $statement->closeCursor();
}

function addFlexibilityTraining($data, $workoutID) {
    // Function to add Flexibility Training workout
    // ...
    global $db;

    $query = "INSERT INTO Flexibility_Training VALUES (:workoutID, :bodyPartFocus)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":bodyPartFocus", $data['bodyPartFocus']);

    $statement->execute();
    
    $statement->closeCursor();

}

function addFlexibilityExercise($data, $workoutID, $stretchName, $duration, $sets){
    global $db; 
    $query = "INSERT INTO Flexibility_Stretch VALUES (:workoutID, :stretchName, :duration, :sets)";
    $statement = $db->prepare($query); 
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":stretchName", $stretchName);
    $statement->bindValue(":duration", $duration);
    $statement->bindValue(":sets", $sets);

    $statement->execute();
    
    $statement->closeCursor();  
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


function addPlayingASport($data, $workoutID) {
    // Function to add Playing a Sport workout
    // ...
    global $db;

    $query = "INSERT INTO Playing_a_Sport VALUES (:workoutID, :sportName)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":sportName", $data['sportName']);

    $statement->execute();
    
    $statement->closeCursor();
}

function addRun($data, $workoutID) {
    // Function to add Running workout
    // ...
    global $db;

    $query = "INSERT INTO Run VALUES (:workoutID, :runningPace, :runningDistance, :indoorOutdoor)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":runningPace", $data['runningPace']);
    $statement->bindValue(":runningDistance", $data['runningDistance']);
    $statement->bindValue(":indoorOutdoor", $data['indoorOutdoor']);

    $statement->execute();
    
    $statement->closeCursor();
}

function addStrengthTraining($data, $workoutID) {
    // Function to add Strength Training workout
    // ...
    global $db;

    $query = "INSERT INTO Strength_Training VALUES (:workoutID, :muscleGroup)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":muscleGroup", $data['muscleGroup']);

    $statement->execute();
    
    $statement->closeCursor();

}
function addStrengthExercise($data, $workoutID, $exercise, $weight, $reps, $sets){
    global $db; 
    $query = "INSERT INTO Strength_Exercise VALUES (:workoutID, :exercise, :weight, :reps, :sets)";
    $statement = $db->prepare($query); 
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":exercise", $exercise);
    $statement->bindValue(":weight", $weight);
    $statement->bindValue(":reps", $reps);
    $statement->bindValue(":sets", $sets);

    $statement->execute();
    
    $statement->closeCursor();
}

function addSwim($data, $workoutID) {
    // Function to add Swimming workout
    // ...
    global $db;

    $query = "INSERT INTO Swim VALUES (:workoutID, :swimmingPace, :swimmingDistance, :yardsMeters, :poolOpenWater)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":swimmingPace", $data['swimmingPace']);
    $statement->bindValue(":swimmingDistance", $data['swimmingDistance']);
    $statement->bindValue(":yardsMeters", $data['yardsMeters']);
    $statement->bindValue(":poolOpenWater", $data['poolOpenWater']);

    $statement->execute();
    
    $statement->closeCursor();
}

function addWaterSports($data, $workoutID) {
    // Function to add Water Sports workout
    // ...
    global $db;

    $query = "INSERT INTO Water_Sports VALUES (:workoutID, :waterSportType)";
    $statement = $db->prepare($query); 

    // Bind values from the $data array
    $statement->bindValue(":workoutID", $workoutID);
    $statement->bindValue(":waterSportType", $data['waterSportType']);

    $statement->execute();
    
    $statement->closeCursor();
}

?>