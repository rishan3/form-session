<?php 
error_reporting(0);
session_start();   //session


$username = "";
$email    = "";
$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'tiger');   //database


  // Register user

if (isset($_POST['reg_user'])) {        
  

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $gender = mysqli_real_escape_string($db, $_POST['gender']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

 // form validation...
  
  if (empty($username))
   { array_push($errors, "Username is required"); }

   if (empty($name))
   { array_push($errors, "Fullname is required"); }

  if (empty($email)) 
  { array_push($errors, "Gender is required"); }

  if (empty($gender)) 
  { array_push($errors, "Email is required"); }

  if (empty($password_1)) 
  { array_push($errors, "Password is required"); }

  if ($password_1 != $password_2) 
  {
	array_push($errors, "The two passwords do not match"); 
  }
 
  //  duplicate check email or username already exist or not

  $user_check_query = "SELECT * FROM lion WHERE username ='$username' AND email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { //  exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  //register user
  if (count($errors) == 0) {
  	$password = md5($password_1);// password encrypt  ...ithas 32  tagsss

  	$query = "INSERT INTO lion (name, username, email, gender, password)
  			  VALUES('$name', '$username', '$email', '$gender', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
    
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// ...
// ...

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Username is required");
     
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM lion WHERE username='$username' OR password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;          //session cld username
     
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>