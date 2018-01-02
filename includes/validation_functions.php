<?php

$errors = array();

// * Presence
    function has_presence($value) {
       return isset($value) && $value !== "";
    }
    
    function validate_presences($fields_required) {
      global $errors;
      foreach($fields_required as $field) {
         $value = trim($_POST[$field]);
         if (!has_presence($value)) {
            $errors[$field] = ucfirst($field) . " can't be blank.";
         }
      }
    }
    
// * string length
// max length
function has_max_length($value,$max) {
    return strlen($value) <= $max;
    }
    
function validate_max_lengths($fields_with_max_lengths) {
    global $errors;
    //Expects an assoc. array
    foreach($fields_with_max_lengths as $field => $max) {
      $value = trim($_POST[$field]);
      if (!has_max_length($value, $max)) {
         $errors[$field] = ucfirst($field) . " is too long." ;
      }
    }
}


//* data type integer
function has_integer($value) {
   return is_int($value);
}

function validate_integers($fields_with_integers) {
    global $errors;
    //Expects an assoc. array
    foreach($fields_with_integers as $field) {
      $value = trim($_POST[$field]);
      if (!has_integer($value)) {
            $errors[$field] = ucfirst($field) . " should be integer.";
         }
    }
}


//* data type tinyint
function has_tinyint($value) {
   $tinyvalues = array(0,1);
   return has_inclusion_in($value,$tinyvalues); 
}

function validate_tinyints($fields_with_tinyints) {
    global $errors;
    //Expects an assoc. array
    foreach($fields_with_tinyints as $field) {
      $value = trim($_POST[$field]);
      if (!has_tinyint($value)) {
            $errors[$field] = ucfirst($field) . " should be 0 or 1.";
         }
    }
}

// * inclusion in a set
function has_inclusion_in($value, $set) {
    return in_array($value, $set);
    }
    
// * Check uniqueness in single field
function check_unique($column, $table, $data) {
    global $connection;
    global $errors;
    $queryline = "SELECT $column FROM $table WHERE $column = '$data'" ;
    $queryuni = mysqli_query($connection,$queryline);
    if (mysqli_num_rows($queryuni) > 0)
    {
        $errors[$data] = ucfirst($data) . " already exists." . ucfirst($column) . " should be unique.";
        $data = "";
        return $data;
    }
    return $data;

}


// * Check more than two records to throw error
function check_2_bookings($column, $table, $data) {
    global $connection;
    global $errors;
    $queryline = "SELECT $column FROM $table WHERE $column = '$data'" ;
    $queryuni = mysqli_query($connection,$queryline);
    if (mysqli_num_rows($queryuni) == 2)
    {
        $errors['bookings'] = "Max 2 Bookings are allowed for a date.";
        $data = "";
        return $data;
    }
    return $data;

}




// * Check uniqueness in two columns
function check_unique_2column($column1, $column2, $table, $data1, $data2) {
    global $connection;
    global $errors;
    $queryline = "SELECT * FROM $table WHERE $column1 = '$data1' AND $column2 = '$data2'" ;
    $queryuni = mysqli_query($connection,$queryline);
    if (mysqli_num_rows($queryuni) > 0)
    {
        $errors[$data1] = ucfirst($data1)."-".ucfirst($data2). " already exists." . ucfirst($column1)."-".ucfirst($column2). " should be unique.";
        $data1 = "";
        return $data1;
    }
    return $data1;

}

// * Check uniqueness in two columns
function check_attendance_value($value) {
    global $connection;
    global $errors;
    if ($value == 'P' || $value == 'A' )
    {
         return $value;
    }
    $errors[$value] = "Enter P or A";
     $value = "";
    return $value;
}

      
// * Check uniqueness in update query 
function check_unique_except_id($column, $table, $data, $primary, $updateid) {
         global $connection;
         global $errors;
         $queryline = "SELECT $column FROM $table WHERE $column = '$data' And $primary <> '$updateid'" ;
         $queryuni = mysqli_query($connection,$queryline);
          if (mysqli_num_rows($queryuni) > 0)
                {
                  $errors[$data] = ucfirst($data) . " already exists." . ucfirst($column) . " should be unique.";
                  $data = "";
                  return $data;
                }
                return $data;
                
      }


      
// * Check Foreign
function check_foreign($column, $table, $data) {
         global $connection;
         global $errors;
         $queryline = "SELECT $column FROM $table WHERE $column = '$data'" ;
         $queryuni = mysqli_query($connection,$queryline);
          if (mysqli_num_rows($queryuni) > 0)
                {
                  return $data;
                  } else {
                  $errors[$data] = ucfirst($data) ." in " . ucfirst($column) . " doesn't exist." ;
                  $data = "";
                  return $data;
                  }   
         }

         
?>