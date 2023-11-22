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
    $query = "select * from Workout where (Privacy = 'Friends' or Privacy = 'Public') and UserID = (select distinct (Friend2_id) from Friends where Friend1_id = :userID)";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $userID);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}


//SELECT * from Workout WHERE privacy = friends and UserID = (SELECT DISTINCT(Friend2_id) FROM Friends WHERE Friend1_id = selfID);


?>
