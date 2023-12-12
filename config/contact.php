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
if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['message'])){
    // Get the submitted form data 
    $name = $_POST['name']; 
    $email = $_POST['email'];
    $message = $_POST['message'];

     
    // Check whether submitted data is not empty 
    if(!empty($name) && !empty($email) && !empty($message))
    { 


            // Insert form data in the database 
            $sqlQ = "INSERT INTO contact (`name`,`email`,`message`) VALUES (?,?,?)"; 
            $stmt = $con->prepare($sqlQ); 
            $stmt->bind_param("sss", $name, $email, $message); 
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
                $mail->Subject  =  'Contact Request!';
                $mail->IsHTML(true);
                $mail->Body    = 'Hi ' . $name . ', Your message is sent successfully';
                if($mail->Send())
                {
                    $response['status'] = 1; 
                    $response['message'] = 'Request submitted successfully!';
                }
                else
                {
                    echo "Mail Error - >".$mail->ErrorInfo;
                }
                //
            }
        
             
    }
    else
    { 
         $response['message'] = 'Please fill all the mandatory fields (name, email, and message).';
    }

}
 
 
// Return response 
echo json_encode($response);
