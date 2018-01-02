<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
        $attendanceid = $_GET['attendanceid'];
	$selattendance = get_selected_attendance($attendanceid);
    if (mysqli_num_rows($selattendance)==0){
	$_SESSION["message"] = "Attendance not found.";
	redirect_to("attendance.php");
        }            
                while ($row= mysqli_fetch_assoc($selattendance)) {
		// Delete Query
                $query = "DELETE from tbl_attendance ";
                $query .= "WHERE attendanceid = '$attendanceid' LIMIT 1";
                $result = mysqli_query($connection, $query);
        
                if ($result && mysqli_affected_rows($connection) == 1) {
                 //success
                    $_SESSION["message"] .= "Attendance Deleted. ";
                    redirect_to("attendance.php");
            
             } else {
                //failure
                $_SESSION["message"] .= "Delete Attendance failed." . mysqli_error($connection);
                    redirect_to("attendance.php");
                }
            }
?>
    
