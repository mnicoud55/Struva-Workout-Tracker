<?php
require("connect-db.php");
require("profilepage-db.php");


//check for if the person is logged in, can also be used in queries now so we don't have to hard code the userID
if (!isset($_COOKIE['user']))
{
  header('Location: login.php');
}



?>




<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
  <title>Get started with DB programming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <link rel="stylesheet" href="dashboard.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <style>
        body {
    font-family: 'Open Sans', sans-serif;
    background-color: lightgray;
    color: #333;
    line-height: 1.6;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

.card {
    background: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 20px auto;
}

input[type='text'], input[type='number'], input[type='date'] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type='submit'] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type='submit']:hover {
    background-color: #45a049;
}

@media screen and (max-width: 600px) {
    .container {
        width: 100%;
    }
}
.username-display {
  font-size: 24px; /* Larger font size */
  color: #333333; /* Dark text color for readability */
  font-weight: bold; /* Bold font for emphasis */
  text-align: center; /* Center align if it's at the top of the page */
  padding: 10px; /* Padding for spacing */
  margin-top: 10px; /* Space from the top of the page */
  background-color: #f0f0f0; /* Light background to stand out */
  border-radius: 5px; /* Rounded corners for aesthetics */
  width: fit-content; /* Fit to the size of the content */
  margin-left: auto; /* These two margins are for centering */
  margin-right: auto; /* the element if it's a block element */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}
.workout-item {
    display: flex;
    align-items: center;
    justify-content: start;
    margin-bottom: 10px; /* Space between items */
}

.workout-number {
    margin-right: 10px; /* Space between number and button */
    font-weight: bold; /* Make number bold */
}

.delete-form {
    display: inline; /* Inline form for alignment */
}

.delete-button {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px; /* Smaller padding */
    border-radius: 5px; /* Rounded corners */
    font-size: 0.8em; /* Smaller font size */
    cursor: pointer; /* Cursor change to indicate clickable */
}

.delete-button:hover {
    background-color: darkred;
}


        </style>


<body>
<?php include("header.html");  


// Fetch user information
$userData = getUserInfo($_COOKIE['user']);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'update_info') {
        // Code to handle user information update
            // Assuming you've already connected to the database and
    // $db is your database connection variable

    // Sanitize and validate the input
    $name = htmlspecialchars($_POST['name']);
    $height_ft = filter_var($_POST['height_ft'], FILTER_SANITIZE_NUMBER_INT);
    $height_in = filter_var($_POST['height_in'], FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_var($_POST['weight'], FILTER_SANITIZE_NUMBER_INT);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);

    // Create SQL UPDATE query
    $query = "UPDATE Users SET Name = :name, Height_ft = :height_ft, Height_in = :height_in, 
              Weight = :weight, DOB = :dob, Gender = :gender WHERE UserID = :userID";

    // Prepare and bind parameters
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':height_ft', $height_ft);
    $statement->bindValue(':height_in', $height_in);
    $statement->bindValue(':weight', $weight);
    $statement->bindValue(':dob', $dob);
    $statement->bindValue(':gender', $gender);
    $statement->bindValue(':userID', $_COOKIE['user']);  

    // Execute the query
    $statement->execute();
    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'delete_workout') {
        // Code to handle workout deletion
        $workoutId = $_POST['workout_id'];

        // Prepare and execute the delete statement
        $query = "DELETE FROM Workout WHERE WorkoutID = :workoutId";
        $statement = $db->prepare($query);
        $statement->bindValue(':workoutId', $workoutId);
        $statement->execute();
        
    }
}

$userData = getUserInfo($_COOKIE['user']);
$list_of_workouts = array_reverse(getPersonalWorkouts($_COOKIE['user']));
?>

<div class="username-display">
  <?php echo htmlspecialchars($_COOKIE['user']); ?>
</div>


<!-- User Information Update Form -->
<form action="profilepage.php" method="post">
Name: <input type="text" name="name" value="<?php echo isset($userData['Name']) ? htmlspecialchars($userData['Name']) : ''; ?>"><br>
  Height (ft): <input type="number" name="height_ft" value="<?php echo isset($userData['Height_ft']) ? htmlspecialchars($userData['Height_ft']) : ''; ?>"min ="0" max="8"> 
  (in): <input type="number" name="height_in" value="<?php echo isset($userData['Height_in']) ? htmlspecialchars($userData['Height_in']) : ''; ?>" min="0" max="11"><br>
  Weight: <input type="number" name="weight" value="<?php echo isset($userData['Weight']) ? htmlspecialchars($userData['Weight']) : ''; ?>" min="0"><br>
  Date of Birth: <input type="date" name="dob" value="<?php echo isset($userData['DOB']) ? htmlspecialchars($userData['DOB']) : ''; ?>"><br>
  Gender: <input type="text" name="gender" value="<?php echo isset($userData['Gender']) ? htmlspecialchars($userData['Gender']) : ''; ?>"><br>
  <input type="hidden" name="form_type" value="update_info">
  <input type="submit" value="Update">
</form>
<div class="container">
  <h1><b>Personal Workouts</b></h1>  
  <hr/>
  <div class="row">
    <?php foreach ($list_of_workouts as $workout): ?>
        <div class="workout-item">
            <span class="workout-number"><?php echo $workout['WorkoutID']; ?></span>
            <form action="profilepage.php" method="post" class="delete-form">
                <input type="hidden" name="workout_id" value="<?php echo $workout['WorkoutID']; ?>">
                <input type="hidden" name="form_type" value="delete_workout">
                <input type="submit" value="Delete Workout" class="delete-button">
            </form>
        </div>
        <br>
    <?php endforeach; ?>
  </div>
</div>


<?php include("footer.html"); ?>
    </body>
    </html>