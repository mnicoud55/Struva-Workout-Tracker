<?php
require("connect-db.php");
require("workout-db.php");

$list_of_workouts = array_reverse(getAllWorkouts());
$list_of_public_workouts = array_reverse(getPublicWorkouts());
$user001_workouts = array_reverse(getPersonalWorkouts("U001"));
$user001_friends = array_reverse(getFriendWorkouts("U001"));
$results = array_reverse(getPublicWorkouts());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $filter = $_POST['privacyFilter'];
  $userID = "U001"; // Assuming a user ID, replace with actual user ID

  switch ($filter) {
      case 'public':
          $results = array_reverse(getPublicWorkouts());
          break;
      case 'private':
          $results = array_reverse(getPersonalWorkouts($userID));
          break;
      case 'friends':
          $results = array_reverse(getFriendWorkouts($userID));
          break;
  }
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
            background-color: lightgray;
        }
        /* Style for the button group to have black borders */
.btn-group .btn {
    border: 1px solid black;
}

/* Style for the active button */
.active {
    text-decoration: underline;
    font-weight: bold;
}
.btn-group {
  display: flex;
    justify-content: center;
}
/* Remove rounded corners for a more seamless look */
.btn-group .btn {
    border-radius: 0;
}
.workout-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 15px;
    background-color: #f9f9f9;
  }

  .card-header {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    margin-bottom: 10px;
  }

  .card-body p {
    margin: 0 0 10px;
  }

  .container {
    max-width: 800px;
    margin: auto;
  }
  .add-workout-btn {
    position: fixed; /* Stick it to a position */
    left: 20px; /* Distance from left */
    bottom: 20px; /* Distance from bottom */
    padding: 10px 20px; /* Padding inside the button */
    background-color: #007bff; /* Button color */
    color: white; /* Text color */
    text-decoration: none; /* Remove underline from the link */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 2px 5px rgba(0,0,0,0.3); /* Shadow effect */
    z-index: 1000; /* Make sure it's on top of other elements */
    transition: background-color 0.3s; /* Smooth color transition */
}

.add-workout-btn:hover {
    background-color: #0056b3; /* Change color on hover */
}

    </style>
</head>

<body>
<?php include("header.html"); ?>  
<!-- <form action="simpleform.php" method="post">
        <label for="privacyFilter">Choose a filter:</label>
        <select name="privacyFilter" id="privacyFilter">
            <option value="public">Public</option>
            <option value="private">Private</option>
            <option value="friends">Friends</option>
        </select>
        <input type="submit" value="Filter">
    </form> -->
    <?php 
$currentFilter = $_SERVER["REQUEST_METHOD"] == "POST" ? $_POST['privacyFilter'] : 'public';
?>
<!-- Form for the buttons to select the filters -->
<form action="simpleform.php" method="post">
<div class="btn-group" role="group" aria-label="Filter Buttons">
    <button type="submit" name="privacyFilter" value="public" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'public' ? 'active' : ''; ?>">Public</button>
    <button type="submit" name="privacyFilter" value="friends" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'friends' ? 'active' : ''; ?>">Friends</button>
    <button type="submit" name="privacyFilter" value="private" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'private' ? 'active' : ''; ?>">Personal</button>
</div>

</form>
  <!--Cards to display each of the workouts that are fetched -->
