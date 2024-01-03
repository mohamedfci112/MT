<?php
require_once('header.php');
include_once("admin/backend/db.php");
$id = $_GET['id'];

$getQuery = "SELECT l.*, b.brand_title FROM lookbook l, brands b where l.id='$id' and l.collection_id=b.brand_id";  

$result = mysqli_query($con, $getQuery);
?>

<link rel="stylesheet" href="./assets/css/product_details.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />



<div id="product" class="row">
    <?php
    //display the retrieved result on the webpage
    while ($row = mysqli_fetch_array($result)) {
    ?>
    <div class="product_images col-md-7">
        <!-- Slider main container -->
        <swiper-container class="mySwiper" navigation="true" effect="fade" autoplay-delay="2500" autoplay-disable-on-interaction="false">
            <?php if($row['image1'] != ''){ ?>
            <swiper-slide><img src="./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image2'] != ''){ ?>
            <swiper-slide><img src="./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image3'] != ''){ ?>
            <swiper-slide><img src="./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image3'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image4'] != ''){ ?>
            <swiper-slide><img src="./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image4'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image5'] != ''){ ?>
            <swiper-slide><img src="./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image5'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image6'] != ''){ ?>
            <swiper-slide><img src="./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image6'] ?>" alt="" /></swiper-slide>
            <?php } ?>
        </swiper-container>
    </div>

    <div class="product_details col-md-5">
        <div class="back">
            <span class="material-symbols-outlined">chevron_left</span>
           <h6>Back to <a href="lookbook.php">Lookbook</a></h6>
        </div>

        <h2><?php echo $row['item_name'] ?></h2>
        <?php if($row['item_price'] != ''){?>
            <h3><?php echo $row['item_price'] ?> EGP</h3>
        <?php } ?>

        <ul>
            <li>Collection: <span><?php echo $row['brand_title'] ?></span></li>
        </ul>
        
    </div>
    <?php
    $brandid=$row['brand_title'];
    $getQuery1 = "SELECT * FROM lookbook where collection_id = '$brandid' and id <>'$id' Limit 4";  

    $result1 = mysqli_query($con, $getQuery1);
    }
    ?>
</div>

<div class="similar container-fluid">
    <h4>Similar products</h4>
    <div class="row">
        <?php
        //display the retrieved result on the webpage
        while ($row1 = mysqli_fetch_array($result1)) {
        ?>
        <div class="col-md-3">
            <a href="lookbook_details.php?id=<?php echo $row1['id'] ?>">
                <div class="product_similar">
                    <img src="./lookbookImages/<?php echo $row1['id'] ?>/<?php echo $row1['image1'] ?>" alt="">
                    <div class="content">
                        <div class="left">
                            <span class="product_title"><?php echo $row1['item_name'] ?></span>
                        </div>
                        
                        <div class="right">
                            <?php if($row['item_price'] != ''){?>
                            <span class="product_price"><?php echo $row1['item_price'] ?> EGP</span>
                            <?php } ?>
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


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
require_once('footer.php');
?>