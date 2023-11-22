<?php
function LoadFriendRequests($userID){
    global $db;
    $query = "SELECT sent_request_id From Friend_Request WHERE received_request_id = :userID";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID", $userID);
    $statement->execute();
    $results = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $results;
    
}
function AcceptFriendRequest($userID1, $userID2){
    global $db;
    $query = "DELETE FROM Friend_Request WHERE recieved_request_id = :userID1 AND sent_request_id = :userID2;
    INSERT INTO Friends VALUES (:userID1, :userID2);
    INSERT INTO Friends VALUES (:userID2, :userID1);";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID1", $userID1);
    $statement->bindValue(":userID2", $userID2);
    $statement->execute();
    $statement->closeCursor();
}

function LoadFriends($userID){
    global $db;
    $query = "SELECT friend2_id From Friends WHERE friend1_id = :userID;";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID", $userID);
    $statement->execute();
    $results = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $results;
}
?>