<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); $page_name="";?>
<?php confirm_attendant_logged_in(); ?>

<?php
$today = date('Y-m-d');

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
        $att_id[$row['userid']] = $row["attendanceid"];

    }

}


if (isset($_POST['submit'])) {

    for($i=0;$i<count($_POST['userid']);$i++) {
        // insert query if attendance is not available
        if($_POST['attendanceid'][$i]==""){
            $table = "tbl_attendance";
            $column1 = "userid";
            $column2 = "attendancedate";
            $data1 = $_POST['userid'][$i];
            $data2 = $_POST['attendancedate'][$i];
            $userid = check_unique_2column($column1, $column2, $table, $data1, $data2);

            check_attendance_value($_POST['attendance'][$i]);

            if (!empty($errors)) {
                $_SESSION["errors"] = $errors;
            } else {
                $query = "INSERT INTO tbl_attendance (";
                $query .= "attendanceid, attendancedate, userid, attendance";
                $query .= ") values (";
                $query .= "DEFAULT, '{$_POST['attendancedate'][$i]}' ,'{$_POST['userid'][$i]}', '{$_POST['attendance'][$i]}'";
                $query .= ")";
                $result = mysqli_query($connection, $query);

                if ($result)  {
                    //success
                    $_SESSION["message"] .= "Attendance Marked. ";
                } else {
                    //failure
                    $_SESSION["message"] .= "Add User failed." . mysqli_error($connection);
                }
            }
        }else if($_POST['attendanceid'][$i]<>""){
        // update query if attendance is not available

            check_attendance_value($_POST['attendance'][$i]);
            if (!empty($errors)) {
                $_SESSION["errors"] = $errors;
            } else {
                $query = "UPDATE tbl_attendance SET ";
                $query .= "attendance= '{$_POST['attendance'][$i]}' ";
                $query .= "WHERE attendancedate='{$_POST['attendancedate'][$i]}' AND userid='{$_POST['userid'][$i]}'";
                $result = mysqli_query($connection, $query);

                if ($result && mysqli_affected_rows($connection) == 1) {
                    //success
                    $_SESSION["message"] .= "Attendance Updated. ";

                } else {
                    //failure
                    $_SESSION["message"] .= "" . mysqli_error($connection);
                }

            }

        }
    }

}



?>
    
<?php include("layout/header.php"); ?>

<!-- content area -->
        <div id="content">
            <div class="content text-center">
                <h3>Mark Attendance</h3>
                 <hr>
                <?php echo message(); ?>
                <?php $errors = errors(); ?>
                <?php echo form_errors($errors); ?>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">
                        <form class="" action="markattendance.php" enctype="multipart/form-data" method="get">
                            <li class="list-group-item active text-center">Select Date</li>
                            <input class="form-control text-center" type="date" name="attendancedate" <?php if($_SESSION['sms_user_type']=='attendant'){echo "max=\"$today\" min=\"$today\"";} ?> /><br>
                            <br><br><br><br><br><br><br><br><br><br><br><br>
                            <li class="list-group-item text-center">
                                <input class="btn btn-primary" type="submit" name="viewatt" value="Select" />
                            </li>

                        </form>
                    </ul>
                </div>
                <div class="col-md-8">
                    <!-- List Of Attendance -->
                    <?php if (isset($_GET['viewatt'])) { ?>
                    <div class="text-center"><h4>Attendance - <?php echo $attendancedate; ?></h4></div>
                    <form class="dataentry" action="markattendance.php" enctype="multipart/form-data" method="post">
                    <table class="table text-center">
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Student Id</th>
                            <th class="text-center">Attendance - Enter P or A</th>
                        </tr>
                        <tr>
                            <?php  // Fetching data from query
                            if (isset($_GET['viewatt'])) {
                                foreach ($student AS $s) {

                                    echo "<input type=\"hidden\" name=\"attendanceid[]\" value=\"";
                                    if(isset($att_id[$s])){echo $att_id[$s];}
                                    echo "\" />";
                                    echo "<td><input class=\"form-control\" type=\"text\" required=\"required\" name=\"attendancedate[]\" value=\"". $attendancedate ."\" /></td>";
                                    echo "<td><input class=\"form-control\" type=\"text\" required=\"required\" name=\"userid[]\" value=\"". $s ."\" /></td>";
                                    echo "<td>";
                                    echo "<input list=\"att\" class=\"form-control\" type=\"text\" required=\"required\" name=\"attendance[]\" value=\"";
                                    if(isset($att_set[$s])&&($att_set[$s])=='P'){ echo "P";}
                                    else if(isset($att_set[$s])&&($att_set[$s])=='A'){ echo "A";}
                                    else { echo "";}
                                    echo "\" /></td>";
                                    ?>

                                    <?php
                                    echo "</tr>";
                                }
                            }
                            ?>



                    </table>
                        <div class="text-center"><input class="btn btn-default text-center" type="submit" name="submit" value="Mark Attendance" /></div>
                        <datalist id="att">
                            <option value="P">
                            <option value="A">
                        </datalist>
                        </form>
                    <?php } ?>
                </div>

            </div>
            



        </div>
          

<!-- including the footer -->
<?php include("layout/footer.php"); ?>        