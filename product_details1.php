<?php
require_once('header.php');
include_once("admin/backend/db.php");
$id = $_GET['id'];

$getQuery = "SELECT s.*, b.brand_title, c.cat_title FROM shop s, categories c, brands b where s.id='$id' and s.collection_id=b.brand_id and s.category_id=c.cat_id";  

$result = mysqli_query($con, $getQuery);
?>


<link rel="stylesheet" href="./assets/css/lookbook-details.css">
<div class = "card-wrapper">
    <?php
    //display the retrieved result on the webpage
    while ($row = mysqli_fetch_array($result)) {
    ?>
  <div class = "card">
    <!-- card left -->
    <div class = "product-imgs">
      
      <div class = "img-display">
        <div class = "img-showcase">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt = "">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" alt = "">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image3'] ?>" alt = "">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image4'] ?>" alt = "">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image5'] ?>" alt = "">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image6'] ?>" alt = "">
        </div>
      </div>
      
    </div>
    <!-- card right -->
    <div class = "product-content">
      <div class = "img-select">
        <div class = "img-item">
          <a href = "#" data-id = "1">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "2">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "3">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image3'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "4">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image4'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "5">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image5'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "6">
          <img src = "./shopImages/<?php echo $row['id'] ?>/<?php echo $row['image6'] ?>" alt = "">
          </a>
        </div>
      </div>
      <h2 class = "product-title"><?php echo $row['item_name'] ?></h2>
      <div class="statusMsg"></div>
      <form id="wishlist_form">
        <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">
        <button class="product-link btn" style="font-size:15px;" type="submit"><i class="fa-regular fa-heart"></i> Wishlist</button>
      </form>
      <div class = "product-rating">
        <i class = "fas fa-star"></i>
        <i class = "fas fa-star"></i>
        <i class = "fas fa-star"></i>
        <i class = "fas fa-star"></i>
        <i class = "fas fa-star-half-alt"></i>
        <span>4.7(21)</span>
      </div>

      <div class = "product-price">
        <p class = "new-price">Price: <span><?php echo $row['item_price'] ?> EGP</span></p>
      </div>

      <div class = "product-detail">
        <h2>about this product: </h2>
        <h5><?php echo $row['short_description'] ?></h5>
        <p><?php echo $row['description'] ?></p>
        <ul>
          <li>Color: <span><?php echo $row['item_color'] ?></span></li>
          <li>Available: <span><?=$row['item_quantity']?> in stock</span></li>
          <li>Collection: <span><?php echo $row['brand_title'] ?></span></li>
          <li>Category: <span><?php echo $row['cat_title'] ?></span></li>
          <li>Shipping Area: <span>All over the world</span></li>
          <li>Shipping Fee: <span>Free</span></li>
        </ul>
      </div>

      <div class = "purchase-info">
      <div class="statusMsg1"></div>
        <form id="cart_form">
            <input type="number" name="quantity" value="1" min="1" max="<?=$row['item_quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$row['id']?>">
            <button type = "submit" class = "btn">
              Add to Cart <i class = "fas fa-shopping-cart cart_btn"></i>
            </button>
        </form>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<script>
  const imgs = document.querySelectorAll('.img-select a');
  const imgBtns = [...imgs];
  let imgId = 1;

  imgBtns.forEach((imgItem) => {
      imgItem.addEventListener('click', (event) => {
          event.preventDefault();
          imgId = imgItem.dataset.id;
          slideImage();
      });
  });

  function slideImage(){
      const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

      document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
  }

  window.addEventListener('resize', slideImage);
</script>

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
                    $('.statusMsg1').html('');
                    if(response.status == 1){
                        $('#cart_form')[0].reset();
                        $('.statusMsg1').html('<p class="alert alert-success">'+response.message+'</p>');
                        $('.cart_count').html(response.cartCount);
                    }
                    else if(response.status == 2){
                      $('.statusMsg1').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }
                    
                    else{
                        $('.statusMsg1').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }

                    $('#cart_form').css("opacity","");
                    $(".cart_btn").removeAttr("disabled");
                }
            });
        });
    });
</script>




<?php
require_once("footer.php");
?>