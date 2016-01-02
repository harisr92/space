<?php
	include "../../inc/dbinfo.inc";
	 $conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);
	if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
 	$db=mysqli_select_db($conn,DB_DATABASE);
?>
