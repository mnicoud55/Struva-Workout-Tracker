<?php
require("connect-db.php");
require("friend-db.php");





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accept'])) {
        $requestID = $_POST['request_id'];
        AcceptFriendRequest("U001", $requestID);
        // Redirect or show a success message for acceptance
    } elseif (isset($_POST['decline'])) {
        $requestID = $_POST['request_id'];
        DeclineFriendRequest("U001", $requestID);
        // Redirect or show a success message for declining
    }
}
$searchResults = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
        $searchTerm = $_POST['search_term'];
        $searchResults = SearchUsers($searchTerm); // Function to search users based on input
    } elseif (isset($_POST['send_request'])) {
        $targetUserID = $_POST['target_user_id'];
        SendFriendRequest("U001", $targetUserID); // Assuming "U001" is the ID of the current user
        // Optionally, handle redirection or success message here
    }
}
$sentRequests = PendingSentFriendRequests("U001");



$list_of_U001_requests = LoadFriendRequests("U001");
$list_of_U001_friends = LoadFriends("U001");
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

  <!-- Add Friend Bar -->
  <form action="friendpage.php" method="post">
    <input type="text" name="search_term" placeholder="Enter UserID or Name">
    <input type="submit" name="search" value="Search">
  </form>
  
  
  <!-- Display Search Results -->
  <?php if (!empty($searchResults)): ?>
    <table>
      <thead>
        <tr>
          <th>User ID</th>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($searchResults as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['UserID']) ?></td>
            <td><?= htmlspecialchars($user['Name']) ?></td>
            <td>
              <form action="friendpage.php" method="post">
              <input type="hidden" name="target_user_id" value="<?= htmlspecialchars($user['UserID']) ?>">
                <input type="submit" name="send_request" value="Send Friend Request">
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <table>
    <thead>
        <tr>
            <th>Current Friend Requests</th>
            <!-- Add more headers if needed -->
        </tr>
    </thead>
    <tbody>
    <?php 
            $list_of_U001_requests = LoadFriendRequests("U001");
            foreach ($list_of_U001_requests as $friendRequest) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($friendRequest['sent_request_id']) . '</td>';
                // Accept form
                echo '<td>';
                echo '<form action="friendpage.php" method="post">';
                echo '<input type="hidden" name="request_id" value="' . htmlspecialchars($friendRequest['sent_request_id']) . '">';
                echo '<input type="submit" name="accept" value="Accept">';
                echo '</form>';
                echo '</td>';

                // Decline form
                echo '<td>';
                echo '<form action="friendpage.php" method="post">';
                echo '<input type="hidden" name="request_id" value="' . htmlspecialchars($friendRequest['sent_request_id']) . '">';
                echo '<input type="submit" name="decline" value="Decline">';
                echo '</form>';
                echo '</td>';
            }
            ?>

    </tbody>
</table>
<table>
        <thead>
            <tr>
                <th>Sent Friend Requests</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($sentRequests as $request) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($request['received_request_id']) . '</td>';
                // You can add more columns if necessary
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

<table>
    <thead>
        <tr>
            <th>Friend List: </th>
            <!-- Add more headers if needed -->
        </tr>
    </thead>
    <tbody>
    <?php 
        $list_of_U001_friends = LoadFriends("U001");
        foreach ($list_of_U001_friends as $friend) {
            echo '<tr>';
            // Access specific elements of the $friend array
            // Replace 'attribute_name' with the actual key name from the $friend array
            echo '<td>' . htmlspecialchars($friend['friend2_id']) . '</td>';
            echo '</tr>';
        }
    ?>
    </tbody>
</table>



  <?php include("footer.html"); ?>
</body>

</html>