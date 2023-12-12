<?php session_start(); ?>
<?php
include_once("./backend/db.php");
$records = mysqli_query($con,"select * from brands");
?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
<form action="backend/lookbook.php" method="post" enctype="multipart/form-data">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Item Details</h2>
      	</div>
      	<div class="col-2">
      		<a href="lookbook.php" class="btn btn-danger btn-sm btn-block">Return To Lookbook</a>
          <button type="submit" class="btn btn-warning btn-sm btn-block" name="add_lookbook">Save <span data-feather="save"></span></button>
      	</div>
      </div>
      
      <div class="form_product">
        <div class="product_inputs row">


          <div class="col-md-4 col-sm-12">
              <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" class="form-control" placeholder="Enter Item Name">
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
                      <option value="<?php echo $data['brand_id'] ?>"><?php echo $data['brand_title'] ?></option>
                      <?php } ?>
                    </select>
                </div>
          </div>

          <div class="col-md-4 col-sm-12">
              <div class="form-group">
                    <label>Item Price</label>
                    <input type="number" name="item_price" class="form-control" placeholder="Enter Item Price">
                </div>
          </div>


          <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label>Image1</label>
                <input type="file" name="image1" class="form-control">
              </div>
          </div>
          <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label>Image2</label>
                <input type="file" name="image2" class="form-control">
              </div>
          </div>
          <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label>Image3</label>
                <input type="file" name="image3" class="form-control">
              </div>
          </div>
          <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label>Image4</label>
                <input type="file" name="image4" class="form-control">
              </div>
          </div>
          <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label>Image5</label>
                <input type="file" name="image5" class="form-control">
              </div>
          </div>
          <div class="col-md-4 col-sm-12">
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