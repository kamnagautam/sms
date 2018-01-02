<?php // Connecting to database...

define("DB_SERVER", "localhost");
define("DB_USER", "ENTER USERNAME HERE");
define("DB_PASS", "ENTER PASSWORD HERE");
define("DB_NAME", "sms");



$connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

//test if connection occured

if (mysqli_connect_errno()) {
	die("Database connection Failed : ". mysqli_connect_error() . " (". mysqli_connect_errno()." )" );
}





?>
