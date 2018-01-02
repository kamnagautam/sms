<?php // Connecting to database...

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "ramnik733");
define("DB_NAME", "sms");



$connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

//test if connection occured

if (mysqli_connect_errno()) {
	die("Database connection Failed : ". mysqli_connect_error() . " (". mysqli_connect_errno()." )" );
}





?>