<?php
include_once("./db.php");

if(isset($_POST['add_product'])) {

    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_short = $_POST['item_short'];
    $collection_id = $_POST['collection_id'];
    $category_id = $_POST['category_id'];
    $item_price = $_POST['item_price'];
    $item_qty = $_POST['item_qty'];
    $item_size = $_POST['item_size'];
    $item_color = $_POST['item_color'];
    $number_pieces = $_POST['number_pieces'];
    $fabric_material = $_POST['fabric_material'];
    $model_size = $_POST['model_size'];
    $description = $_POST['description'];

    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $image4 = $_FILES['image4']['name'];
    $image5 = $_FILES['image5']['name'];
    $image6 = $_FILES['image6']['name'];
    
    $sql = "SELECT * FROM `shop` WHERE `item_code`='$item_code' or `item_name`='$item_name'";

    $resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
    $row = mysqli_fetch_assoc($resultset);

    if(!$row['item_code']){	
        $sql = "INSERT INTO shop(`item_code`, `item_name`, `short_description`, `collection_id`, `category_id`, `item_price`, `item_quantity`, `item_size`,`item_color`, `number_pieces`, `fabric_material`, `model_size`, `image1`,`image2`, `image3`, `image4`, `image5`, `image6`,`description`) 
         VALUES ('$item_code', '$item_name', '$item_short', '$collection_id', '$category_id', '$item_price', '$item_qty', '$item_size', '$item_color', '$number_pieces', '$fabric_material', '$model_size', '$image1', '$image2', '$image3', '$image4', '$image5', '$image6', '$description')";
        mysqli_query($con, $sql) or die("database error:". mysqli_error($con)."qqq".$sql);	
        
        $last_id = $con->insert_id;

        if (!file_exists('../../shopImages/' . $last_id)) {
            mkdir('../../shopImages/'. $last_id, 0777, true);
        }
        $dst1 = '../../shopImages/' . $last_id . '/' . $image1;
        $dst2 = '../../shopImages/' . $last_id . '/' . $image2;
        $dst3 = '../../shopImages/' . $last_id . '/' . $image3;
        $dst4 = '../../shopImages/' . $last_id . '/' . $image4;
        $dst5 = '../../shopImages/' . $last_id . '/' . $image5;
        $dst6 = '../../shopImages/' . $last_id . '/' . $image6;
    
        $filetmp1 = $_FILES['image1']['tmp_name'];
        $filetmp2 = $_FILES['image2']['tmp_name'];
        $filetmp3 = $_FILES['image3']['tmp_name'];
        $filetmp4 = $_FILES['image4']['tmp_name'];
        $filetmp5 = $_FILES['image5']['tmp_name'];
        $filetmp6 = $_FILES['image6']['tmp_name'];

        move_uploaded_file($filetmp1, $dst1);
        move_uploaded_file($filetmp2, $dst2);
        move_uploaded_file($filetmp3, $dst3);
        move_uploaded_file($filetmp4, $dst4);
        move_uploaded_file($filetmp5, $dst5);
        move_uploaded_file($filetmp6, $dst6);

        echo '<script type="text/javascript"> alert("Added Successfully!"); window.location.href="../add_product.php";</script>';
    }
    else {				
        echo '<script type="text/javascript"> alert("This exist before!!"); window.location.href="../add_product.php";</script>';  // alert message
    }
    
}


if(isset($_POST['edit_product']))
{
    $id = $_POST['id'];

    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_short = $_POST['item_short'];
    $collection_id = $_POST['collection_id'];
    $category_id = $_POST['category_id'];
    $item_price = $_POST['item_price'];
    $item_qty = $_POST['item_qty'];
    $item_size = $_POST['item_size'];
    $item_color = $_POST['item_color'];
    $number_pieces = $_POST['number_pieces'];
    $fabric_material = $_POST['fabric_material'];
    $model_size = $_POST['model_size'];
    $description = $_POST['description'];

    $records = mysqli_query($con, "select image1,image2,image3,image4,image5,image6 from shop where id='$id'");
    $row = mysqli_fetch_assoc($records);

    if($_FILES['image1']['name'] == ""){ $image1=$row['image1']; } else {$image1 = $_FILES['image1']['name'];}
    if($_FILES['image2']['name'] == ""){ $image2=$row['image2']; } else {$image2 = $_FILES['image2']['name'];}
    if($_FILES['image3']['name'] == ""){ $image3=$row['image3']; } else {$image3 = $_FILES['image3']['name'];}
    if($_FILES['image4']['name'] == ""){ $image4=$row['image4']; } else {$image4 = $_FILES['image4']['name'];}
    if($_FILES['image5']['name'] == ""){ $image5=$row['image5']; } else {$image5 = $_FILES['image5']['name'];}
    if($_FILES['image6']['name'] == ""){ $image6=$row['image6']; } else {$image6 = $_FILES['image6']['name'];}

    $sql = "UPDATE `shop` SET `item_code`='$item_code', `item_name`='$item_name', `short_description`='$item_short', `collection_id`='$collection_id', `category_id`='$category_id', `item_price`='$item_price', `item_quantity`='$item_qty', `item_size`='$item_size',`item_color`='$item_color', `number_pieces`='$number_pieces', `fabric_material`='$fabric_material', `model_size`='$model_size', `image1`='$image1',`image2`='$image2', `image3`='$image3', `image4`='$image4', `image5`='$image5', `image6`='$image6',`description`='$description' WHERE `id`='$id'";
    mysqli_query($con, $sql) or die("database error:". mysqli_error($con)."qqq".$sql);

    if($_FILES['image1']['name'] != "")
    { 
        $dst1 = '../../shopImages/' . $id . '/' . $image1;
        $filetmp1 = $_FILES['image1']['tmp_name'];
        move_uploaded_file($filetmp1, $dst1);
    }
    if($_FILES['image2']['name'] != "")
    { 
        $dst2 = '../../shopImages/' . $id . '/' . $image2;
        $filetmp2 = $_FILES['image2']['tmp_name'];
        move_uploaded_file($filetmp2, $dst2);
    }
    if($_FILES['image3']['name'] != "")
    { 
        $dst3 = '../../shopImages/' . $id . '/' . $image3;
        $filetmp3 = $_FILES['image3']['tmp_name'];
        move_uploaded_file($filetmp3, $dst3);
    }
    if($_FILES['image4']['name'] != "")
    { 
        $dst4 = '../../shopImages/' . $id . '/' . $image4;
        $filetmp4 = $_FILES['image4']['tmp_name'];
        move_uploaded_file($filetmp4, $dst4);
    }
    if($_FILES['image5']['name'] != "")
    { 
        $dst5 = '../../shopImages/' . $id . '/' . $image5;
        $filetmp5 = $_FILES['image5']['tmp_name'];
        move_uploaded_file($filetmp5, $dst5);
    }
    if($_FILES['image6']['name'] != "")
    { 
        $dst6 = '../../shopImages/' . $id . '/' . $image6;
        $filetmp6 = $_FILES['image6']['tmp_name'];
        move_uploaded_file($filetmp6, $dst6);
    }

    echo '<script type="text/javascript"> alert("Edited Successfully!"); window.location.href="../products.php";</script>';

}

?>