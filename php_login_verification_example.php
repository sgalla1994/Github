<?php
$email = "";
$pass = "";
$errorMessage2 = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        require '../configure.php';
	$email = $_POST['email'];
	$pass = $_POST['psw'];
        
    $database = "elysium";
    
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );
        
    if ($db_found) {

	$SQL = $db_found->prepare('SELECT * FROM tbl_customer WHERE email = ?');
	$SQL->bind_param('s', $email);
	$SQL->execute();
	$result = $SQL->get_result();
    
    if ($result->num_rows == 1) {

        $db_field = $result->fetch_assoc();

        if (password_verify($pword, $db_field['psw'])) {
            session_start();
            $_SESSION['login'] = "1";
            header ("Location: cust_home.php");
        }
        else {
            $errorMessage = "Login FAILED";
            session_start();
            $_SESSION['login'] = '';
        }
    }
    else {
        $errorMessage1 = "username FAILED";
    }
}
}
?>