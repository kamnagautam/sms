<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation_functions.php"); $page_name="";?>
<?php confirm_admin_logged_in(); ?>

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

            // check unique entry for userid
            $table = "tbl_user";
            $column = "userid";
            $data = $userid ;
            $userid = check_unique($column, $table, $data);

        
       
            if (!empty($errors)) {
                $_SESSION["errors"] = $errors;
            } else {
                // Insert Query
            $query = "INSERT INTO tbl_user (";
            $query .= "userid, hashpassword, usertype, username, address, email, phone, course, remarks";
            $query .= ") values (";
            $query .= "'{$userid}', '{$hashpassword}', '{$usertype}', '{$username}', '{$address}', '{$email}','{$phone}', '{$course}', '{$remarks}'";
            $query .= ")";
            $result = mysqli_query($connection, $query);
        
            if ($result) {
                //success
                $_SESSION["message"] .= "User Added. ";
                $userid= "";
                $hashpassword= "";
                $usertype= "";
                $username= "";
                $address= "";
                $email= "";
                $phone= "";
                $course= "";
                $remarks= "";

                } else {
                    //failure
                    $_SESSION["message"] .= "Add User failed." . mysqli_error($connection);
                }
            }
    } else {
        // this is probably a get request
        $userid= "";
        $hashpassword= "";
        $usertype= "";
        $username= "";
        $address= "";
        $email= "";
        $phone= "";
        $course= "";
        $remarks= "";
        
    }
?>
    
<?php include("layout/header.php"); ?>

<!-- content area -->
        <div id="content">
            <div class="content text-center">
                <h3>Add Users</h3>
                 <hr>
                <?php echo message(); ?>
                <?php $errors = errors(); ?>
                <?php echo form_errors($errors); ?>
            </div>
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-6">
                    <form action="adduser.php" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label>User Id : </label>
                            <input class="form-control" type="text" required="required" name="userid" value="<?php echo htmlspecialchars($userid); ?>" />
                        </div>
                        <div class="form-group">
                            <label>Password : </label>
                        <input class="form-control" type="password" required="required" name="hashpassword" value="" />
                        </div>
                        <div class="form-group">
                        <label>User Type : </label>
                        <select class="form-control" name="usertype" id=""  required="required" >
                                <option value="admin" <?php if($usertype == 'admin'){ echo "selected";} ?> >Admin</option>
                                 <option value="attendant" <?php if($usertype == 'attendant'){ echo "selected";} ?> >Attendant</option>
                                <option value="student" <?php if($usertype == 'student'){ echo "selected";} ?> >Student</option>
                        </select><br>
                        </div>
                        <div class="form-group">
                        <label>User Name : </label>
                        <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" />
                        </div>
                        <div class="form-group">
                        <label>Email : </label>
                        <input class="form-control" type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" />
                        </div>
                        <div class="form-group">
                        <label>Address : </label>
                        <input class="form-control" type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" />
                        </div>
                        <div class="form-group">
                        <label>Phone : </label>
                        <input class="form-control" type="number" name="phone" value="<?php echo htmlspecialchars($phone); ?>" />
                        </div>
                        <div class="form-group">
                        <label>Course : </label>
                        <input class="form-control" type="text" name="course" value="<?php echo htmlspecialchars($course); ?>" />
                        </div>
                        <div class="form-group">
                        <div><label class="textarea">Remarks : </label>
                        <textarea class="form-control" rows="4" name="remarks" ><?php echo htmlspecialchars($remarks); ?></textarea></div>
                        </div>
                        <div class="text-center">
                            <input class="btn btn-default" type="submit" name="submit" value="Add User" />
                            <input class="btn btn-default" type="reset" name="reset" value="Reset" />
                        </div>

                    </form>
                </div>
                <div class="col-md-3">

                </div>

            </div>
            
            
            <hr>
		
		<!-- List Of Users -->    
            <div class="text-center">
                <h3>List Of Users</h3>
            </div>
            <?php
                // Fetching Groups list from query
                $user_set = get_all_users();
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
          

<!-- including the footer -->
<?php include("layout/footer.php"); ?>        