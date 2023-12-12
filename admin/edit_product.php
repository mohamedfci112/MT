<?php session_start(); ?>
<?php
include_once("./backend/db.php");
$records = mysqli_query($con,"select * from brands");
$records1 = mysqli_query($con,"select * from categories");

$id=$_GET['id'];

$records2 = mysqli_query($con, "select * from shop where id='$id'");
$row = mysqli_fetch_assoc($records2);

?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <form action="backend/products.php" method="post" enctype="multipart/form-data">
    <div class="row">
      
      <?php include "./templates/sidebar.php"; ?>

        <div class="row">
          <div class="col-10">
            <h2>Product Details</h2>
          </div>
          <div class="col-2">
            <a href="products.php" class="btn btn-danger btn-sm btn-block">Return To Products</a>
            <button type="submit" class="btn btn-warning btn-sm btn-block" name="edit_product">Edit <span data-feather="edit"></span></button>
          </div>
        </div>
        
        <div class="form_product">
          <div class="product_inputs row">
          <input type="hidden" name="id" value="<?php echo $row['id'] ?>">

            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Item Code</label>
                  <input type="text" name="item_code" value="<?php echo $row['item_code'] ?>" class="form-control" placeholder="Enter Item Code">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Item Name</label>
                  <input type="text" name="item_name" value="<?php echo $row['item_name'] ?>" class="form-control" placeholder="Enter Item Name">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Item Short Description</label>
                  <input type="text" name="item_short" value="<?php echo $row['short_description'] ?>" class="form-control" placeholder="Enter Short Description">
                </div>
            </div>

            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Collection Name</label>
                  <select class="form-control brand_list" name="collection_id">
                  <option value="">Select Collection</option>
                  <?php
                  while($data = mysqli_fetch_array($records))
                      {
                  ?>
                    <option value="<?php echo $data['brand_id'] ?>" <?php if($data['brand_id'] == $row['collection_id']){ ?> selected <?php } ?> ><?php echo $data['brand_title'] ?></option>
                      <?php } ?>
                  </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Category Name</label>
                  <select class="form-control category_list" name="category_id">
                    <option value="">Select Category</option>
                    <?php
                    while($data = mysqli_fetch_array($records1))
                        {
                    ?>
                    <option value="<?php echo $data['cat_id'] ?>" <?php if($data['cat_id'] == $row['category_id']){ ?> selected <?php } ?> ><?php echo $data['cat_title'] ?></option>
                      <?php } ?>
                  </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Item Price</label>
                  <input type="number" name="item_price" value="<?php echo $row['item_price'] ?>" class="form-control" placeholder="Enter Item Price">
                </div>
            </div>

            
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Item Qty</label>
                  <input type="number" name="item_qty" value="<?php echo $row['item_quantity'] ?>" class="form-control" placeholder="Enter Item Quantity">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Item Size</label>
                  <input type="text" name="item_size" value="<?php echo $row['item_size'] ?>" class="form-control" placeholder="Enter Item Size">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Item Color</label>
                  <input type="text" name="item_color" value="<?php echo $row['item_color'] ?>" class="form-control" placeholder="Enter Item Color">
                </div>
            </div>

            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Number of Pieces</label>
                  <input type="number" name="number_pieces" value="<?php echo $row['number_pieces'] ?>" class="form-control" placeholder="Enter Number of Pieces">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Fabric Material</label>
                  <input type="text" name="fabric_material" value="<?php echo $row['fabric_material'] ?>" class="form-control" placeholder="Enter Fabric Material">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label>Model Size</label>
                  <input type="text" name="model_size" value="<?php echo $row['model_size'] ?>" class="form-control" placeholder="Enter Model Size">
                </div>
            </div>

            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label>Item Description</label>
                  <textarea class="form-control" name="description" placeholder="Enter Item Description"><?php echo $row['description'] ?></textarea>
                </div>
            </div>

            <div class="col-md-2 col-sm-12">
                <img src="../shopImages/<?php echo $row['id'] ?>/<?php echo $row['image1'] ?>" width="100%" alt="">
                <div class="form-group">
                  <label>Image1</label>
                  <input type="file" name="image1" class="form-control">
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <img src="../shopImages/<?php echo $row['id'] ?>/<?php echo $row['image2'] ?>" width="100%" alt="">
                <div class="form-group">
                  <label>Image2</label>
                  <input type="file" name="image2" class="form-control">
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <img src="../shopImages/<?php echo $row['id'] ?>/<?php echo $row['image3'] ?>" width="100%" alt="">
                <div class="form-group">
                  <label>Image3</label>
                  <input type="file" name="image3" class="form-control">
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <img src="../shopImages/<?php echo $row['id'] ?>/<?php echo $row['image4'] ?>" width="100%" alt="">
                <div class="form-group">
                  <label>Image4</label>
                  <input type="file" name="image4" class="form-control">
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <img src="../shopImages/<?php echo $row['id'] ?>/<?php echo $row['image5'] ?>" width="100%" alt="">
                <div class="form-group">
                  <label>Image5</label>
                  <input type="file" name="image5" class="form-control">
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <img src="../shopImages/<?php echo $row['id'] ?>/<?php echo $row['image6'] ?>" width="100%" alt="">
                <div class="form-group">
                  <label>Image6</label>
                  <input type="file" name="image6" class="form-control">
                </div>
            </div>

            

          </div>
        </div>
      </main>
    </div>
  </form>
</div>


<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/products.js"></script>