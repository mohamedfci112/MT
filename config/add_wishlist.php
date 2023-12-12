<?php

// Include the database config file 
include_once 'db.php'; 

//
session_start();

// Default response 
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 


if($_SESSION['logged'] == '')
{
    // Return response
    $response['status'] = 2; 
    $response['message'] = 'Not Authorized.!';
    echo json_encode($response);
}
else
{
    // If form is submitted 
    if(isset($_POST['pid'])){
        // Get the submitted form data 
        $pid = $_POST['pid']; 
        $uid = $_SESSION['user_email'];

        $sql = "SELECT * FROM `wishlist` WHERE `pid`='$pid' and `uid`='$uid'";

        $resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
        //$row = mysqli_fetch_assoc($resultset);
        $row_cnt = $resultset->num_rows;
        if($row_cnt != 0)
        {
            $response['message'] = 'Sorry, this product is already added in wishlist!';
        }
        else
        {
            // Check whether submitted data is not empty 
            if(!empty($pid))
            { 
                // Insert form data in the database 
                $sqlQ = "INSERT INTO wishlist (`pid`,`uid`) VALUES (?,?)"; 
                $stmt = $con->prepare($sqlQ); 
                $stmt->bind_param("ss", $pid, $uid);
                $insert = $stmt->execute(); 
                if($insert)
                {
                    $response['status'] = 1; 
                    $response['message'] = 'Added successfully!';
                }
                //
            }
            else
            { 
                $response['message'] = 'Faild please try again.';
            }
        }

        

    }
    
    // Return response 
    echo json_encode($response);
}


