<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); $page_name="";?>
<?php
    confirm_student_logged_in();
    if($_SESSION['sms_user_type']== 'attendant'){
        header("location: attendantdb.php");
    } else if($_SESSION['sms_user_type']== 'admin'){
        $viewmode= 'admin';
    } else if($_SESSION['sms_user_type']== 'student'){
        $viewmode= 'student';
    }

?>

<?php

    if (isset($_POST['submit'])) {
        // Process the form


        //Values from $_POST
        $userid= mysql_prep($_POST['userid']);
        $hashpassword= password_encrypt($_POST['hashpassword']);
        $usertype= mysql_prep($_POST['usertype']);
        $username= mysql_prep($_POST['username']);
        $address= mysql_prep($_POST['address']);
        $email= mysql_prep($_POST['email']);
        $phone= mysql_prep($_POST['phone']);
        $course= mysql_prep($_POST['course']);
        $remarks= mysql_prep($_POST['remarks']);
        
        
        
        //Validations
        $fields_required = array("userid", "hashpassword","usertype", "username", "email");
        validate_presences($fields_required);
        
        $fields_with_max_lengths = array("userid" => 50, "username" => 50, "hashpassword" => 100, "usertype" => 90, "email" => 50);
        validate_max_lengths($fields_with_max_lengths);





        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
        } else {
            // Update Query
            $query = "UPDATE tbl_user SET ";
            $query .= "hashpassword= '{$hashpassword}', ";
            $query .= "usertype= '{$usertype}', ";
            $query .= "username= '{$username}', ";
            $query .= "address= '{$address}', ";
            $query .= "email= '{$email}', ";
            $query .= "phone= '{$phone}', ";
            $query .= "course= '{$course}' ";
            $query .= "WHERE userid='{$userid}'";
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_affected_rows($connection) == 1) {
                //success
                $_SESSION["message"] .= "User Updated. ";
                header("location: admindb.php");
                exit();

            } else {
                //failure
                $_SESSION["message"] .= "Update User failed." . mysqli_error($connection);
            }

        }
    } else {
        // this is probably a get request
        if($_SESSION['sms_user_type']=='student'){$userid = $_SESSION['sms_user_id'];}else{$userid = $_GET['userid'];}
        $sel_user = get_selected_user($userid);
        if (mysqli_num_rows($sel_user)==0){
            $_SESSION["message"] = "User not found.";
            header("location: admindb.php");
            exit();
        } else {
            while ($row= mysqli_fetch_assoc($sel_user)) {
                $hashpassword= "";
                $usertype= $row['usertype'];
                $username= $row['username'];
                $address= $row['address'];
                $email= $row['email'];
                $phone= $row['phone'];
                $course= $row['course'];;
                $remarks= $row['remarks'];
            }
        }
        // this is probably a get request

        
    }
?>
    
<?php include("layout/header.php"); ?>

<!-- content area -->
        <div id="content">
            <div class="content text-center">
                <h3>Update Profile</h3>
                 <hr>
                <?php echo message(); ?>
                <?php $errors = errors(); ?>
                <?php echo form_errors($errors); ?>
            </div>
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-6">

                <form class="form-vertical" action="edituser.php" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label>User Id : </label>
                        <input type="text" class="form-control" required="required" readonly name="userid" value="<?php echo htmlspecialchars($userid); ?>" />
                    </div>
                    <div class="form-group">
                        <label>Password : </label>
                    <input type="password" class="form-control" required="required" name="hashpassword" value="" />
                    </div>
                    <div class="form-group">
                    <label>User Type : </label>
                    <select name="usertype" class="form-control" id="" <?php if($_SESSION['sms_user_type']=='student'){echo "readonly";} ?> required="required" >
                            <option value="admin" <?php if($usertype == 'admin'){ echo "selected";} ?> >Admin</option>
                             <option value="attendant" <?php if($usertype == 'attendant'){ echo "selected";} ?> >Attendant</option>
			                <option value="student" <?php if($usertype == 'student'){ echo "selected";} ?> >Student</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label>User Name : </label>
                    <input type="text" class="form-control" name="username" <?php if($_SESSION['sms_user_type']=='student'){echo "readonly";} ?> value="<?php echo htmlspecialchars($username); ?>" />
                    </div>
                    <div class="form-group">
                    <label>Email : </label>
                    <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" />
                    </div>
                    <div class="form-group">
                    <label>Address : </label>
                    <input type="text" class="form-control" name="address" <?php if($_SESSION['sms_user_type']=='student'){echo "readonly";} ?> value="<?php echo htmlspecialchars($address); ?>" />
                    </div>
                    <div class="form-group">
                    <label>Phone : </label>
                    <input type="number" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>" />
                    </div>
                    <div class="form-group">
                    <label>Course : </label>
                    <input type="text" class="form-control" name="course" <?php if($_SESSION['sms_user_type']=='student'){echo "readonly";} ?> value="<?php echo htmlspecialchars($course); ?>" />
                    </div>
                    <div class="form-group">
                    <div><label class="textarea">Remarks : </label>
                    <textarea rows="4" class="form-control" name="remarks" <?php if($_SESSION['sms_user_type']=='student'){echo "readonly";} ?> ><?php echo htmlspecialchars($remarks); ?></textarea></div>
                    </div>
		            <input type="submit" class="btn btn-default" name="submit" value="Update" />
                    <input type="reset" class="btn btn-default" name="reset" value="Reset" />
                    
                </form>
                </div>

                <div class="col-md-3">

                </div>
            </div>
		

            
                
        </div>
          

<!-- including the footer -->
<?php include("layout/footer.php"); ?>        