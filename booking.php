<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); $page_name="";?>
<?php confirm_attendant_logged_in(); ?>

<?php

    if (isset($_POST['submit'])) {
        // Process the form
        //Values from $_POST
        $userid= mysql_prep($_POST['userid']);
        $rawdate = htmlentities($_POST['bookingdate']);
        $bookingdate = date('Y-m-d', strtotime($rawdate));
        //if user is admin enter adminstatus
        if ($_SESSION['sms_user_type']=='admin') {
            $adminstatus= mysql_prep($_POST['adminstatus']);
        } else {
            $adminstatus="";
        }
        $remarks= mysql_prep($_POST['remarks']);
        
        
        
        //Validations
        $fields_required = array("userid", "bookingdate");
        validate_presences($fields_required);
        
        $fields_with_max_lengths = array("userid" => 50);
        validate_max_lengths($fields_with_max_lengths);
        
        
        $table = "tbl_booking";
        $column = "bookingdate";
        $data = $bookingdate ;
        $bookingdate = check_2_bookings($column, $table, $data);
	
        
       
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
        } else {   
            // Insert Query
        $query = "INSERT INTO tbl_booking (";
        $query .= "bookingid, bookingdate, userid, adminstatus, remarks";
        $query .= ") values (";
        $query .= " DEFAULT, '{$bookingdate}', '{$userid}', '{$adminstatus}', '{$remarks}'";
        $query .= ")";
        $result = mysqli_query($connection, $query);
        
        if ($result) {
            //success
            $_SESSION["message"] .= "Booking Added. ";
            $bookingdate= "";
            $userid= "";
            $adminstatus= "";
            $remarks= "";
            
        } else {
            //failure
            $_SESSION["message"] .= "Add Booking failed." . mysqli_error($connection);
        }
        }
    } else {
        // this is probably a get request
        $bookingdate= "";
        $userid= "";
        $adminstatus= "";
        $remarks= "";
        
    }
?>
    
<?php include("layout/header.php"); ?>

<!-- content area -->

            <div class="content text-center">
                <h3>Book Studio</h3>
                 <hr>
                <?php echo message(); ?>
                <?php $errors = errors(); ?>
                <?php echo form_errors($errors); ?>
            </div>
            
            <div class="row text-center">
                <div class="col-md-3">

                </div>
                <div class="col-md-6">
                <form class="form-vertical" action="booking.php" enctype="multipart/form-data" method="post">
                    <label>User Id : </label>
                    <select class="form-control" type="text" required="required" name="userid">
                        <?php  // Fetching data from query
                        $student_set = get_all_students();
                        while ($row= mysqli_fetch_assoc($student_set))
                        {
                            echo "<option value=\"" .$row["userid"]. "\" ";
                            //if (isset($_GET['catid'])) { $categoryid= (int) $_GET['catid'];}
                            if ($userid==$row["userid"]) { echo "selected"; }
                            echo ">".$row["userid"]."</option>" ;
                        }
                        ?>
                    </select>
                    <label>Booking Date : </label>
                    <input class="form-control" type="date" min="2017-12-10" name="bookingdate" required="required" value="<?php echo htmlspecialchars($bookingdate); ?>" />
                    <?php if ($_SESSION['sms_user_type'] == 'admin'){ ?>
                    <label>Admin Approval : </label>
                    <select class="form-control" name="adminstatus" id="" >
                        <option value=""></option>
                        <option value="accept">Accepted</option>
                        <option value="reject">Rejected</option>
                    </select>
                    <?php } ?>

                    <div><label class="textarea">Remarks : </label>
                    <textarea class="form-control" rows="4" name="remarks" ><?php echo htmlspecialchars($remarks); ?></textarea></div><br>
		            <input class="btn btn-default" type="submit" name="submit" value="Add Booking" />
                    <input class="btn btn-default" type="reset" name="reset" value="Reset" />
                    
                </form>
            </div>
                <div class="col-md-3">

                </div>
        </div>
            
            
            <hr>
		
		<!-- List Of Bookings -->
                <div class="text-center"><h3>Bookings</h3></div>
            <?php
            // Fetching Groups list from query
            $booking_set = get_all_bookings();
            ?>
            <table class="table">
                <tr>
                    <th>Booking Id</th>
                    <th>Booking Date</th>
                    <th>User Id</th>
                    <th>Admin Approval</th>
		            <th>Remarks</th>
                    <?php if($_SESSION['sms_user_type']=='admin'){echo "<th>Edit</th><th>Delete</th>";} ?>

                </tr>
                <tr>
                    <?php  // Fetching data from query

                    while ($row= mysqli_fetch_assoc($booking_set)) {
                        echo "<td>" . $row["bookingid"] . "</td>";
                        echo "<td>" . $row["bookingdate"] . "</td>";
                        echo "<td>" . $row["userid"] . "</td>";
                        echo "<td>" . $row["adminstatus"] . "</td>";
                        echo "<td>" . $row["remarks"] . "</td>";
                        if ($_SESSION['sms_user_type'] == 'admin') {
                            echo "<td><a href=\"editbooking.php?bookingid=" . $row["bookingid"] . "\">Edit</a></td>";
                            echo "<td><a href=\"deletebooking.php?bookingid=" . $row["bookingid"] . "\" onclick=\"return confirm('Are you sure you want to delete this booking?');\">Delete</a></td>";
                        }
                        echo "</tr>";
                    }
                    ?>    
                    
            </table>
            
                

          

<!-- including the footer -->
<?php include("layout/footer.php"); ?>        