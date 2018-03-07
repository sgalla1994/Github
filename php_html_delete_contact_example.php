<body>
	<section>
		<div class="wrapper">
			<img src="../assets/img/logo.png" alt="Contacts V1.0.0" style="width:400px;height:225px">
			<br>
			<h2>Delete Contact</h2>
			<h4>INSERT DETAILS BELOW TO DELETE CONTACT</h4>
			<br><br>
		</div>
	</section>

<section>
	<div class="container">
		<form name="form1" method="post" action="delete_contact.php">
			<input type="text" placeholder="*First Name" name="firstname" value="" required>
			<input type="text" placeholder="Middle Name" name="middlename" value="">
			<input type="text" placeholder="*Surname" name="surname" value="" required>
			<br><br><br>
			<input class="btn btn--stripe" type="submit" name="submit1" value="Add">
		</form>
	</div>
	</section>
</body>
     
<?PHP

$fname = "";
$mname = "";
$sname = "";
if (isset($_POST['Submit1'])) {
	require '../configure.php';
	
	$fName = $_POST['firstname'];
	$mname = $_POST['middlename'];
	$sname = $_POST['surname'];

	$database = "contacts";

	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, $database );

if ($db_found) {

	$SQL = $db_found->prepare("DELETE FROM members WHERE first_name=?, middle_name=?, surname=?");

	$SQL->bind_param('sss', $fname, $mname, $sname);
	$SQL->execute();

	$SQL->close();
	$db_found->close();

	print "ROW DELETED";
}
else {
	print "Database NOT Found ";
}

}

?>
<?php
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {

header ("Location: login.php");
}
?>