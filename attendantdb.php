<?php require_once("includes/session.php");
      require_once("includes/db_connection.php");
      require_once("includes/functions.php");
      require_once("includes/validation_functions.php");
       confirm_attendant_logged_in();

$page_name="";
$subpage_name="";
$message = "";

?>

<!-- including the header -->
<?php include("layout/header.php"); ?>
        <div class="row text-center">
            <h2>Attendant Dashboard - <span><code><?php echo $_SESSION['sms_user_name']; ?> </code><a class="btn btn-default" href="logout.php">Log Out</a></span></h2>
        </div><br>

        <div class="row">
            <div class="col-md-4 text-center">
                <a class="btn btn-primary btn-large" href="viewattendance.php">View Attendance</a>
            </div>
            <div class="col-md-4 text-center">
                <a class="btn btn-primary btn-large" href="markattendance.php">Mark Attendance</a>

            </div>
            <div class="col-md-4 text-center">
                <a class="btn btn-primary btn-large" href="booking.php">Book Studio</a>

            </div>
        </div>
        



    <!-- including the footer -->
<?php include("layout/footer.php"); ?>