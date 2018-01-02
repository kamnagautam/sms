<?php require_once("includes/session.php");
      require_once("includes/db_connection.php");
      require_once("includes/functions.php");
      require_once("includes/validation_functions.php");
        confirm_admin_logged_in();

$page_name="";
$subpage_name="";
$message = "";

?>

<!-- including the header -->
<?php include("layout/header.php"); ?>
    <div class="row text-center">
        <h2>Admin Dashboard - <span><code><?php echo $_SESSION['sms_user_name']; ?> </code><a class="btn btn-default" href="logout.php">Log Out</a></span></h2>
    </div><br>

    <div class="row">
        <div class="col-md-4 text-center">
            <a class="btn btn-primary btn-large" href="adduser.php">Add Users</a>
        </div>
        <div class="col-md-4 text-center">
            <a class="btn btn-primary btn-large" href="markattendance.php">View / Mark Attendance</a>
        </div>
        <div class="col-md-4 text-center">
            <a class="btn btn-primary btn-large" href="booking.php">Book Studio</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <!-- List Of Admins -->
        <div class="col-md-12 text-center"><h3>Administrators</h3></div>
        <?php
        // Fetching Groups list from query
        $admin_set = get_all_admins();
        ?>
        <table class="table">
            <tr>
                <th>User Id</th>
                <th>User Type</th>
                <th>User Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Remarks</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <tr>
                <?php  // Fetching data from query

                while ($row= mysqli_fetch_assoc($admin_set))
                {
                    echo "<td>". $row["userid"]."</td>" ;
                    echo "<td>". $row["usertype"]."</td>" ;
                    echo "<td>". $row["username"]."</td>" ;
                    echo "<td>". $row["address"]."</td>";
                    echo "<td>". $row["email"]."</td>" ;
                    echo "<td>". $row["phone"]."</td>" ;
                    echo "<td>". $row["course"]."</td>" ;
                    echo "<td>". $row["remarks"]."</td>" ;
                    echo "<td><a href=\"edituser.php?userid=".$row["userid"]."\">Edit</a></td>";
                    echo "<td><a href=\"deleteuser.php?userid=".$row["userid"]."\" onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a></td></tr>" ;
                }
                ?>

        </table>

    </div>

<hr>

    <div class="row">
        <!-- List Of Attendants -->
        <div class="col-md-12 text-center"><h3>Attendants</h3></div>
        <?php
        // Fetching Groups list from query
        $user_set = get_all_attendants();
        ?>
        <table class="table">
            <tr>
                <th>User Id</th>
                <th>User Type</th>
                <th>User Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Remarks</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <tr>
                <?php  // Fetching data from query

                while ($row= mysqli_fetch_assoc($user_set))
                {
                    echo "<td>". $row["userid"]."</td>" ;
                    echo "<td>". $row["usertype"]."</td>" ;
                    echo "<td>". $row["username"]."</td>" ;
                    echo "<td>". $row["address"]."</td>";
                    echo "<td>". $row["email"]."</td>" ;
                    echo "<td>". $row["phone"]."</td>" ;
                    echo "<td>". $row["course"]."</td>" ;
                    echo "<td>". $row["remarks"]."</td>" ;
                    echo "<td><a href=\"edituser.php?userid=".$row["userid"]."\">Edit</a></td>";
                    echo "<td><a href=\"deleteuser.php?userid=".$row["userid"]."\" onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a></td></tr>" ;
                }
                ?>

        </table>

    </div>
<hr>

    <div class="row">
        <!-- List Of Students -->
        <div class="col-md-12 text-center"><h3>Students</h3></div>
        <?php
        // Fetching Groups list from query
        $user_set = get_all_students();
        ?>
        <table class="table">
            <tr>
                <th>User Id</th>
                <th>User Type</th>
                <th>User Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Remarks</th>
                <th>Send Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <tr>
                <?php  // Fetching data from query

                while ($row= mysqli_fetch_assoc($user_set))
                {
                    echo "<td>". $row["userid"]."</td>" ;
                    echo "<td>". $row["usertype"]."</td>" ;
                    echo "<td>". $row["username"]."</td>" ;
                    echo "<td>". $row["address"]."</td>";
                    echo "<td>". $row["email"]."</td>" ;
                    echo "<td>". $row["phone"]."</td>" ;
                    echo "<td>". $row["course"]."</td>" ;
                    echo "<td>". $row["remarks"]."</td>" ;
                    echo"<td><a class=\"btn btn-default\" href=\"mailto:".$row["email"]."?Subject=Email From Administrator\" target=\"_top\">Send Mail</a></td>";
                    echo "<td><a href=\"edituser.php?userid=".$row["userid"]."\">Edit</a></td>";
                    echo "<td><a href=\"deleteuser.php?userid=".$row["userid"]."\" onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a></td></tr>" ;
                }
                ?>

        </table>

    </div>

        



    <!-- including the footer -->
<?php include("layout/footer.php"); ?>