<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
</head>
<body>

<!--start navbar-->



<nav class="navbar navbar-expand-lg navbar-light shadow-sm bg-white fixed-top">
<div class="container"> <a class="navbar-brand d-flex align-items-center" href="#">

<span class="ml-3 font-weight-bold">
<img src="./assets/img/logo.jpeg" width="150" height="50" alt="" srcset="">
</apan>
</a> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar4">
<span class="navbar-toggler-icon"></span>
</button>


<div class="collapse navbar-collapse" id="navbar4">
<ul class="navbar-nav ml-auto pl-lg-4">

  <li class="nav-item px-lg-2 active">
  <a class="nav-link" href="index.php">
    <span class="d-inline-block d-lg-none icon-width"><i class="fas fa-home"></i></span>Home</a>
  </li>
  <li class="nav-item px-lg-2">
  <a class="nav-link" href="story.php">
    <span class="d-inline-block d-lg-none icon-width"><i class="fas fa-spa"></i></span>Our Story</a> 
  </li>
  <li class="nav-item px-lg-2">
  <a class="nav-link" href="shop.php">
    <span class="d-inline-block d-lg-none icon-width"><i class="far fa-user"></i></i></span>Shop</a>
  </li>
  <li class="nav-item px-lg-2">
  <a class="nav-link" href="lookbook.php">
    <span class="d-inline-block d-lg-none icon-width"><i class="far fa-user"></i></i></span>Lookbook</a>
  </li>
  <li class="nav-item px-lg-2">
    <a class="nav-link" href="contact.php">
    <span class="d-inline-block d-lg-none icon-width"><i class="far fa-envelope"></i></span>Contact Us</a>
  </li>
  <li class="nav-item px-lg-2">
    <a class="nav-link" href="book.php">
    <span class="d-inline-block d-lg-none icon-width"><i class="far fa-envelope"></i></span>Book Appointment</a>
  </li>
</ul>

<ul class="navbar-nav ml-auto mt-3 mt-lg-0">
<li class="nav-item"> <a class="nav-link" href="cart.php">
<i class="fa fa-shopping-bag" style="font-size:22px;">
</i>
<?php
include_once("admin/backend/db.php");
session_start();
$user_email = $_SESSION['user_email'];

$getQuery = "SELECT id FROM cart where `uid`='$user_email' and `status`=0";  

$result = mysqli_query($con, $getQuery);
$row_cnt = $result->num_rows;
?>
<?php
if($row_cnt != 0) {
  $cart_count = $row_cnt;
?>
<sup class="cart_count" style="color:red;background: #d7d2d2;
    padding: 2px 7px;
    border-radius: 100%;"><b><?php echo $cart_count; ?></b></sup>
<?php
}
?>
<span class="d-lg-none ml-3">Cart</span>
</a> </li>

<li class="nav-item"> <a class="nav-link" href="wishlist.php">
<i class="fa-regular fa-heart" style="font-size:22px;"></i><span class="d-lg-none ml-3">Wishlist</span>
</a> </li>
<!--
<li class="nav-item"> <a class="nav-link" href="#">
<i class="fa-solid fa-magnifying-glass"></i><span class="d-lg-none ml-3">Search</span>
</a> </li>
<li class="nav-item"> <a class="nav-link" href="#">
  <i class="fa-solid fa-lock"></i><span class="d-lg-none ml-3">Lock</span>
</a> </li>
-->
<?php 
if($_SESSION['logged'] == 'true'){ ?>

<li class="nav-item dropdown"> 
  <a class="nav-link dropbtn" href="#">
    <i class="fa-regular fa-user" style="font-size:22px;"></i>
    <span class="d-lg-none ml-3"><?php echo $_SESSION['user_name']; ?></span>
  </a>
  <div class="dropdown-content">
    <a href="#"><?php echo $_SESSION['user_name']; ?></a>
    <a href="./config/logout.php">Logout</a>
  </div>
</li>

<?php } else{ ?>
<li class="nav-item"> <a class="nav-link" href="login.php">
<i class="fa fa-lock" style="font-size:22px;"></i><span class="d-lg-none ml-3">Login</span>
</a>
</li>
<?php } ?>
  
</ul>
</div>
</div>



</nav>


