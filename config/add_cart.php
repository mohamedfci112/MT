<?php

session_start();
// Include the database config file 
include_once 'db.php';

// Default response 
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.',
    'cartCount' => 0
); 

if($_SESSION['logged'] == '')
{
    // Return response
    $response['status'] = 2; 
    $response['message'] = 'Not Authorized.!';
}

else
{
    if ($_POST['product_id']!="" && $_POST['quantity']!="")
    {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $result = mysqli_query($con, "SELECT * FROM `shop` WHERE `id`='$product_id' and `item_quantity`>='$quantity'");
        $row_cnt = $result->num_rows;
        if($row_cnt == 0)
        {
            $response['message'] = 'Sorry, this product is not available in our stock now!';
        }
        else
        {
            $uid = $_SESSION['user_email'];

            $sql = "SELECT * FROM `cart` WHERE `pid`='$product_id' and `uid`='$uid' and `status`=0";

            $resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
            $row_cnt1 = $resultset->num_rows;
            if($row_cnt1 != 0)
            {
                $response['message'] = 'This product is already added in your cart!';
            }
            else
            {
                // Insert form data in the database 
                $sqlQ = "INSERT INTO cart (`pid`,`uid`,`quantity`) VALUES (?,?,?)"; 
                $stmt = $con->prepare($sqlQ); 
                $stmt->bind_param("sss", $product_id, $uid, $quantity);
                $insert = $stmt->execute(); 
                if($insert)
                {
                    $response['status'] = 1; 
                    $response['message'] = 'Added successfully!';
                }
                //
            }
        }

    }

}
// Return response 
echo json_encode($response);

?>