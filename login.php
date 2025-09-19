<?php 
require 'connect-db.php';
require 'account-db.php';
ob_start();

if (isset($_COOKIE['user']))
{
  header('Location: mainpage.php');
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="styles.css">
  <title>Struva</title>      
</head>
<body>
  
  <div class="auth-wrapper">
    <div class="container container-narrow">
      <div class="card-modern">
        <h1 class="mb-1">Welcome to STRUVA</h1>
        <p class="muted mb-3">Please sign in to continue</p>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="form-modern">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" autofocus required />
          <br/>
          <label class="form-label">Password</label>
          <input type="password" name="pwd" class="form-control" required />
          <br/>
          <input type="submit" value="Sign in" class="btn btn-modern"  />   
        </form>
        <div class="mt-3">
          <a href="create-account.php" class="muted">Create an account</a>
        </div>
      </div>
    </div>
  </div>


<?php
// When an HTML form is submitted to the server using the post method,
// its field data are automatically assigned to the implicit $_POST global array variable.
// PHP script can check for the presence of individual submission fields using
// a built-in isset() function to seek an element of a specified HTML field name.
// When this confirms the field is present, its name and value can usually be
// stored in a cookie. This might be used to stored username and password details
// to be used across a website

// Define a function to handle failed validation attempts
function reject($message)
{
    echo "$message <br/>";	
}



// Handle form submission.
// If username and passwasd have been entered, perform authentication.
// (for this activity, assume that we just check whether the data are entered, no sophisticated authentication is performed. 
if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['username']) > 0)
{
	
   // If username contains only alphanumeric data, proceed to verify the password;
   // otherwise, reject the username and force re-login.
   $user = trim($_POST['username']);
   if (!ctype_alnum($user))   { // ctype_alnum() check if the values contain only alphanumeric data
      reject('Username must be alphanumeric');
      exit;
   }
   if(!doesUserExist($user)) {
      reject('Username does not exist');
      exit;
   }

   $hash = getPassword($user);

   // If pwd is entered and contains only alphanumeric data, set cookies and redirect the user to survey instruction page;
   // otherwise, reject the password and force re-login.
   if (isset($_POST['pwd']))
   {
      $pwd = htmlspecialchars($_POST['pwd']);   
      if (!ctype_alnum($pwd)) {
         reject('Invalid Password');
      }
      else if (password_verify($pwd, $hash[0])) {
         // Normal path: password verified against hash
         setcookie('user', $user, time()+3600);
         setcookie('pwd', $hash[0], time()+3600);         
         header('Location: mainpage.php');
      } 
      else if (strlen($hash[0]) < 60 && $pwd === $hash[0]) {
         // Fallback: plaintext match, upgrade to hashed password
         $newHash = password_hash($pwd, PASSWORD_ARGON2ID);

         // Update DB with new hash
         global $db;
         $stmt = $db->prepare("UPDATE Users SET password = :newHash WHERE UserID = :user");
         $stmt->execute([
            ':newHash' => $newHash,
            ':user'    => $user
         ]);

         // updatePassword($user, $newHash);

         // Continue login flow
         setcookie('user', $user, time()+3600);
         setcookie('pwd', $newHash, time()+3600);
         header('Location: mainpage.php');
      }
      else {
         echo "incorrect password, please try again";
      }
   }
}
ob_end_flush();
?>


</body>
</html>
