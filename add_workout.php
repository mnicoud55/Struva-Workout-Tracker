<?php
require("connect-db.php");
require("add_workout-db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workoutType = $_POST['workoutType'];
    // Process general Workout fields
    // ...
    addWorkout($_POST);
    $current_userID = $_POST['userID'];
    $current_workoutID = getWorkoutID($current_userID);

    switch ($workoutType) {
        case 'Circuit_Training':
            addCircuitTraining($_POST);
            break;
        case 'Cycling':
            addCycling($_POST);
            break;
        case 'Flexibility_Training':
            addFlexibilityTraining($_POST);
            break;
        case 'Hiking':
            addHiking($_POST, $current_workoutID);
            break;
        case 'Playing_a_Sport':
            addPlayingASport($_POST);
            break;
        case 'Run':
            addRun($_POST);
            break;
        case 'Strength_Training':
            addStrengthTraining($_POST);
            break;
        case 'Swim':
            addSwim($_POST);
            break;
        case 'Water_Sports':
            addWaterSports($_POST);
            break;
        // Add additional cases as needed
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Workout</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link your existing CSS file -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
}

input[type="text"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box; /* Ensures padding doesn't affect overall width */
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

@media only screen and (max-width: 600px) {
    form {
        padding: 15px;
        margin: 10px;
    }

    header {
        padding: 10px;
    }
}

        
    </style>
</head>
<body>
<?php include("header.html"); ?> 


    <!-- Content goes here -->
    <form action="add_workout.php" method="post" id="workoutForm">
        <!-- Dropdown for selecting workout type -->
        <select name="workoutType" id="workoutType" onchange="showAdditionalFields()">
    <option value="">Select Workout Type</option>
    <option value="Circuit_Training">Circuit Training</option>
    <option value="Cycling">Cycling</option>
    <option value="Flexibility_Training">Flexibility Training</option>
    <option value="Hiking">Hiking</option>
    <option value="Playing_a_Sport">Playing a Sport</option>
    <option value="Run">Running</option>
    <option value="Strength_Training">Strength Training</option>
    <option value="Swim">Swimming</option>
    <option value="Water_Sports">Water Sports</option>
</select>


        <!-- Fields for the Workout table -->
        <input type="int" name="duration" placeholder="Duration">
        <textarea name="notes" placeholder="Notes"></textarea>
        <input type="date" name="date">
        <label for="privacy">Privacy:</label>
    <select name="privacy" id="privacy">
        <option value="Public">Public</option>
        <option value="Friends">Friends</option>
        <option value="Private">Personal</option>
    </select>
        <!-- Need to make this a hidden input <input type="text" name="userId" placeholder="User ID"> --> 
        <input type="hidden" name="userID" value="U001">
        <!-- Dynamic version <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>"> -->

        <!-- Additional fields will be displayed here -->
        <div id="additionalFields"></div>

        <input type="submit" value="Add Workout">
    </form>
    <script>
    function showAdditionalFields() {
        var workoutType = document.getElementById("workoutType").value;
        var additionalFields = document.getElementById("additionalFields");
        additionalFields.innerHTML = ""; // Clear existing fields

        if (workoutType === "Circuit_Training") {
            additionalFields.innerHTML += "<input type='text' name='numCircuits' placeholder='Number of Circuits'>";
            // Add other fields specific to Circuit Training
        } else if (workoutType === "Cycling") {
            additionalFields.innerHTML += "<input type='text' name='pace' placeholder='Pace'>";
            additionalFields.innerHTML += "<input type='text' name='distance' placeholder='Distance'>";
            // Add other fields specific to Cycling
        } else if (workoutType === "Flexibility_Training") {
            additionalFields.innerHTML += "<input type='text' name='bodyPartFocus' placeholder='Body Part Focus'>";
            // Add other fields specific to Flexibility Training
        } else if (workoutType === "Hiking") {
            additionalFields.innerHTML += "<input type='text' name='trailName' placeholder='Trail Name'>";
            additionalFields.innerHTML += "<input type='int' name='hikingDistance' placeholder='Distance'>";
            additionalFields.innerHTML += "<input type='text' name='hikingPace' placeholder='Pace'>";
            additionalFields.innerHTML += "<input type='number' name='elevationChange' placeholder='Elevation Change'>";
            // Add other fields specific to Hiking
        } else if (workoutType === "Playing_a_Sport") {
            additionalFields.innerHTML += "<input type='text' name='sportName' placeholder='Sport Name'>";
            // Add other fields specific to Playing a Sport
        } else if (workoutType === "Run") {
            additionalFields.innerHTML += "<input type='text' name='runningPace' placeholder='Pace'>";
            additionalFields.innerHTML += "<input type='text' name='runningDistance' placeholder='Distance'>";
            additionalFields.innerHTML += "<input type='text' name='indoorOutdoor' placeholder='Indoor or Outdoor'>";
            // Add other fields specific to Running
        } else if (workoutType === "Strength_Training") {
            additionalFields.innerHTML += "<input type='text' name='muscleGroup' placeholder='Muscle Group'>";
            // Add other fields specific to Strength Training
        } else if (workoutType === "Swim") {
            additionalFields.innerHTML += "<input type='text' name='swimmingPace' placeholder='Pace'>";
            additionalFields.innerHTML += "<input type='text' name='swimmingDistance' placeholder='Distance'>";
            additionalFields.innerHTML += "<input type='text' name='yardsMeters' placeholder='Yards or Meters'>";
            additionalFields.innerHTML += "<input type='text' name='poolOpenWater' placeholder='Pool or Open Water'>";
            // Add other fields specific to Swimming
        } else if (workoutType === "Water_Sports") {
            additionalFields.innerHTML += "<input type='text' name='waterSportType' placeholder='Type of Water Sport'>";
            // Add other fields specific to Water Sports
        }
    }
</script>


<?php include("footer.html");?>
</body>
</html>
