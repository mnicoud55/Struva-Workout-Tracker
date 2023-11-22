<?php
require("connect-db.php");
require("friend-db.php");


$list_of_U001_friends = LoadFriendRequests("U001");
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
table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}

th, td {
    padding: 8px;
    text-align: left;
}

        </style>
  </head>

  
  <body>
  <?php include("header.html"); ?>  

  <table>
    <thead>
        <tr>
            <th>Friend ID</th>
            <!-- Add more headers if needed -->
        </tr>
    </thead>
    <tbody>
    <?php 
    $list_of_U001_friends = LoadFriendRequests("U001");
    foreach ($list_of_U001_friends as $friendRequest) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($friendRequest['sent_request_id']) . '</td>';
        echo '</tr>';
    }
    ?>

    </tbody>
</table>


  <?php include("footer.html"); ?>
</body>

</html>