<?php
include_once("./db.php");

if(isset($_POST['add_lookbook'])) {

    $item_name = $_POST['item_name'];
    $collection_id = $_POST['collection_id'];
    $item_price = $_POST['item_price'];

    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $image4 = $_FILES['image4']['name'];
    $image5 = $_FILES['image5']['name'];
    $image6 = $_FILES['image6']['name'];
    
    $sql = "SELECT * FROM `lookbook` WHERE `item_name`='$item_name'";

    $resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
    $row = mysqli_fetch_assoc($resultset);

    if(!$row['item_code']){	
        $sql = "INSERT INTO lookbook(`item_name`, `collection_id`, `item_price`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`) 
         VALUES ('$item_name', '$collection_id', '$item_price', '$image1', '$image2', '$image3', '$image4', '$image5', '$image6')";
        mysqli_query($con, $sql) or die("database error:". mysqli_error($con)."qqq".$sql);	
        
        $last_id = $con->insert_id;

        if (!file_exists('../../lookbookImages/' . $last_id)) {
            mkdir('../../lookbookImages/'. $last_id, 0777, true);
        }
        $dst1 = '../../lookbookImages/' . $last_id . '/' . $image1;
        $dst2 = '../../lookbookImages/' . $last_id . '/' . $image2;
        $dst3 = '../../lookbookImages/' . $last_id . '/' . $image3;
        $dst4 = '../../lookbookImages/' . $last_id . '/' . $image4;
        $dst5 = '../../lookbookImages/' . $last_id . '/' . $image5;
        $dst6 = '../../lookbookImages/' . $last_id . '/' . $image6;
    
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

        echo '<script type="text/javascript"> alert("Added Successfully!"); window.location.href="../add_lookbook.php";</script>';
    }
    else {				
        echo '<script type="text/javascript"> alert("This exist before!!"); window.location.href="../add_lookbook.php";</script>';  // alert message
    }
    
}


if(isset($_POST['edit_lookbook']))
{
    $id = $_POST['id'];

    $item_name = $_POST['item_name'];
    $collection_id = $_POST['collection_id'];
    $item_price = $_POST['item_price'];

    $records = mysqli_query($con, "select image1,image2,image3,image4,image5,image6 from lookbook where id='$id'");
    $row = mysqli_fetch_assoc($records);

    if($_FILES['image1']['name'] == ""){ $image1=$row['image1']; } else {$image1 = $_FILES['image1']['name'];}
    if($_FILES['image2']['name'] == ""){ $image2=$row['image2']; } else {$image2 = $_FILES['image2']['name'];}
    if($_FILES['image3']['name'] == ""){ $image3=$row['image3']; } else {$image3 = $_FILES['image3']['name'];}
    if($_FILES['image4']['name'] == ""){ $image4=$row['image4']; } else {$image4 = $_FILES['image4']['name'];}
    if($_FILES['image5']['name'] == ""){ $image5=$row['image5']; } else {$image5 = $_FILES['image5']['name'];}
    if($_FILES['image6']['name'] == ""){ $image6=$row['image6']; } else {$image6 = $_FILES['image6']['name'];}

    $sql = "UPDATE `lookbook` SET `item_name`='$item_name', `collection_id`='$collection_id', `item_price`='$item_price', `image1`='$image1',`image2`='$image2', `image3`='$image3', `image4`='$image4', `image5`='$image5', `image6`='$image6' WHERE `id`='$id'";
    mysqli_query($con, $sql) or die("database error:". mysqli_error($con)."qqq".$sql);

    if($_FILES['image1']['name'] != "")
    { 
        $dst1 = '../../lookbookImages/' . $id . '/' . $image1;
        $filetmp1 = $_FILES['image1']['tmp_name'];
        move_uploaded_file($filetmp1, $dst1);
    }
    if($_FILES['image2']['name'] != "")
    { 
        $dst2 = '../../lookbookImages/' . $id . '/' . $image2;
        $filetmp2 = $_FILES['image2']['tmp_name'];
        move_uploaded_file($filetmp2, $dst2);
    }
    if($_FILES['image3']['name'] != "")
    { 
        $dst3 = '../../lookbookImages/' . $id . '/' . $image3;
        $filetmp3 = $_FILES['image3']['tmp_name'];
        move_uploaded_file($filetmp3, $dst3);
    }
    if($_FILES['image4']['name'] != "")
    { 
        $dst4 = '../../lookbookImages/' . $id . '/' . $image4;
        $filetmp4 = $_FILES['image4']['tmp_name'];
        move_uploaded_file($filetmp4, $dst4);
    }
    if($_FILES['image5']['name'] != "")
    { 
        $dst5 = '../../lookbookImages/' . $id . '/' . $image5;
        $filetmp5 = $_FILES['image5']['tmp_name'];
        move_uploaded_file($filetmp5, $dst5);
    }
    if($_FILES['image6']['name'] != "")
    { 
        $dst6 = '../../lookbookImages/' . $id . '/' . $image6;
        $filetmp6 = $_FILES['image6']['tmp_name'];
        move_uploaded_file($filetmp6, $dst6);
    }

    echo '<script type="text/javascript"> alert("Edited Successfully!"); window.location.href="../lookbook.php";</script>';

}


?>