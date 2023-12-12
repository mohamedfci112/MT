<?php

include_once("./db.php");

    $id = $_GET['id'];
    $dirname = "../../lookbookImages/".$id;
    array_map('unlink', glob("$dirname/*.*"));
    rmdir($dirname);
    $sql = "DELETE FROM `lookbook` where `id`='$id'";
    mysqli_query($con, $sql) or die("database error:". mysqli_error($con)."qqq".$sql);			
    echo '<script type="text/javascript"> alert("Deleted Successfully!"); window.location.href="../lookbook.php";</script>';  // alert message

?>