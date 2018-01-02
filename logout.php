<?php require_once("includes/session.php"); ?>
<?php
$_SESSION = array(); // Destroy the variables.
session_destroy(); // Destroy the session itself.
header("location: index.php");
?>