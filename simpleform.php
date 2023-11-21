<?php
require("connect-db.php");
require("workout-db.php");

$list_of_workouts = getAllWorkouts();
$list_of_public_workouts = getPublicWorkouts();
$user001_workouts = getPersonalWorkouts("U001");
$user001_friends = getFriendWorkouts("U001");
$results = getPublicWorkouts();
// if ($_SERVER['REQUEST_METHOD'] == 'POST')
// {
// }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $filter = $_POST['privacyFilter'];
  $userID = "U001"; // Assuming a user ID, replace with actual user ID

  switch ($filter) {
      case 'public':
          $results = getPublicWorkouts();
          break;
      case 'private':
          $results = getPersonalWorkouts($userID);
          break;
      case 'friends':
          $results = getFriendWorkouts($userID);
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

/* Optional: Remove rounded corners for a more seamless look */
.btn-group .btn {
    border-radius: 0;
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
    <button type="submit" name="privacyFilter" value="private" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'private' ? 'active' : ''; ?>">Private</button>
    <button type="submit" name="privacyFilter" value="friends" class="btn btn-outline-info btn-lg <?php echo $currentFilter == 'friends' ? 'active' : ''; ?>">Friends</button>
</div>

</form>
    
<div class="container">
  <h1>Workout Feed</h1>  
  <!-- 
    Start on dropdown:
    <form name="privacyForm" action="simpleform.php" method="post">
    <label for="privacySelect">Select a privacy level:</label>
    <select name="privacySelect" id="privacySelect">
        <option value="Public">Public</option>
        <option value="Friends">Friends</option>
        <option value="Private">Private</option>
    </select>
    <input type="submit" name="privactBtn" class="btn btn-primary" />
  </form> -->
<hr/>
<h3>List of Workouts</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">UserID 
    <!-- <th width="30%">WorkoutID         -->
    <th width="30%">Duration        
    <th width="30%">Notes 
    <th width="30%">Date 
    <!-- <th width="30%">Privacy  -->
    

    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php foreach ($results as $workout): ?>
  <tr>
    <td><?php echo $workout['UserID']; ?></td>  
     <!-- <td><//?php echo $workout['WorkoutID']; ?></td>    -->
     <!-- column name --> 
     <td><?php echo $workout['Duration']; ?></td>        
     <td><?php echo $workout['Notes']; ?></td>  
     <td><?php echo $workout['Date']; ?></td>  
     <!-- <td><//?php echo $workout['Privacy']; ?></td>   -->
     
  </tr>
<?php endforeach; ?>
</table>
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