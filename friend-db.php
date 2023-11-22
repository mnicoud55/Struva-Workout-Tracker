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

?>