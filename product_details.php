<?php
require_once('header.php');
include_once("admin/backend/db.php");
$id = $_GET['id'];

$getQuery = "SELECT s.*, b.brand_title, c.cat_title FROM shop s, categories c, brands b where s.id='$id' and s.collection_id=b.brand_id and s.category_id=c.cat_id";  

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
            <swiper-slide><img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image2'] != ''){ ?>
            <swiper-slide><img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image3'] != ''){ ?>
            <swiper-slide><img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image3'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image4'] != ''){ ?>
            <swiper-slide><img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image4'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image5'] != ''){ ?>
            <swiper-slide><img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image5'] ?>" alt="" /></swiper-slide>
            <?php } if($row['image6'] != ''){ ?>
            <swiper-slide><img src="./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image6'] ?>" alt="" /></swiper-slide>
            <?php } ?>
        </swiper-container>
    </div>

    <div class="product_details col-md-5">
        <div class="back">
            <span class="material-symbols-outlined">chevron_left</span>
           <h6>Back to <a href="shop.php">Shop</a></h6>
        </div>

        <h2><?php echo $row['item_name'] ?></h2>
        <h3><?php echo $row['item_price'] ?> EGP</h3>

        <div class="about">
            <p>Availability :<span><?=$row['item_quantity']?> In stock</span></p>
            <p>Product Code : <span>#<?=$row['item_code']?></span></p>   
            <p>Color : <span><?php echo $row['item_color'] ?></span> </p>
        </div>

        <p><?php echo $row['description'] ?></p>
        <ul>
            <li><?php echo $row['short_description'] ?></li>
            <li>Collection: <span><?php echo $row['brand_title'] ?></span></li>
            <li>Category: <span><?php echo $row['cat_title'] ?></span></li>
        </ul>
        <div class="statusMsg"></div>
        <div class="cta">
            <form id="cart_form">
                <input type="hidden" name="quantity" value="1" min="1" max="<?=$row['item_quantity']?>" placeholder="Quantity" required>
                <input type="hidden" name="product_id" value="<?=$row['id']?>">
                <button type = "submit" class = "btn btn_primary">
                <i class = "fas fa-shopping-cart cart_btn">cart</i> Add to Cart
                </button>
            </form>
            <form id="wishlist_form">
                <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">
                <button class="btn btn_outline_secondary" type="submit">
                <span class="material-symbols-outlined">favorite</span>add to wishlist
                </button>
            </form>
            
        </div>
    </div>
    <?php
    $catid=$row['category_id'];
    $getQuery1 = "SELECT * FROM shop where category_id = '$catid' and id <>'$id' Limit 4";  

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


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(e){
        
        // Submit form data via Ajax
        $("#wishlist_form").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'config/add_wishlist.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.product-link').attr("disabled","disabled");
                    $('#wishlist_form').css("opacity",".5");
                },
                success: function(response){
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#wishlist_form')[0].reset();
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }
                    else if(response.status == 2){
                      const queryString = window.location.search;
                      const urlParams = new URLSearchParams(queryString);
                      const id = urlParams.get('id');
                      window.location.href="login.php?redirect_url=true&page_link=product_details.php?id="+id;
                    }
                    
                    else{
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }

                    $('#wishlist_form').css("opacity","");
                    $(".product-link").removeAttr("disabled");
                }
            });
        });

        //

        // Submit form data via Ajax
        $("#cart_form").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'config/add_cart.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.cart_btn').attr("disabled","disabled");
                    $('#cart_form').css("opacity",".5");
                },
                success: function(response){
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#cart_form')[0].reset();
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                        $('.cart_count').html(response.cartCount);
                    }
                    else if(response.status == 2){
                      $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }
                    
                    else{
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }

                    $('#cart_form').css("opacity","");
                    $(".cart_btn").removeAttr("disabled");
                }
            });
        });
    });
</script>
<?php
require_once('footer.php');
?>