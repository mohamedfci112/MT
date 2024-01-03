<?php
require_once('header.php');
include_once("admin/backend/db.php");
session_start();
$user_email = $_SESSION['user_email'];

$getQuery = "SELECT s.* FROM shop s, users u, wishlist w where s.id=w.pid and u.email=w.uid and u.email='$user_email'";  

$result = mysqli_query($con, $getQuery);
?>

<link rel="stylesheet" href="./assets/css/product_details.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />


<div class="similar container">
    <h4>Wishlist Items</h4>
    <div class="row">
        <?php
        //display the retrieved result on the webpage
        while ($row1 = mysqli_fetch_array($result)) {
        ?>
        <div class="col-md-3">
            <a href="product_details.php?id=<?php echo $row1['id'] ?>">
                <div class="product_similar">
                    <img src="./shopImages/<?php echo $row1['id'] ?>/<?php echo $row1['image1'] ?>" alt="">
                    <div class="content">
                        <div class="left">
                            <span class="product_title"><?php echo $row1['item_name'] ?></span>
                        </div>
                        <div class="right">
                            <span class="product_price"><?php echo $row1['item_price'] ?> EGP</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
        }
        ?>
    </div>
</div>


<?php
require_once('footer.php');
?>