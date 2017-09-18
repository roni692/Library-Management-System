<?php
/**
 * These are the database login details
 */  
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "");    // The database password. 
define("DATABASE", "library");    // The database name.
 
############## Make the mysql connection ###########
// Create connection
$conn = mysqli_connect(HOST, USER,PASSWORD,DATABASE );

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>