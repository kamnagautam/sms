<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); $page_name="";?>
<?php confirm_attendant_logged_in(); ?>

<?php

if (isset($_GET['viewatt'])) {
    // Process the form
    $attendancedate= mysql_prep($_GET['attendancedate']);
    $studentlist= get_all_students();
    $attendance = get_date_attendance($attendancedate);
    $student=array();
    while ($row= mysqli_fetch_assoc($studentlist))
    {
        $student[] = $row["userid"];
    }

    while ($row= mysqli_fetch_assoc($attendance))
    {
        $att_set[$row['userid']] = $row["attendance"];
    }

}

?>
    
<?php include("layout/header.php"); ?>

<!-- content area -->
        <div id="content">
            <div class="content text-center">
                <h3>Check Attendance</h3>
                 <hr>
                <?php echo message(); ?>
                <?php $errors = errors(); ?>
                <?php echo form_errors($errors); ?>
            </div>

            <div class="row">
                <div class="col-md-4">
                        <form class="" action="viewattendance.php" enctype="multipart/form-data" method="get">
                            <li class="list-group-item active text-center">Select Date</li>
                            <input class="form-control text-center" type="date" name="attendancedate" /><br>
                            <br><br><br><br><br><br><br><br><br><br><br><br>
                            <li class="list-group-item text-center">
                                <input class="btn btn-primary" type="submit" name="viewatt" value="View Attendance" />
                            </li>

                        </form>
                    </ul>
                </div>
                <div class="col-md-8">
                    <!-- List Of Attendance -->
                    <?php if (isset($_GET['viewatt'])) { ?>
                    <div class="text-center"><h4>Attendance - <?php echo $attendancedate; ?></h4></div>

                    <table class="table">
                        <tr>
                            <th>Student Id</th>
                            <th>Attendance</th>
                        </tr>
                        <tr>
                            <?php  // Fetching data from query
                            if (isset($_GET['viewatt'])) {
                                foreach ($student AS $s) {
                                    echo "<td>" . $s . "</td>";
                                    echo "<td>";
                                    if(isset($att_set[$s])){ echo $att_set[$s];}else{echo "No Records";}
                                    echo "</td></tr>";
                                }
                            }
                            ?>

                    </table>
                    <?php } ?>
                </div>

            </div>
            



        </div>
          

<!-- including the footer -->
<?php include("layout/footer.php"); ?>        