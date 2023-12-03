<?php
require("connect-db.php");
require("account-db.php");
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  
  <title>STRUVA</title>    
    <style>
      a:hover { background-color:white; }
    </style>
</head>
<body>
    
<!--
Notice that we mixed PHP code and HTML code.
Although you can embed HTML code inside PHP code. 
In terms of performance, anything inside the PHP portion will be executed as script. 
Embedding HTML code which is static information causes the interpreter to execute static information
as script -- leading to unnecessary computation time. 

Good practice: try to separate HTML code from the PHP. The code may look strange, jumping in and out the PHP mode, 
but it yields better performance.    
 -->       
<div class="container">
    <h1>Welcome, please fill out the information below to create an account</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        Username: <input type="text" name="username" class="form-control" autofocus required /> <br/>
        Password: <input type="password" name="pwd" class="form-control" required /> <br/>
        Name: <input type="text" name="name" class="form-control" required /> <br/>
        Height: <select name="height_ft">
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4</option>
                <option value=5>5</option>
                <option value=6>6</option>
                <option value=7>7</option>
                <option value=8>8</option>
            </select>
        ft. <select name="height_in">
                <option value=0>0</option>
                <option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4</option>
                <option value=5>5</option>
                <option value=6>6</option>
                <option value=7>7</option>
                <option value=8>8</option>
                <option value=6>9</option>
                <option value=7>10</option>
                <option value=8>11</option>
            </select>
        in. <br/>
        Weight: <input type="number" name="weight" class="form-control" required /> lbs. <br/>
        Birthdate: <input type="date" id="birthday" name="birthday" value=<?php date("Y-m-d")?> min="1900-01-01" max=<?php date("Y-m-d")?> required/> <br/>
        Gender: <select name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="other/do not wish to disclose">Other / do not wish to disclose</option>
            </select> <br/> <br/>
        <input type="submit" value="Create account" class="btn btn-light"  /> 
    </form>

    <?php
// When an HTML form is submitted to the server using the post method,
// its field data are automatically assigned to the implicit $_POST global array variable.
// PHP script can check for the presence of individual submission fields using
// a built-in isset() function to seek an element of a specified HTML field name.
// When this confirms the field is present, its name and value can usually be
// stored in a cookie. This might be used to stored username and password details
// to be used across a website

// Handle form submission.
// If username and passwasd have been entered, perform authentication.
// (for this activity, assume that we just check whether the data are entered, no sophisticated authentication is performed. 

function reject($message)
{
    echo "$message <br/>";	
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['username']) > 0)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $account_error = false;

    // Check if username contains only alphanumeric data
    // otherwise, reject the username and force re-login.ab
    $user = trim($_POST['username']);
    if (!ctype_alnum($user)){   // checking valid username and if it already exists
        $account_error = true;
        reject('Invalid username, must only contain alphanumeric symbols');
    }
    if (doesUserExist($user)){
        $account_error = true;
        reject('Username already taken');
    }

    // Check if password is set and valid
    if (isset($_POST['pwd']))
    {
        $pwd = trim($_POST['pwd']);
        if (!ctype_alnum($pwd)){
            $account_error = true;
            reject('Invalid password, must only contain alphanumeric symbols');
        }
        $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    // Check if name is set and valid
    if (isset($_POST['name']))
    {
        $name = trim($_POST['name']);
        $name_no_spaces = str_replace(" ", "", $name);
        if (!ctype_alpha($name_no_spaces)){
            $account_error = true;
            reject('Invalid name, must only contain alphabetical symbols');
        }
    }

    //Check if height is set - already will be valid because it is a dropdown
    if (isset($_POST['height_ft']))
    {
        $height_ft = $_POST['height_ft'];
    }
    if (isset($_POST['height_in']))
    {
        $height_in = $_POST['height_in'];
    }

    //Check if weight is set and valid
    if(isset($_POST['weight']))
    {
        $weight = trim($_POST['weight']);
        if(!ctype_digit($weight)){
            $account_error = true;
            reject('Invalid weight, must be numeric');
        }
    }

    //Check if birthday is set and person is at least 18
    if(isset($_POST['birthday']))
    {
        $birthday = $_POST['birthday'];
        //checking that the date is formatted correctly
        if (DateTime::createFromFormat('Y-m-d', $birthday) !== false) {
            $birthdate = new DateTime($birthday);
            $currentDate = new DateTime();
            
            // Calculate the difference in years
            $age = $currentDate->diff($birthdate)->y;
        
            // Check if the person is over 18
            if ($age < 18) {
                $account_error = true;
                reject('must be over 18 to create an account');
            }
        } else {
            $account_error=true;
            reject('invalid date format');
        }
    }

    if (isset($_POST['gender']))
    {
        $gender = $_POST['gender'];
    }

    if(!$account_error){
        //TODO fill in this function to create an account
        if(!createAccount($user, $hashed_pwd, $name, $height_ft, $height_in, $weight, $birthday, $gender))
        {
            echo "error in creating account";
        } else {
            //creating a cookie for them
            setcookie('user', $user, time()+3600);
            setcookie('pwd', $hashed_pwd, time()+3600);

            // Redirect the browser to the main page
            header('Location: simpleform.php');
        }

    }
}
?>



</body>
</html>