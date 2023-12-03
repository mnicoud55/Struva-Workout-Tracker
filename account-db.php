<?php
function doesUserExist($userID){
    global $db;

    try {
        $query = "SELECT * FROM Users WHERE UserID=:userID";
        $statement = $db->prepare($query);
        $statement->bindValue(":userID", $userID);
        $statement->execute();
        $results=$statement->fetchAll();
        if(count($results) > 0) return true;
        else return false;
    } catch (PDOException $e) {
        // Handle any database-related errors
        echo "Error: " . $e->getMessage();
        // You may want to log the error or perform other actions based on your needs
    }

    // Return false in case of an error
    return false;
}

function createAccount($userID, $hashed_pwd, $name, $height_ft, $height_in, $weight, $birthdate, $gender)
{
    global $db;
    
    echo $hashed_pwd;
    echo strlen($hashed_pwd);

    $query = 'INSERT INTO Users (UserID, Name, Height_ft, Height_in, Weight, DOB, Password, Gender) 
              VALUES (:userID, :name, :height_ft, :height_in, :weight, :birthdate, :password, :gender)';
    
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(":userID", $userID);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":height_ft", $height_ft);
        $statement->bindValue(":height_in", $height_in);
        $statement->bindValue(":weight", $weight);
        $statement->bindValue(":birthdate", $birthdate);
        $statement->bindValue(":password", $hashed_pwd);
        $statement->bindValue(":gender", $gender);
        $statement->execute();

        // Return true if the execution was successful
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // Return false if there was an error
        return false;
    }
}

function getPassword($user)
{
    global $db;
    $query = 'SELECT Password FROM Users WHERE UserID=:userID';
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $user);
    $statement->execute();
    $results = $statement->fetch(); //using fetch because there will only be one result
    return $results;
}
?>