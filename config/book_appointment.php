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
if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['phone'])){
    // Get the submitted form data 
    $name = $_POST['name']; 
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $timezone;

    if($time < 12){ $timezone = $time . ' AM';}
    else if($time == 12){ $timezone = $time . ' PM';}
    else{ $timezone = ($time - 12) . ' PM'; }

     
    // Check whether submitted data is not empty 
    if(!empty($name) && !empty($phone) && !empty($date) && !empty($time))
    { 

        $sql = "SELECT * FROM `appointments` WHERE `appoint_date`='$date' and `appoint_time`='$time'";

        $resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
        //$row = mysqli_fetch_assoc($resultset);
        $row_cnt = $resultset->num_rows;
        if($row_cnt != 0)
        {
            $response['message'] = 'Sorry, this appointment is not available as it is already booked by someone else!';
        }
        else
        {
            // Insert form data in the database 
            $sqlQ = "INSERT INTO appointments (`name`,`email`,`phone`,`appoint_date`,`appoint_time`) VALUES (?,?,?,?,?)"; 
            $stmt = $con->prepare($sqlQ); 
            $stmt->bind_param("sssss", $name, $email, $phone, $date, $time); 
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
                $mail->Subject  =  'Appointment Book!';
                $mail->IsHTML(true);
                $mail->Body    = 'Hi ' . $name . ', Please remember your appointment date ' . $date . ' at ' . $timezone . ' , Your request is submitted successfully';
                if($mail->Send())
                {
                    $response['status'] = 1; 
                    $response['message'] = 'Appointment submitted successfully!';
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
         $response['message'] = 'Please fill all the mandatory fields (name, phone, date, and time).';
    }

}
 
 
// Return response 
echo json_encode($response);
