<?php


function getAllWorkouts()
{
  global $db;
  $query = "select * from Workout";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function getPublicWorkouts()
{
    global $db;
    $query = "select * from Workout where Privacy = 'Public'";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();  
    $statement->closeCursor();
    return $results;
}
function getPersonalWorkouts($userID)
{
    global $db;
    $query = "select * from Workout where UserID = :userID";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID", $userID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getFriendWorkouts($userID)
{
    global $db;
    $query = "select * from Workout where (Privacy = 'Friends' or Privacy = 'Public') and UserID IN (select distinct (Friend2_id) from Friends where Friend1_id = :userID)";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $userID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getCircuitTraining($workoutID)
{
    global $db;
    $query = "select * from Circuit_Training where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getCircuitExercises($workoutID)
{
    global $db;
    $query = "select * from Circuit_Exercise where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getCycling($workoutID)
{
    global $db;
    $query = "select * from Cycling where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getFlexibilityTraining($workoutID)
{
    global $db;
    $query = "select * from Flexibility_Training where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getFlexibilityStretches($workoutID)
{
    global $db;
    $query = "select * from Flexibility_Stretch where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getHiking($workoutID)
{
    global $db;
    $query = "select * from Hiking where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getPlayingASport($workoutID)
{
    global $db;
    $query = "select * from Playing_a_Sport where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getRun($workoutID)
{
    global $db;
    $query = "select * from Run where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getStrengthTraining($workoutID)
{
    global $db;
    $query = "select * from Strength_Training where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getStrengthExercises($workoutID)
{
    global $db;
    $query = "select * from Strength_Exercise where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getSwim($workoutID)
{
    global $db;
    $query = "select * from Swim where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getWaterSports($workoutID)
{
    global $db;
    $query = "select * from Water_Sports where WorkoutID = :workoutID";
    $statement = $db->prepare($query);
    $statement->bindValue(":workoutID", $workoutID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}


?>
