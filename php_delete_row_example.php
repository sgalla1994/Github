<?php
if (isset($_POST['delete'])) {
    $FName = $_POST['firstnamedelete'];
    $SName = $_POST['surnamedelete'];
    
    $connect = mysqli_connect("TCP/IP", "DB USERNAME", "DB PASSWORD", "DB NAME");
    
    if ($connect) {
        $SQL = "DELETE FROM tbl_contacts WHERE First_Name='$FName', Surname='$SName";
    
        $result = mysqli_query ($connect, $SQL);
        
    $connect->query($SQL) or die("Cannot update");//update or error
    }
}
?>