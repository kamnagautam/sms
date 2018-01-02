<?php
//functions
$errors = array();

function confirm_query($result_set) {
    if (!$result_set) {
        die("Database query failed.");
    }
}

// Redirect function
function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit;
}


// Escape Strings
function mysql_prep($string) {
    global $connection;
    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

// Form Errors
function form_errors($errors=array()) {
        $output = "";
        if (!empty($errors)) {
            $output .= "<div class=\"error\">";
            $output .= "<p>Please fix the following errors:</p>";
            $output .= "<ul>";
            foreach ($errors as $key => $error) {
                $output .= "<li>{$error}</li>";
            }
            $output .= "</ul>";
            $output .= "</div>";
        }
        return $output;
    }

    // Password Encryption Functions
    
    function password_encrypt($password) {
	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	$salt_length = 22;          // Blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
    }
    
    function generate_salt($length) {
	// Not 100% unique, not 100% random, but good enough for salt
	// MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));
	
	// Valid characters for a salt are [a-zA-Z0-9./]
	$base_64string = base64_encode($unique_random_string);
	
	// But not '+' which is valid in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base_64string);
	
	// Truncate string to the correct length
	$salt = substr($modified_base64_string, 0, $length);
	
	return $salt;
    }
    
    
    function password_check($password, $existing_hash){
      // existing hash contains format and salt at start
      $hash = crypt($password, $existing_hash);
      if ($hash === $existing_hash) {
	return true;
      } else {
	return false;
      }
    }

// Attempt Login Function
function attempt_login($userid, $password) {
    $user = get_login_user($userid);

    if ($user) {
        // found user, now check password
        if (password_check($password, $user["hashpassword"])) {
            // password matches

            return $user;
        } else {
            //Password doesn't match
            return false;
        }
    } else {
        // user not found
        return false;
    }
}

// login confirmation on entering the page
function confirm_student_logged_in() {
    if(!isset($_SESSION['sms_user_id']) || !isset($_SESSION['sms_user_name']) || !isset($_SESSION['sms_user_type']) || (($_SESSION['sms_user_type'] <> 'student') && ($_SESSION['sms_user_type'] <> 'attendant') && ($_SESSION['sms_user_type'] <> 'admin'))) {
        redirect_to("index.php");
        $_SESSION['message'] = "You are not authorised.";
    }
}

function confirm_attendant_logged_in() {
    if(!isset($_SESSION['sms_user_id']) || !isset($_SESSION['sms_user_name']) || !isset($_SESSION['sms_user_type']) || (($_SESSION['sms_user_type']) <> 'attendant' && ($_SESSION['sms_user_type']) <> 'admin')) {
        redirect_to("index.php");
        $_SESSION['message'] = "You are not authorised.";
    }
}

function confirm_admin_logged_in() {
    if(!isset($_SESSION['sms_user_id']) || !isset($_SESSION['sms_user_name']) || !isset($_SESSION['sms_user_type']) || (($_SESSION['sms_user_type']) <> 'admin')) {
        redirect_to("index.php");
        $_SESSION['message'] = "You are not authorised.";

    }
}

function redirect_if_logged_in() {
    if (isset($_SESSION["sms_user_type"])) {
        if (($_SESSION["sms_user_type"]) == 'admin') {
            redirect_to("admindb.php");
        }
        elseif (($_SESSION["sms_user_type"]) == 'attendant') {
            redirect_to("attendantdb.php");
        }
        elseif (($_SESSION["sms_user_type"]) == 'student') {
            redirect_to("studentdb.php");
        }
    }


}

// get login user
function get_login_user($userid) {
    // Executing Query ...
    global $connection;
    $safe_userid = mysqli_real_escape_string($connection, $userid);
    $query = "SELECT * FROM tbl_user WHERE userid='{$safe_userid}' LIMIT 1" ;
    $seluser = mysqli_query($connection, $query);
    confirm_query($seluser);
    if($user = mysqli_fetch_assoc($seluser)){
        return $user;
    } else {
        return null;
    }
}

// get all users
function get_all_users() {
    // Executing Query ...
    global $connection;
    $query = "SELECT * FROM tbl_user ORDER BY usertype" ;
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    return $user_set;
}

// get selected user
function get_selected_user($userid) {
    // Executing Query ...
    global $connection;
    $safe_userid = mysqli_real_escape_string($connection, $userid);
    $query = "SELECT * FROM tbl_user WHERE userid='$safe_userid' LIMIT 1" ;
    $seluser = mysqli_query($connection, $query);
    confirm_query($seluser);
    return $seluser;
}

// get selected booking
function get_selected_booking($bookingid) {
    // Executing Query ...
    global $connection;
    $safe_bookingid = mysqli_real_escape_string($connection, $bookingid);
    $query = "SELECT * FROM tbl_booking WHERE bookingid='$safe_bookingid' LIMIT 1" ;
    $selbooking = mysqli_query($connection, $query);
    confirm_query($selbooking);
    return $selbooking;
}


// get selected attendance
function get_selected_attendance($attendanceid) {
    // Executing Query ...
    global $connection;
    $safe_attendanceid = mysqli_real_escape_string($connection, $attendanceid);
    $query = "SELECT * FROM tbl_attendance WHERE attendanceid='$safe_attendanceid' LIMIT 1" ;
    $selattendance = mysqli_query($connection, $query);
    confirm_query($selattendance);
    return $selattendance;
}



    //  get all students
function get_all_students() {
    // Executing Query ...
        global $connection;
	    $query = "SELECT * FROM tbl_user WHERE usertype='student' " ;
	    $student_set = mysqli_query($connection, $query);
	    confirm_query($student_set);
        return $student_set;
}


//  get all attendants
function get_all_attendants() {
    // Executing Query ...
    global $connection;
    $query = "SELECT * FROM tbl_user WHERE usertype='attendant' " ;
    $attendant_set = mysqli_query($connection, $query);
    confirm_query($attendant_set);
    return $attendant_set;
}


//  get all admins
function get_all_admins() {
    // Executing Query ...
    global $connection;
    $query = "SELECT * FROM tbl_user WHERE usertype='admin' " ;
    $admin_set = mysqli_query($connection, $query);
    confirm_query($admin_set);
    return $admin_set;
}


// get all attendance
function get_all_attendance() {
    global $connection;
    $query = "SELECT * FROM tbl_attendance" ;
    $attendance_set = mysqli_query($connection, $query);
    confirm_query($attendance_set);
    return $attendance_set;
}



// get attendance for particular student/user
function get_student_attendance($userid) {
    global $connection;
    $query = "SELECT * FROM tbl_attendance WHERE userid='$userid'" ;
    $attendance_set = mysqli_query($connection, $query);
    confirm_query($attendance_set);
    return $attendance_set;

}


// get attendance for particular date
function get_date_attendance($date) {
    global $connection;
    $query = "SELECT * FROM tbl_attendance WHERE attendancedate='$date'" ;
    $attendance_set = mysqli_query($connection, $query);
    confirm_query($attendance_set);
    return $attendance_set;

}


// get attendance for particular student and date
function get_student_attendance_for_date($userid, $date) {
    global $connection;
    $query = "SELECT * FROM tbl_attendance WHERE userid='$userid' AND attendancedate='$date'" ;
    $attendance_set = mysqli_query($connection, $query);
    confirm_query($attendance_set);
    return $attendance_set;

}




// get all bookings
function get_all_bookings() {
    global $connection;
    $query = "SELECT * FROM tbl_booking" ;
    $booking_set = mysqli_query($connection, $query);
    confirm_query($booking_set);
    return $booking_set;
}



// get bookings for selected student/user
function get_student_bookings($userid) {
    global $connection;
    $query = "SELECT * FROM tbl_booking WHERE userid='$userid'" ;
    $booking_set = mysqli_query($connection, $query);
    confirm_query($booking_set);
    return $booking_set;
}



// get bookings for selected date
function get_date_bookings($date) {
    global $connection;
    $query = "SELECT * FROM tbl_booking WHERE bookingdate='$date'" ;
    $booking_set = mysqli_query($connection, $query);
    confirm_query($booking_set);
    return $booking_set;
}







?>