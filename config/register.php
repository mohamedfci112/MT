<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

 // Include the database config file 
 include_once 'db.php'; 

// Default response 
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
 
// If form is submitted 
if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['phone']) || isset($_POST['password'])){
    // Get the submitted form data 
    $name = $_POST['name']; 
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $password = md5($password);

     
    // Check whether submitted data is not empty 
    if(!empty($name) && !empty($email) && !empty($phone) && !empty($password))
    { 

        $sql = "SELECT * FROM `users` WHERE `email`='$email'";

        $resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
        //$row = mysqli_fetch_assoc($resultset);
        $row_cnt = $resultset->num_rows;
        if($row_cnt != 0)
        {
            $response['message'] = 'Sorry, this email is already exist by someone else!';
        }
        else
        {
            // Insert form data in the database 
            $sqlQ = "INSERT INTO users (`name`,`email`,`phone`,`password`) VALUES (?,?,?,?)"; 
            $stmt = $con->prepare($sqlQ); 
            $stmt->bind_param("ssss", $name, $email, $phone, $password); 
            $insert = $stmt->execute(); 
            if($insert)
            {
                
                //
                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';
                $mail = new PHPMailer();
                $mail->CharSet =  "utf-8";
                $mail->IsSMTP();
                // enable SMTP authentication
                //$mail->SMTPDebug = 3;
                $mail->SMTPAuth = true;                  
                // GMAIL username
                $mail->Username = "mohamedfci112@gmail.com";
                // GMAIL password
                $mail->Password = "rszahmpnquhgaruo";
                $mail->SMTPSecure = "ssl";  
                // sets GMAIL as the SMTP server
                $mail->Host = "smtp.gmail.com";
                // set the SMTP port for the GMAIL server
                $mail->Port = "465";
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ]
                ];
                $mail->From='mohamedfci112@gmail.com';
                $mail->FromName='Mariam Albossery Platform';
                $mail->AddAddress($email, $name);
                $mail->Subject  =  'Registered Successfully!';
                $mail->IsHTML(true);
                $mail->Body    = 'Hi ' . $name . ', Thank you for filling out our sign up form. We are glad that you joined us, Your account is creadted successfully';
                if($mail->Send())
                {
                    $response['status'] = 1; 
                    $response['message'] = 'Registered successfully!';
                }
                else
                {
                    echo "Mail Error - >".$mail->ErrorInfo;
                }
                //
            }
            
        }

        
             
    }
    else
    { 
         $response['message'] = 'Please fill all the mandatory fields (name, email, phone, and password).';
    }

}
 
 
// Return response 
echo json_encode($response);
