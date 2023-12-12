<?php session_start(); ?>
<?php
include_once("backend/db.php");

$records = mysqli_query($con,"select s.*, c.cat_title, b.brand_title from shop s, categories c, brands b where s.category_id=c.cat_id and s.collection_id=b.brand_id");

?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Shop List</h2>
      	</div>
      	<div class="col-2">
      		<a href="add_product.php" class="btn btn-primary btn-sm">Add Product</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Code</th>
              <th>Name</th>
              <th>Price</th>
              <th>Collection</th>
              <th>Category</th>
              <th>Quantity</th>
              <th>Size</th>
              <th>Color</th>
              <th>Pieces</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="product_list">
            <?php
              $i=0;
                while($data = mysqli_fetch_array($records))
                {
                  $i++;
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><img width="60" height="60" src="../shopImages/<?php echo $data['id'] ?>/<?php echo $data['image1'] ?>"></td>
              <td><?php echo $data['item_code'] ?></td>
              <td><?php echo $data['item_name'] ?></td>
              <td><?php echo $data['item_price'] ?></td>
              <td><?php echo $data['brand_title'] ?></td>
              <td><?php echo $data['cat_title'] ?></td>
              <td><?php echo $data['item_quantity'] ?></td>
              <td><?php echo $data['item_size'] ?></td>
              <td><?php echo $data['item_color'] ?></td>
              <td><?php echo $data['number_pieces'] ?></td>
              <td>
                <a class="btn btn-sm btn-warning" href="edit_product.php?id=<?php echo $data['id'] ?>">Edit</a>
                <a class="btn btn-sm btn-danger" onClick="javascript: return confirm('Please confirm deletion');" href="backend/delete_product.php?id=<?php echo $data['id'] ?>">Delete</a>
              </td>
            </tr>
                <?php } ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/products.js"></script>