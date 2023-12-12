<?php
require_once('header.php');
include_once("admin/backend/db.php");
$id = $_GET['id'];

$getQuery = "SELECT l.*, b.brand_title FROM lookbook l, brands b where l.id='$id' and l.collection_id=b.brand_id";  

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
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt = "">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" alt = "">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image3'] ?>" alt = "">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image4'] ?>" alt = "">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image5'] ?>" alt = "">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image6'] ?>" alt = "">
        </div>
      </div>
      
    </div>
    <!-- card right -->
    <div class = "product-content">
      <div class = "img-select">
        <div class = "img-item">
          <a href = "#" data-id = "1">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "2">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "3">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image3'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "4">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image4'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "5">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image5'] ?>" alt = "">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "6">
          <img src = "./lookbookImages/<?php echo $row['id'] ?>/<?php echo $row['image6'] ?>" alt = "">
          </a>
        </div>
      </div>
      <h2 class = "product-title"><?php echo $row['item_name'] ?></h2>
      <a href = "#" class = "product-link">Book Now</a>
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
        <h2>about this item: </h2>
        <ul>
          <li>Color: <span>Black</span></li>
          <li>Collection: <span><?php echo $row['brand_title'] ?></span></li>
          <li>Shipping Area: <span>All over the world</span></li>
          <li>Shipping Fee: <span>Free</span></li>
        </ul>
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

<?php
require_once("footer.php");
?>