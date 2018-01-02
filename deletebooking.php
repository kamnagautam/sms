<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
        $bookingid = $_GET['bookingid'];
	$selbooking = get_selected_booking($bookingid);
    if (mysqli_num_rows($selbooking)==0){
	$_SESSION["message"] = "Booking not found.";
	redirect_to("booking.php");
        }            
                while ($row= mysqli_fetch_assoc($selbooking)) {
		// Delete Query
                $query = "DELETE from tbl_booking ";
                $query .= "WHERE bookingid = '$bookingid' LIMIT 1";
                $result = mysqli_query($connection, $query);
        
                if ($result && mysqli_affected_rows($connection) == 1) {
                 //success
                    $_SESSION["message"] .= "Booking Deleted. ";
                    redirect_to("booking.php");
            
             } else {
                //failure
                $_SESSION["message"] .= "Delete Booking failed." . mysqli_error($connection);
                    redirect_to("booking.php");
                }
            }
?>
    
