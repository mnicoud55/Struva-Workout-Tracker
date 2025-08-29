<?php
require("connect-db.php");
require("workout-db.php");
ob_start();


//check for if the person is logged in, can also be used in queries now so we don't have to hard code the userID
if (!isset($_COOKIE['user']))
{
  header('Location: login.php');
}

$list_of_workouts = array_reverse(getAllWorkouts());
$list_of_public_workouts = array_reverse(getPublicWorkouts());
$user001_workouts = array_reverse(getPersonalWorkouts($_COOKIE['user']));
$user001_friends = array_reverse(getFriendWorkouts($_COOKIE['user']));
$results = array_reverse(getPublicWorkouts());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $filter = $_POST['privacyFilter'];
  $userID = $_COOKIE['user']; // Assuming a user ID, replace with actual user ID

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
  <title>Struva</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <link rel="stylesheet" href="dashboard.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <style>
        body { }

    </style>
</head>

<body>
<?php include("header.html"); ?>  
<!-- <form action="mainpage.php" method="post">
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
<form action="mainpage.php" method="post" class="mb-3" style="display:flex;justify-content:center;">
  <div class="btn-group" role="group" aria-label="Filter Buttons">
    <button type="submit" name="privacyFilter" value="public" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'public' ? 'active' : ''; ?>">Public</button>
    <button type="submit" name="privacyFilter" value="friends" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'friends' ? 'active' : ''; ?>">Friends</button>
    <button type="submit" name="privacyFilter" value="private" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'private' ? 'active' : ''; ?>">Personal</button>
  </div>
</form>
  <!--Cards to display each of the workouts that are fetched -->
<div class="container container-narrow">
  <h1><b>Workout Feed</b></h1>  
  <hr/>
  <div class="row">
    <?php foreach ($results as $workout): ?>
      <div class="workout-card card-modern">
        <div class="card-header">
          <h3><?php echo getNameFromID($workout['UserID'])?><h3>
          <h4><?php echo $workout['UserID']; ?></h4>
        </div>
        <div class="card-body">
          <?php 
            $res = "";

            //checking for each specific workout 
            $Circuit_Training = getCircuitTraining($workout['WorkoutID']);
            $Cycling = getCycling($workout['WorkoutID']);
            $Flexibility_Training = getFlexibilityTraining($workout['WorkoutID']);
            $Hiking = getHiking($workout['WorkoutID']);
            $Playing_a_Sport = getPlayingASport($workout['WorkoutID']);
            $Run = getRun($workout['WorkoutID']);
            $Strength_Training = getStrengthTraining($workout['WorkoutID']);
            $Swim = getSwim($workout['WorkoutID']);
            $Water_Sports = getWaterSports($workout['WorkoutID']);


            $hasCircuit = count($Circuit_Training) > 0;
            $hasFlex = count($Flexibility_Training) > 0;
            $hasStrength = count($Strength_Training) > 0;

            if ($hasCircuit) {
              // section heading
              $res .= "<h5 class='mb-2'><u>Circuit Training</u></h5>\n";
              $workout = $Circuit_Training[0] + $workout;
            } else if (count($Cycling) > 0) {
              $res .= "<h5 class='mb-2'><u>Cycling</u></h5>\n";
              $workout = $Cycling[0] + $workout;
            } else if ($hasFlex){
              $res .= "<h5 class='mb-2'><u>Flexibility Training</u></h5>\n";
              $workout = $Flexibility_Training[0] + $workout;
            } else if (count($Hiking) > 0){
              $res .= "<h5 class='mb-2'><u>Hiking</u></h5>\n";
              $workout = $Hiking[0] + $workout;
            } else if (count($Playing_a_Sport) > 0){
              $res .= "<h5 class='mb-2'><u>Playing a Sport</u></h5>\n";
              $workout = $Playing_a_Sport[0] + $workout;
            } else if (count($Run) > 0){
              $res .= "<h5 class='mb-2'><u>Run</u></h5>\n";
              $workout = $Run[0] + $workout;
            } else if ($hasStrength){
              $res .= "<h5 class='mb-2'><u>Strength Training</u></h5>\n";
              $workout = $Strength_Training[0] + $workout;
            } else if (count($Swim) > 0) {
              $res .= "<h5 class='mb-2'><u>Swim</u></h5>\n";
              $workout = $Swim[0] + $workout;
            } else if (count($Water_Sports) > 0){
              $res .= "<h5 class='mb-2'><u>Water Sports</u></h5>\n";
              $workout = $Water_Sports[0] + $workout;
            }

            // Build general info block once from merged $workout
            $generalInfo = "";
            foreach ($workout as $key => $value) {
              if (is_int($key)) {

              } 
              elseif ($key != "WorkoutID" && $key != "Date" && $key != "UserID" && $key != "Privacy") {
                $visibleKey = str_replace('_', ' ', $key);
                if ($key == "Duration") {
                  $visibleKey = "Total Duration";
                }
                $generalInfo .= "<div><span class='muted'>" . ucwords($visibleKey) . "</span>: <strong>" . $value;
                if ($key == "Duration") {
                  $generalInfo .= " minutes";
                }
                $generalInfo .= "</strong></div>\n";
              }
            }

            // For sub-workout types, show general info first, then a divider, then list items
            if ($hasCircuit || $hasFlex || $hasStrength) {
              $res .= $generalInfo;
              $res .= "<hr class='subitem-divider'>";
            }

            // adds individual exercises/stretches
            if ($hasCircuit) {
              $res .= "<div class='mt-2 mb-1'><em>Exercises</em></div>";
              $res .= "<hr class='subitem-divider'>";
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
                    $res .= "<div><span class='muted'>" . ucwords($visibleKey) . "</span>: <strong>" . $value;
                    if ($visibleKey == "Amount") {
                      $res .= " " . lcfirst($exercise['Reps_or_Seconds']);
                    }
                    $res .= "</strong></div>\n";
                  }
                }
                $res .= "<hr class='subitem-divider'>";
              }
            }
            elseif ($hasFlex) {
              $res .= "<div class='mt-2 mb-1'><em>Stretches</em></div>";
              $res .= "<hr class='subitem-divider'>";
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
                    $res .= "<div><span class='muted'>" . ucwords($visibleKey) . "</span>: <strong>" . $value . "</strong></div>\n";
                  }
                }
                $res .= "<hr class='subitem-divider'>";
              }
            }
            elseif ($hasStrength) {
              $res .= "<div class='mt-2 mb-1'><em>Exercises</em></div>";
              $res .= "<hr class='subitem-divider'>";
              $Strength_Exercises = getStrengthExercises($workout['WorkoutID']);
              foreach ($Strength_Exercises as $exercise) {
                foreach ($exercise as $key => $value) {
                  if (is_int($key)) {

                  } 
                  elseif ($key != "WorkoutID") {
                    $visibleKey = str_replace('_', ' ', $key);
                    $res .= "<div><span class='muted'>" . ucwords($visibleKey) . "</span>: <strong>" . $value . "</strong></div>\n";
                  }
                }
                $res .= "<hr class='subitem-divider'>";
              }
            }

            // For non-subworkout types, show general info after heading
            if (!$hasCircuit && !$hasFlex && !$hasStrength) {
              $res .= $generalInfo;
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
  <!-- Add Workout Button (floating) -->
<a href="add_workout.php" class="btn btn-modern add-workout-fab">Add a Workout+</a>
</div>


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div> 
<!-- <a href="add_workout.php" class="add-workout-btn">Add Workout+</a> -->


<?php 
include("footer.html"); 
ob_end_flush();
?>
</body>
</html>