<div class="container">
  <h1><b>Workout Feed</b></h1>  
  <hr/>
  <div class="row">
    <?php foreach ($results as $workout): ?>
      <div class="workout-card">
        <div class="card-header">
          <h4><?php echo $workout['UserID']; ?></h4>
        </div>
        <div class="card-body">
          <?php 
            $res = "";

            //checking for each specific workout 
            //Please note this will be the most ungodly code known to man but it should work
            $Circuit_Training = getCircuitTraining($workout['WorkoutID']);
            $Cycling = getCycling($workout['WorkoutID']);
            $Flexibility_Training = getFlexibilityTraining($workout['WorkoutID']);
            $Hiking = getHiking($workout['WorkoutID']);
            $Playing_a_Sport = getPlayingASport($workout['WorkoutID']);
            $Run = getRun($workout['WorkoutID']);
            $Strength_Training = getStrengthTraining($workout['WorkoutID']);
            $Swim = getSwim($workout['WorkoutID']);
            $Water_Sports = getWaterSports($workout['WorkoutID']);


            if (count($Circuit_Training) > 0) {
              //add actual output later
              $res .= "<u>Circuit Training</u> <br>\n";
              $workout = $Circuit_Training[0] + $workout;
            } else if (count($Cycling) > 0) {
              $res .= "<u>Cycling</u> <br>\n";
              $workout = $Cycling[0] + $workout;
            } else if (count($Flexibility_Training) > 0){
              $res .= "<u>Flexibility Training</u> <br>\n";
              $workout = $Flexibility_Training[0] + $workout;
            } else if (count($Hiking) > 0){
              $res .= "<u>Hiking</u> <br>\n";
              $workout = $Hiking[0] + $workout;
            } else if (count($Playing_a_Sport) > 0){
              $res .= "<u>Playing a Sport</u> <br>\n";
              $workout = $Playing_a_Sport[0] + $workout;
            } else if (count($Run) > 0){
              $res .= "<u>Run</u> <br>\n";
              $workout = $Run[0] + $workout;
            } else if (count($Strength_Training) > 0){
              $res .= "<u>Strength Training</u> <br>\n";
              $workout = $Strength_Training[0] + $workout;
            } else if (count($Swim) > 0) {
              $res .= "<u>Swim</u> <br>\n";
              $workout = $Swim[0] + $workout;
            } else if (count($Water_Sports) > 0){
              $res .= "<u>Water Sports</u> <br>\n";
              $workout = $Water_Sports[0] + $workout;
            }

            // adds individual exercises/stretches
            if (count($Circuit_Training) > 0) {
              $Circuit_Exercises = getCircuitExercises($workout['WorkoutID']);
              foreach ($Circuit_Exercises as $exercise) {
                foreach ($exercise as $key => $value) {
                  if (is_int($key)) {

                  } 
                  elseif ($key != "WorkoutID" && $key != "Reps_or_Seconds") {
                    $visibleKey = str_replace('_', ' ', $key);
                    if ($visibleKey == "Type") {
                      $visibleKey = "Exercise";
                    }
                    $res .= ucwords($visibleKey); 
                    $res .= ": "; 
                    $res .= $value;
                    if ($visibleKey == "Amount") {
                      $res .= " ";
                      $res .= lcfirst($exercise['Reps_or_Seconds']);
                    }
                    $res .= "<br>\n";
                  }
                }
              }
            }
            elseif (count($Flexibility_Training) > 0) {
              $Flexibility_Stretches = getFlexibilityStretches($workout['WorkoutID']);
              foreach ($Flexibility_Stretches as $stretch) {
                foreach ($stretch as $key => $value) {
                  if (is_int($key)) {

                  } 
                  elseif ($key != "WorkoutID") {
                    $visibleKey = str_replace('_', ' ', $key);
                    if ($visibleKey == "Type") {
                      $visibleKey = "Stretch";
                    }
                    $res .= ucwords($visibleKey); 
                    $res .= ": "; 
                    $res .= $value;
                    $res .= "<br>\n";
                  }
                }
              }
            }
            elseif (count($Strength_Training) > 0) {
              $Strength_Exercises = getStrengthExercises($workout['WorkoutID']);
              foreach ($Strength_Exercises as $exercise) {
                foreach ($exercise as $key => $value) {
                  if (is_int($key)) {

                  } 
                  elseif ($key != "WorkoutID") {
                    $visibleKey = str_replace('_', ' ', $key);
                    $res .= ucwords($visibleKey); 
                    $res .= ": "; 
                    $res .= $value;
                    $res .= "<br>\n";
                  }
                }
              }
            }

            foreach ($workout as $key => $value) {
              if (is_int($key)) {

              } 
              elseif ($key != "WorkoutID" && $key != "Date" && $key != "UserID" && $key != "Privacy") {
                $visibleKey = str_replace('_', ' ', $key);
                if ($key == "Duration") {
                  $visibleKey = "Total Duration";
                }
                $res .= ucwords($visibleKey); 
                $res .= ": "; 
                $res .= $value;
                if ($key == "Duration") {
                  $res .= " minutes";
                }
                $res .= "<br>\n";
              }
            }

            echo $res;
          ?>

          <p>Posted: <?php 
          $date = new DateTime($workout['Date']);
          //Formatting of each of the gotten dates
          $formattedDate = $date->format('F j, Y');
          echo $formattedDate; 
          
          ?></p>
          
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <!-- Add Workout Button -->
<a href="add_workout.php" class="add-workout-btn">Add Workout+</a>
</div>


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div> 
<a href="add_workout.php" class="add-workout-btn">Add Workout+</a>


<?php include("footer.html"); ?>
</body>
</html>