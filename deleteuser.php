<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
        $userid = $_GET['userid'];
	$seluser = get_selected_user($userid);
    if (mysqli_num_rows($seluser)==0){
	$_SESSION["message"] = "User not found."; 
	redirect_to("adduser.php");
        }            
                while ($row= mysqli_fetch_assoc($seluser)) {
		// Delete Query
                $query = "DELETE from tbl_user ";
                $query .= "WHERE userid = '$userid' LIMIT 1";
                $result = mysqli_query($connection, $query);
        
                if ($result && mysqli_affected_rows($connection) == 1) {
                 //success
                    $_SESSION["message"] .= "User Deleted. ";
                    redirect_to("adduser.php");
            
             } else {
                //failure
                $_SESSION["message"] .= "Delete User failed." . mysqli_error($connection);
                    redirect_to("adduser.php");
                }
            }
?>
    
