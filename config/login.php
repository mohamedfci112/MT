<?php
 // Include the database config file 
 include_once 'db.php'; 

// Default response 
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
 
// If form is submitted 
if(isset($_POST['email']) || isset($_POST['password'])){
    // Get the submitted form data 
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password = md5($password);

     
    // Check whether submitted data is not empty 
    if(!empty($email) && !empty($password))
    {

        $sql = "SELECT * FROM `users` WHERE `email`='$email' and `password`='$password'";

        $resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
        $row = mysqli_fetch_assoc($resultset);
       
        $row_cnt = $resultset->num_rows;
        if($row_cnt == 0)
        {
            $response['message'] = 'Sorry, this account is not exist!';
        }
        else
        {
            //
            session_start();
            $_SESSION['logged'] = 'true';
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_phone'] = $row['phone'];
            $response['status'] = 1; 
            $response['message'] = 'Registered successfully!';
        }
             
    }
    else
    { 
         $response['message'] = 'Please fill all the mandatory fields (email and password).';
    }

}
 
 
// Return response 
echo json_encode($response);
