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
    $query = "DELETE FROM Friend_Request WHERE received_request_id = :userID1 AND sent_request_id = :userID2;
    INSERT INTO Friends VALUES (:userID1, :userID2);
    INSERT INTO Friends VALUES (:userID2, :userID1);";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID1", $userID1);
    $statement->bindValue(":userID2", $userID2);
    $statement->execute();
    $statement->closeCursor();
}
function DeclineFriendRequest($userID1, $userID2){
    global $db;
    $query = "DELETE FROM Friend_Request WHERE received_request_id = :userID1 AND sent_request_id = :userID2;";
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
function SearchUsers($searchTerm){
    global $db;
    $query = "SELECT UserID, Name FROM Users WHERE UserID = :searchTerm OR Name = :searchTerm;";
    $statement = $db->prepare($query); 
    $statement->bindValue(":searchTerm", $searchTerm);
    $statement->execute();
    $results = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $results;

}

function SendFriendRequest($userID1, $userID2){
    global $db;
    $query = "INSERT INTO Friend_Request (sent_request_id, received_request_id)
    VALUES (:userID1, :userID2)
    ON DUPLICATE KEY UPDATE sent_request_id = sent_request_id;";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID1", $userID1);
    $statement->bindValue(":userID2", $userID2);
    $statement->execute();
    $statement->closeCursor();

}

function PendingSentFriendRequests($userID1){
    global $db;
    $query = "SELECT received_request_id From Friend_Request WHERE sent_request_id = :userID1";
    $statement = $db->prepare($query); 
    $statement->bindValue(":userID1", $userID1);
    $statement->execute();
    $results = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $results;
}
?>