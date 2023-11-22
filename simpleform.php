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
    <button type="submit" name="privacyFilter" value="private" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'private' ? 'active' : ''; ?>">Private</button>
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
            foreach ($workout as $key => $value):
              if (is_int($key)) {

              } 
              elseif ($key != "WorkoutID" & $key != "Date" & $key != "UserID" & $key != "Privacy") {
                $res .= $key; 
                $res .= ": "; 
                $res .= $value;
                $res .= "<br>\n";
              }
            endforeach;
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
</div>


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div> 

<?php include("footer.html"); ?>
</body>
</html>