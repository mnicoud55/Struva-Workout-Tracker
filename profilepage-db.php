<?php


function getPersonalWorkouts($selfid)
{
  global $db;
  $query = "SELECT * FROM Workout WHERE UserID = :selfID";
  $statement = $db->prepare($query); 
  $statement->bindValue(":selfID", $selfid);
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function getUserInfo($userId) {
    global $db;
    //$query = "SELECT UserID, Name, Height_ft, Height_in, Weight, DOB, Gender FROM Users WHERE UserID = :selfID";
    $query = "SELECT * FROM Users WHERE UserID = :userID";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID", $userId);
    $statement->execute();
    $results = $statement->fetch();   
    $statement->closeCursor();
    return $results;
}

function updateUserInfo($userID){
    global $db;

    $query = "";
}

?>

