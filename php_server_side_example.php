<?php
session_start();

// initializing variables
//THESE VARIABLES ARE REQUIRED FOR CAPTURING DATA FROM FORM TO SEND OVER FROM REGISTER.PHP FORM
$title = "";
$name = "";
$dateofbirth = "";
$contactnumber = "";
$username = "";
$email    = "";
$password_1 = "";
$password_2 = "";
$patchtestcheck = "";
$errors = array();

// connect to the database
$db = mysqli_connect('IP_ADDRESS', 'USERNAME', 'PASSWORD', 'DATABASE');
echo "connected";

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $dateofbirth = mysqli_real_escape_string($db, $_POST['dateofbirth']);
  $contactnumber = mysqli_real_escape_string($db, $_POST['contactnumber']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $patchtestcheck = mysqli_real_escape_string($db, $_POST['patchtestcheck']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($title)) { array_push($errors, "Title is required"); }
  if (empty($name)) { array_push($errors, "name is required"); }
  if (empty($dateofbirth)) { array_push($errors, "Date of Birth is required"); }
  if (empty($contactnumber)) { array_push($errors, "Contact number is required"); }
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "Passwords do not match please check and retry");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM tbl_customer WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO tbl_customer (title, name, dateofbirth, contactnumber, username, email, address, password, patchtestcheck)
  			  VALUES('$title', '$name', '$dateofbirth', '$contactnumber', '$username', '$email', '$address', '$password', '$patchtestcheck')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: cust_home.php');
  }
}

// ...

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM tbl_customer WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: cust_home.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>