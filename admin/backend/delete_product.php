<?php

include_once("./db.php");

    $id = $_GET['id'];
    $dirname = "../../shopImages/".$id;
    array_map('unlink', glob("$dirname/*.*"));
    rmdir($dirname);
    $sql = "DELETE FROM `shop` where `id`='$id'";
    mysqli_query($con, $sql) or die("database error:". mysqli_error($con)."qqq".$sql);			
    echo '<script type="text/javascript"> alert("Deleted Successfully!"); window.location.href="../products.php";</script>';  // alert message

?>