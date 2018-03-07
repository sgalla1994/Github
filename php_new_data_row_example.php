<?php
$title = "";
$fname = "";
$sname = "";
$dob = "";
$mobileno = "";
$telephoneno = "";
$emailadd = "";
$password = "";
$password2 = "";
$errorMessage = "";
$message1 = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	<!--enter src for database connection file if seperate if not then enter database login details--!>
	require '../configure.php';

	$title = $_POST['title'];
	$fname = $_POST['fname'];
    $sname = $_POST['sname'];
	$dob = $_POST['dob'];
    $mobileno = $_POST['mobno'];
	$telephoneno = $_POST['telno'];
    $emailadd = $_POST['email'];
	$password = $_POST['psw'];
    $password2 = "psw2";


    $database = "elysium";

	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );

	if ($db_found) {		
		$SQL = $db_found->prepare('SELECT * FROM tbl_customer WHERE email = ?');
		$SQL->bind_param('s', $emailadd);
		$SQL->execute();
		$result = $SQL->get_result();

		if ($result->num_rows > 0) {
			$errorMessage = "Username already taken";
            
        if ($_POST["psw"] === $_POST["confirm_password"]) {
   // success!
}
		}
		else {
			$phash = password_hash($password, PASSWORD_DEFAULT);
			$SQL = $db_found->prepare("INSERT INTO tbl_customer (title, fname, sname, dob, mobno, telno, email, psw) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			$SQL->bind_param('ssssssss', $title, $fname, $sname, $dob, $mobileno, $telephoneno, $emailadd, $phash);
			$SQL->execute();
            
			header ("Location: index.php");
            
            $message1 = "Successful Please Login";
		}
	}
	else {
		$errorMessage1 = "Database Not Found";
	}
}
?>