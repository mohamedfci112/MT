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

if ($_POST['product_id']!="" && $_POST['quantity']!="")
{
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $result = mysqli_query($con, "SELECT * FROM `shop` WHERE `id`='$product_id' and `item_quantity`>='$quantity'");
    $row = mysqli_fetch_assoc($result);
    $item_name = $row['item_name'];
    $item_code = $row['item_code'];
    $product_id = $row['id'];
    $item_price = $row['item_price'];
    $image1 = $row['image1'];

    $cartArray = array(
        $product_id=>array(
        'item_name'=>$item_name,
        'item_code'=>$item_code,
        'product_id'=>$product_id,
        'item_price'=>$item_price,
        'quantity'=>$quantity,
        'image1'=>$image1)
    );

    if(empty($_SESSION["shopping_cart"]))
    {
        $_SESSION["shopping_cart"] = $cartArray;
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
        $response['cartCount'] = $cart_count;
        $response['status'] = 1; 
        $response['message'] = 'Product is added to your cart!';
    }
    else
    {
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if(in_array($product_id,$array_keys))
        {
            $cart_count = count(array_keys($_SESSION["shopping_cart"]));
            $response['cartCount'] = $cart_count;
            $response['status'] = 2; 
            $response['message'] = 'Product is already added to your cart!';
        }
        else
        {
            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
            $cart_count = count(array_keys($_SESSION["shopping_cart"]));
            $response['cartCount'] = $cart_count;
            $response['status'] = 1; 
            $response['message'] = 'Product is added to your cart!';
        }
    }
}

    // Return response 
    echo json_encode($response);

?>