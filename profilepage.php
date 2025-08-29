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
  <title>Struva</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <link rel="stylesheet" href="dashboard.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <style>
        body { }
        .container { }
        .profile-img { width: 100px; height: 100px; border-radius: 50%; margin: 20px auto; }
        .username-display { margin-top: 10px; }


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


    //checking that the date is formatted correctly
    $valid_dob=false;
    if (DateTime::createFromFormat('Y-m-d', $dob) !== false) {
        $birthdate = new DateTime($dob);
        $currentDate = new DateTime();
            
        // Calculate the difference in years
        $age = $currentDate->diff($birthdate)->y;
        
        // Check if the person is over 18
        if ($age >= 18) {
            $valid_dob = true;
        } else {
            echo 'must be over 18 to have an account';
        }
        } else {
            echo 'invalid date format';
        }

    if($valid_dob){
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
    }
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

<div class="username-display card-modern container-narrow" style="text-align:center;">
  <?php echo htmlspecialchars($_COOKIE['user']); ?>
</div>


<!-- User Information Update Form -->
<div class="container container-narrow">
<div class="card-modern mb-3">
<form action="profilepage.php" method="post" class="form-modern">
Name: <input type="text" name="name" value="<?php echo isset($userData['Name']) ? htmlspecialchars($userData['Name']) : ''; ?>"><br>
  Height (ft): <input type="number" name="height_ft" value="<?php echo isset($userData['Height_ft']) ? htmlspecialchars($userData['Height_ft']) : ''; ?>"min ="0" max="8"> 
  (in): <input type="number" name="height_in" value="<?php echo isset($userData['Height_in']) ? htmlspecialchars($userData['Height_in']) : ''; ?>" min="0" max="11"><br>
  Weight: <input type="number" name="weight" value="<?php echo isset($userData['Weight']) ? htmlspecialchars($userData['Weight']) : ''; ?>" min="0"><br>
  Date of Birth: <input type="date" name="dob" value="<?php echo isset($userData['DOB']) ? htmlspecialchars($userData['DOB']) : ''; ?>"><br>
  Gender: <input type="text" name="gender" value="<?php echo isset($userData['Gender']) ? htmlspecialchars($userData['Gender']) : ''; ?>"><br>
  <input type="hidden" name="form_type" value="update_info">
  <input type="submit" value="Update" class="btn btn-modern">
</form>
</div>

<div class="container">
  <h1><b>Personal Workouts</b></h1>  
  <hr/>
  <div class="row">
    <?php foreach ($list_of_workouts as $workout): ?>
        <div class="workout-item card-modern" style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
            <span class="workout-number"><?php echo $workout['WorkoutID']; ?></span>
            <form action="profilepage.php" method="post" class="delete-form">
                <input type="hidden" name="workout_id" value="<?php echo $workout['WorkoutID']; ?>">
                <input type="hidden" name="form_type" value="delete_workout">
                <input type="submit" value="Delete Workout" class="btn btn-danger">
            </form>
        </div>
        <br>
    <?php endforeach; ?>
  </div> 
</div>

</div>


<?php include("footer.html"); ?>
    </body>
    </html>