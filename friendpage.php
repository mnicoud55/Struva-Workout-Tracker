<?php
require("connect-db.php");
require("friend-db.php");

if (!isset($_COOKIE['user']))
{
  header('Location: login.php');
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accept'])) {
        $requestID = $_POST['request_id'];
        AcceptFriendRequest($_COOKIE['user'], $requestID);
        // Redirect or show a success message for acceptance
    } elseif (isset($_POST['decline'])) {
        $requestID = $_POST['request_id'];
        DeclineFriendRequest($_COOKIE['user'], $requestID);
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
        // Guard against sending to self, duplicates, and existing friendships
        $incoming = LoadFriendRequests($_COOKIE['user']); // requests sent to me
        $outgoing = PendingSentFriendRequests($_COOKIE['user']); // requests I sent
        $friends  = LoadFriends($_COOKIE['user']);

        $incomingIds = array_map(function($row){ return $row['sent_request_id']; }, $incoming);
        $outgoingIds = array_map(function($row){ return $row['received_request_id']; }, $outgoing);
        $friendIds   = array_map(function($row){ return $row['friend2_id']; }, $friends);

        if ($targetUserID !== $_COOKIE['user']
            && !in_array($targetUserID, $friendIds)
            && !in_array($targetUserID, $incomingIds)
            && !in_array($targetUserID, $outgoingIds)) {
            SendFriendRequest($_COOKIE['user'], $targetUserID);
        }
        // Optionally, handle redirection or success message here
    }
}
$sentRequests = PendingSentFriendRequests($_COOKIE['user']);



$list_of_U001_requests = LoadFriendRequests($_COOKIE['user']);
$list_of_U001_friends = LoadFriends($_COOKIE['user']);
// Precompute helper arrays for quick checks in search results
$friendIds = array_map(function($row){ return $row['friend2_id']; }, $list_of_U001_friends);
$incomingRequestIds = array_map(function($row){ return $row['sent_request_id']; }, $list_of_U001_requests);
$outgoingRequestIds = array_map(function($row){ return $row['received_request_id']; }, $sentRequests);
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

  <!-- Add Friend Bar -->
  <div class="container container-narrow">
    <div class="card-modern mb-3">
      <form action="friendpage.php" method="post" class="form-modern">
        <input type="text" name="search_term" placeholder="Enter UserID or Name">
        <input type="submit" name="search" value="Search" class="btn btn-modern">
      </form>
    </div>
  </div>
  
  
  <!-- Display Search Results -->
  <?php if (!empty($searchResults)): ?>
    <div class="container container-narrow">
    <table class="table-modern">
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
              <?php 
                $targetId = $user['UserID'];
                $isSelf = ($targetId === $_COOKIE['user']);
                $isFriend = in_array($targetId, $friendIds);
                $hasPending = in_array($targetId, $incomingRequestIds) || in_array($targetId, $outgoingRequestIds);

                if ($isSelf) {
                    echo '<span class="muted">This is you</span>';
                } elseif ($isFriend) {
                    echo '<span class="muted">Already friends</span>';
                } elseif ($hasPending) {
                    echo '<span class="muted">Friend request pending</span>';
                } else {
              ?>
                <form action="friendpage.php" method="post">
                  <input type="hidden" name="target_user_id" value="<?= htmlspecialchars($user['UserID']) ?>">
                  <input type="submit" name="send_request" value="Send Friend Request" class="btn btn-modern">
                </form>
              <?php } ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
  <?php endif; ?>
  <?php if (empty($searchResults)): ?>
    <div class="container container-narrow muted">No Found Results</div>
    <?php endif; ?>
  <div class="container container-narrow mt-3">
  <table class="table-modern">
    <thead>
        <tr>
            <th>Current Friend Requests</th>
            <!-- Add more headers if needed -->
        </tr>
    </thead>
    <tbody>
    <?php 
            $list_of_U001_requests = LoadFriendRequests($_COOKIE['user']);
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

<table class="table-modern mt-3">
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

<table class="table-modern mt-3">
    <thead>
        <tr>
            <th>Friend List: </th>
            <!-- Add more headers if needed -->
        </tr>
    </thead>
    <tbody>
    <?php 
        $list_of_U001_friends = LoadFriends($_COOKIE['user']);
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
  </div>



  <?php include("footer.html"); ?>
</body>

</html>