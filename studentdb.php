<?php require_once("includes/session.php");
      require_once("includes/db_connection.php");
      require_once("includes/functions.php");
      require_once("includes/validation_functions.php");
       confirm_student_logged_in();

$page_name="";
$subpage_name="";
$message = "";

$student_set = get_selected_user($_SESSION['sms_user_id']);

while ($row= mysqli_fetch_assoc($student_set))
{
    $userid   = $row["userid"];
    $username = $row["username"];
    $usertype = $row["usertype"];
    $email = $row["email"];
    $address = $row["address"];
    $phone = $row["phone"];
    $course = $row["course"];
}


$booking_set = get_student_bookings($_SESSION['sms_user_id']);
$bookingdate = array();
while ($row= mysqli_fetch_assoc($booking_set))
{
    $bookingdate[] = $row["bookingdate"];
}

$today = date('Y-m-d');

if (isset($_GET['viewatt'])) {
    // Process the form
    $attendancedate= mysql_prep($_GET['attendancedate']);

    $attendance = get_student_attendance_for_date($userid,$attendancedate);

    while ($row= mysqli_fetch_assoc($attendance))
    {
        $att_status = $row["attendance"];
    }

    if (!isset($att_status)){
        $att_status = 'Not Available';
    }
}


if (isset($_GET['bookdate'])) {
    // Process the form
    $bookingseldate= mysql_prep($_GET['bookingdate']);

    $table = "tbl_booking";
    $column = "bookingdate";
    $data = $bookingseldate ;
    $bookingseldate = check_2_bookings($column, $table, $data);



    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
    } else {
        // Insert Query
        $query = "INSERT INTO tbl_booking (";
        $query .= "bookingid, bookingdate, userid";
        $query .= ") values (";
        $query .= " DEFAULT, '{$bookingseldate}', '{$userid}'";
        $query .= ")";
        $result = mysqli_query($connection, $query);

        if ($result) {
            //success
            $_SESSION["message"] .= "Booking Added. ";
            $bookingseldate= "";
        } else {
            //failure
            $_SESSION["message"] .= "Add Booking failed." . mysqli_error($connection);
        }
    }
}



?>

<!-- including the header -->
<?php include("layout/header.php"); ?>

    <div class="content text-center">
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo form_errors($errors); ?>
    </div>

    <div class="row text-center">
        <h2>Student Dashboard - <span><code><?php echo $username; ?> </code><a class="btn btn-default" href="logout.php">Log Out</a></span></h2>
    </div><br>

    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item active text-center">Profile</li>
                <li class="list-group-item"><?php echo $userid; ?></li>
                <li class="list-group-item"><?php echo $username; ?></li>
                <li class="list-group-item"><?php echo $usertype; ?></li>
                <li class="list-group-item"><?php echo $email; ?></li>
                <li class="list-group-item"><?php echo $address; ?></li>
                <li class="list-group-item"><?php echo $phone; ?></li>
                <li class="list-group-item"><?php echo $course; ?></li>
                <li class="list-group-item text-center"><a class="btn btn-primary" href="edituser.php?userid=<?php echo "$userid"; ?>">Edit Profile</a></li>
            </ul>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-3">
            <ul class="list-group">
            <form class="" action="studentdb.php" enctype="multipart/form-data" method="get">
                <li class="list-group-item active text-center">Check Attendance</li>
                <input class="form-control text-center" type="date" max="<?php echo $today; ?>" name="attendancedate" /><br>
                <br><br><br><br><br><br><br><br><br><br><br><br>
                <li class="list-group-item text-center">
                    <input class="btn btn-primary" type="submit" name="viewatt" value="View Attendance" />
                </li>
                <?php if(isset($_GET['viewatt'])){ ?>
                <li class="list-group-item active text-center"><?php echo $attendancedate; ?></li>
                <li class="list-group-item text-center"><?php echo $att_status; ?></li>
                <?php } ?>
            </form>
            </ul>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-3">
            <ul class="list-group">
                <form class="" action="studentdb.php" enctype="multipart/form-data" method="get">
                    <li class="list-group-item active text-center">Book Studio</li>
                    <input class="form-control text-center" type="date" min="<?php echo $today; ?>" name="bookingdate" required="required"/><br>
                    <br><br><br><br><br><br><br><br><br><br><br><br>
                    <li class="list-group-item text-center">
                        <input class="btn btn-primary" type="submit" name="bookdate" value="Book Studio" />
                    </li>


                        <li class="list-group-item active text-center">Your Bookings</li>
                    <?php
                        foreach($bookingdate as $date){
                            echo "<li class=\"list-group-item text-center\">".$date."</li>";
                        }
                    ?>
                </form>
            </ul>
        </div>

    </div>


    <script type="javascript">
        $('#datepicker').datepicker({
            format: 'yyyy/mm/dd',
            startDate: '-3d'
        });
    </script>


    <!-- including the footer -->
<?php include("layout/footer.php"); ?>