<?php
require 'configure.php';

$db_handle=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, Database );

print "Server Connection Established" . "<BR><br>";