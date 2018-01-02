<?php require_once("includes/session.php");
      require_once("includes/db_connection.php");
      require_once("includes/functions.php");
      require_once("includes/validation_functions.php");
      redirect_if_logged_in(); 

$page_name="";
$subpage_name="";
$message = "";

if (isset($_POST['submit'])) {
    //form was submitted
    $userid = $_POST["UserId"];
    $password = $_POST["Password"];

    $fields_required = array("UserId", "Password");
    validate_presences($fields_required);

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;

    } else {
        // Attempt Login
        $found_user = attempt_login($userid, $password);
        //echo var_dump($found_user);
        if ($found_user) {

            // Success
            // Mark User as logged in
            $_SESSION["sms_user_id"] = $found_user["userid"];
            $_SESSION["sms_user_name"] = $found_user["username"];
            $_SESSION["sms_user_type"] = $found_user["usertype"];
            redirect_if_logged_in();
        } else {
            // Failure
            $_SESSION["message"] = "UserId/Password not found.";
        }

    }
}else {
    $userid="";
    $message = "Please log in.";
}

?>

<!-- including the header -->
<?php include("layout/header.php"); ?>


        <div class="row text-center">
            <h3>Log In - Student Management System</h3>
            <hr>
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo form_errors($errors); ?>
        </div>
        
            <div class="row text-center">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <form class="form-vertical" action="index.php" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label>User Id : </label>
                        <input name="UserId" type="text" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <label>Password : </label>
                        <input name="Password" type="password" class="form-control" placeholder="Password"/>
                    <div><br><br>

                        <div class="text-center">
                            <input class="btn btn-default" type="submit" name="submit" value="Log In" />
                            <input class="btn btn-default" type="reset" name="reset" value="Reset" />

                        </div>


                </form>
            </div>
            <div class="col-md-3">

            </div>
        </div>










    <!-- including the footer -->
<?php include("layout/footer.php"); ?>